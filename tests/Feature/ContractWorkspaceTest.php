<?php

namespace Tests\Feature;

use App\Models\Contract;
use App\Models\Organization;
use App\Models\User;
use App\Models\WorkspaceInvitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContractWorkspaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_person_can_create_an_organization_workspace(): void
    {
        $response = $this->post('/register', [
            'name' => 'Alex Lee',
            'organization' => 'Northstar Studio',
            'email' => 'alex@example.test',
            'password' => 'correct-horse-battery',
            'password_confirmation' => 'correct-horse-battery',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('organizations', ['name' => 'Northstar Studio']);
        $this->assertDatabaseHas('users', ['email' => 'alex@example.test', 'role' => 'owner']);
        $this->get(route('dashboard'))->assertOk()->assertSee('Northstar Studio');
        $this->post(route('logout'))->assertRedirect(route('home'));
        $this->post(route('login.store'), [
            'email' => 'alex@example.test',
            'password' => 'correct-horse-battery',
        ])->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
    }

    public function test_an_owner_can_add_a_contract_and_review_its_records(): void
    {
        Storage::fake('local');
        [$organization, $user] = $this->createWorkspace();
        $this->actingAs($user);

        $this->post(route('contracts.store'), [
            'title' => 'Cloud services agreement',
            'document_type' => 'Service agreement',
            'counterparty' => 'Northstar Systems',
            'contract_number' => 'NSA-2026-041',
            'effective_date' => '2026-01-01',
            'expiry_date' => '2027-01-01',
            'notice_days' => '30',
            'summary' => 'Annual hosting services, subject to source verification.',
            'document' => UploadedFile::fake()->createWithContent('cloud-terms.txt', 'Source agreement text.'),
        ])->assertRedirect();

        $contract = Contract::firstOrFail();
        $this->assertSame($organization->id, $contract->organization_id);
        Storage::disk('local')->assertExists($contract->document_path);
        $firstDocumentPath = $contract->document_path;
        $this->put(route('contracts.update', $contract), [
            'title' => $contract->title,
            'document_type' => $contract->document_type,
            'counterparty' => $contract->counterparty,
            'contract_number' => $contract->contract_number,
            'effective_date' => '2026-01-01',
            'expiry_date' => '2027-01-01',
            'notice_days' => '30',
            'summary' => $contract->summary,
            'document' => UploadedFile::fake()->createWithContent('cloud-terms-revised.txt', 'Revised source agreement text.'),
        ])->assertRedirect();
        $contract->refresh();
        $this->assertSame(2, $contract->documentVersions()->count());
        $this->assertSame(2, $contract->documentVersions()->max('version_number'));
        Storage::disk('local')->assertExists($firstDocumentPath);
        $this->get(route('contracts.versions.download', [$contract, $contract->documentVersions()->where('version_number', 1)->firstOrFail()]))->assertOk();

        $this->post(route('clauses.store', $contract), [
            'category' => 'Renewal',
            'title' => 'Automatic renewal',
            'excerpt' => 'Renews for another year unless notice is given.',
        ])->assertRedirect();
        $clause = $contract->clauses()->firstOrFail();
        $this->post(route('clauses.verify', [$contract, $clause]))->assertRedirect();
        $this->assertDatabaseHas('contract_clauses', ['id' => $clause->id, 'verification_status' => 'verified']);
        $this->put(route('clauses.update', [$contract, $clause]), [
            'category' => 'Renewal',
            'title' => 'Updated renewal term',
            'excerpt' => 'Renews for another year unless written notice is given.',
            'notes' => 'Updated by reviewer.',
        ])->assertRedirect();
        $this->assertDatabaseHas('contract_clauses', [
            'id' => $clause->id,
            'title' => 'Updated renewal term',
            'verification_status' => 'unverified',
        ]);
        $this->post(route('clauses.verify', [$contract, $clause]))->assertRedirect();

        $this->post(route('obligations.store', $contract), [
            'title' => 'Send renewal notice',
            'assigned_to_user_id' => User::factory()->create([
                'organization_id' => $organization->id,
                'role' => 'contract_manager',
            ])->id,
            'due_at' => '2026-11-30',
        ])->assertRedirect();
        $obligation = $contract->obligations()->firstOrFail();
        $this->assertNotNull($obligation->assigned_to_user_id);
        $this->post(route('obligations.toggle', [$contract, $obligation]))->assertRedirect();
        $this->assertDatabaseHas('contract_obligations', ['id' => $obligation->id, 'status' => 'complete']);

        $this->post(route('contracts.review', $contract))->assertRedirect();
        $this->assertDatabaseHas('contracts', ['id' => $contract->id, 'review_status' => 'reviewed']);
        $this->get(route('contracts.show', $contract))->assertOk()->assertSee('Cloud services agreement')->assertSee('Automatic renewal');
        $this->get(route('contracts.download', $contract))->assertOk();
        $this->get(route('activity.index'))->assertOk()->assertSee('Contract details updated')->assertSee('Cloud services agreement');
    }

    public function test_contracts_and_private_files_are_scoped_to_the_signed_in_organization(): void
    {
        [$organization, $user] = $this->createWorkspace('One team');
        $otherOrganization = Organization::create(['name' => 'Another team']);
        $otherUser = User::factory()->create(['organization_id' => $otherOrganization->id, 'role' => 'owner']);
        $contract = Contract::create([
            'organization_id' => $otherOrganization->id,
            'created_by' => $otherUser->id,
            'title' => 'Private agreement',
            'document_type' => 'Other',
            'document_path' => 'contracts/private/terms.txt',
            'document_name' => 'terms.txt',
        ]);
        $version = $contract->documentVersions()->create([
            'uploaded_by' => $otherUser->id,
            'version_number' => 1,
            'document_path' => 'contracts/private/terms.txt',
            'document_name' => 'terms.txt',
        ]);

        $this->actingAs($user);
        $this->get(route('contracts.show', $contract))->assertNotFound();
        $this->get(route('contracts.download', $contract))->assertNotFound();
        $this->get(route('contracts.versions.download', [$contract, $version]))->assertNotFound();
        $this->put(route('contracts.update', $contract), ['title' => 'Changed'])->assertNotFound();
        $this->assertDatabaseHas('contracts', ['id' => $contract->id, 'title' => 'Private agreement']);
    }

    public function test_read_only_members_cannot_change_contract_records(): void
    {
        [$organization] = $this->createWorkspace('Read-only team');
        $member = User::factory()->create(['organization_id' => $organization->id, 'role' => 'member']);
        $this->actingAs($member);

        $this->get(route('contracts.create'))->assertForbidden();
        $this->post(route('contracts.store'), [
            'title' => 'Blocked contract',
            'document_type' => 'Other',
        ])->assertForbidden();
    }

    public function test_a_team_can_compare_its_records_and_view_workspace_reports(): void
    {
        [$organization, $user] = $this->createWorkspace('Comparison team');
        $first = Contract::create([
            'organization_id' => $organization->id,
            'created_by' => $user->id,
            'title' => 'Supplier terms',
            'document_type' => 'Supplier agreement',
            'counterparty' => 'Northstar Supply',
            'expiry_date' => today()->addDays(20),
        ]);
        $second = Contract::create([
            'organization_id' => $organization->id,
            'created_by' => $user->id,
            'title' => 'Service terms',
            'document_type' => 'Service agreement',
            'counterparty' => 'Fieldwork Systems',
        ]);
        $otherOrganization = Organization::create(['name' => 'Other comparison team']);
        $otherUser = User::factory()->create(['organization_id' => $otherOrganization->id, 'role' => 'owner']);
        $privateContract = Contract::create([
            'organization_id' => $otherOrganization->id,
            'created_by' => $otherUser->id,
            'title' => 'Another team agreement',
            'document_type' => 'Other',
        ]);

        $this->actingAs($user);
        $this->get(route('contracts.compare', ['ids' => [$first->id, $second->id]]))
            ->assertOk()->assertSee('Supplier terms')->assertSee('Service terms');
        $this->get(route('contracts.compare', ['ids' => [$first->id, $privateContract->id]]))->assertNotFound();
        $this->get(route('reports.index'))->assertOk()->assertSee('Agreements by type')->assertSee('Renewals & expiries', false);
    }

    public function test_an_owner_can_invite_a_member_and_the_single_use_link_creates_scoped_access(): void
    {
        [$organization, $owner] = $this->createWorkspace('Invitation team');
        $this->actingAs($owner);

        $response = $this->post(route('team.invitations.store'), [
            'email' => 'reviewer@example.test',
            'role' => 'legal_reviewer',
        ])->assertRedirect(route('team.index'))
            ->assertSessionHas('invitation_url')
            ->assertSessionHas('invited_email', 'reviewer@example.test');

        $invitation = WorkspaceInvitation::firstOrFail();
        $this->assertSame($organization->id, $invitation->organization_id);
        $this->assertSame(64, strlen($invitation->token_hash));
        $this->assertNotSame('reviewer@example.test', $invitation->token_hash);
        $inviteUrl = $this->app['session']->get('invitation_url');
        $token = basename(parse_url($inviteUrl, PHP_URL_PATH));

        $this->get(route('invites.accept', $token))->assertOk()->assertSee('reviewer@example.test');
        $this->post(route('invites.accept.store', $token), [
            'name' => 'Rae Reviewer',
            'password' => 'another-secure-password',
            'password_confirmation' => 'another-secure-password',
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'organization_id' => $organization->id,
            'email' => 'reviewer@example.test',
            'role' => 'legal_reviewer',
        ]);
        $this->assertDatabaseMissing('workspace_invitations', ['id' => $invitation->id, 'accepted_at' => null]);
        $this->assertDatabaseHas('organization_activities', ['organization_id' => $organization->id, 'event' => 'member_joined']);
        $this->get(route('team.index'))->assertForbidden();
        $this->get(route('contracts.create'))->assertOk();
    }

    private function createWorkspace(string $name = 'Test organization'): array
    {
        $organization = Organization::create(['name' => $name]);
        $user = User::factory()->create(['organization_id' => $organization->id, 'role' => 'owner']);

        return [$organization, $user];
    }
}
