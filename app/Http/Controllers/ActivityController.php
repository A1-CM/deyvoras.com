<?php

namespace App\Http\Controllers;

use App\Models\ContractActivity;
use App\Models\OrganizationActivity;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function __invoke(Request $request): View
    {
        $organizationId = $request->user()->organization_id;
        $contractActivities = ContractActivity::whereHas('contract', fn ($query) => $query->where('organization_id', $organizationId))
            ->with(['contract', 'user'])
            ->latest()->limit(50)->get();
        $teamActivities = OrganizationActivity::where('organization_id', $organizationId)
            ->with('user')->latest()->limit(50)->get();
        $activities = $contractActivities->concat($teamActivities)->sortByDesc('created_at')->take(50)->values();

        return view('workspace.activity.index', compact('activities'));
    }
}
