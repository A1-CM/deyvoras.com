<?php

namespace App\Http\Controllers;

use App\Models\OrganizationActivity;
use App\Models\User;
use App\Models\WorkspaceInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(Request $request): View
    {
        $organizationId = $request->user()->organization_id;

        return view('workspace.team.index', [
            'members' => User::where('organization_id', $organizationId)->orderBy('name')->get(),
            'invitations' => WorkspaceInvitation::where('organization_id', $organizationId)
                ->whereNull('accepted_at')->where('expires_at', '>', now())->latest()->get(),
        ]);
    }

    public function invite(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['legal_reviewer', 'contract_manager', 'member'])],
        ]);

        $token = Str::random(64);
        $invitation = WorkspaceInvitation::create([
            'organization_id' => $request->user()->organization_id,
            'invited_by' => $request->user()->id,
            'email' => strtolower($validated['email']),
            'role' => $validated['role'],
            'token_hash' => hash('sha256', $token),
            'expires_at' => now()->addDays(7),
        ]);
        OrganizationActivity::create([
            'organization_id' => $request->user()->organization_id,
            'user_id' => $request->user()->id,
            'event' => 'member_invited',
            'description' => "Invited {$invitation->email} as a ".str_replace('_', ' ', $invitation->role).'.',
        ]);

        return redirect()->route('team.index')
            ->with('status', 'Invitation link created. Copy it and share it with the new member.')
            ->with('invited_email', $invitation->email)
            ->with('invitation_url', route('invites.accept', $token));
    }

    public function updateRole(Request $request, int $user): RedirectResponse
    {
        $member = User::where('organization_id', $request->user()->organization_id)->findOrFail($user);
        abort_if($member->role === 'owner', 403);
        $validated = $request->validate(['role' => ['required', Rule::in(['legal_reviewer', 'contract_manager', 'member'])]]);
        $oldRole = $member->role;
        $member->update(['role' => $validated['role']]);
        OrganizationActivity::create([
            'organization_id' => $request->user()->organization_id,
            'user_id' => $request->user()->id,
            'event' => 'member_role_updated',
            'description' => "Changed {$member->name}'s role from ".str_replace('_', ' ', $oldRole).' to '.str_replace('_', ' ', $member->role).'.',
        ]);

        return back()->with('status', 'Workspace role updated.');
    }

    public function cancelInvitation(Request $request, int $invitation): RedirectResponse
    {
        $invite = WorkspaceInvitation::where('organization_id', $request->user()->organization_id)->findOrFail($invitation);
        $invite->delete();
        OrganizationActivity::create([
            'organization_id' => $request->user()->organization_id,
            'user_id' => $request->user()->id,
            'event' => 'invitation_cancelled',
            'description' => "Cancelled the workspace invitation for {$invite->email}.",
        ]);

        return back()->with('status', 'Invitation cancelled.');
    }

    public function showAccept(string $token): View
    {
        return view('auth.accept-invitation', ['invitation' => $this->findInvitation($token), 'token' => $token]);
    }

    public function accept(Request $request, string $token): RedirectResponse
    {
        $invitation = $this->findInvitation($token);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'password' => ['required', 'confirmed', Password::min(10)],
        ]);

        $user = DB::transaction(function () use ($invitation, $validated) {
            $user = User::create([
                'organization_id' => $invitation->organization_id,
                'role' => $invitation->role,
                'name' => $validated['name'],
                'email' => $invitation->email,
                'email_verified_at' => now(),
                'password' => $validated['password'],
            ]);
            $invitation->update(['accepted_at' => now()]);
            OrganizationActivity::create([
                'organization_id' => $invitation->organization_id,
                'user_id' => $user->id,
                'event' => 'member_joined',
                'description' => "{$user->name} joined the workspace as a ".str_replace('_', ' ', $user->role).'.',
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('status', 'You joined '.$user->organization->name.'.');
    }

    private function findInvitation(string $token): WorkspaceInvitation
    {
        return WorkspaceInvitation::with('organization')
            ->where('token_hash', hash('sha256', $token))
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->firstOrFail();
    }
}
