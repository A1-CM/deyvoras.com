<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractObligation;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $organizationId = auth()->user()->organization_id;
        $contracts = Contract::where('organization_id', $organizationId);
        $upcoming = Contract::where('organization_id', $organizationId)
            ->where('status', '!=', 'archived')
            ->whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [today(), today()->addDays(90)])
            ->orderBy('expiry_date')
            ->limit(5)
            ->get();

        return view('workspace.dashboard', [
            'contractCount' => (clone $contracts)->where('status', '!=', 'archived')->count(),
            'reviewCount' => (clone $contracts)->where('review_status', 'needs_review')->count(),
            'obligationCount' => ContractObligation::whereHas('contract', fn ($query) => $query->where('organization_id', $organizationId))
                ->where('status', 'open')->count(),
            'upcoming' => $upcoming,
            'recent' => (clone $contracts)->with('creator')->latest()->limit(5)->get(),
            'today' => Carbon::today(),
        ]);
    }
}
