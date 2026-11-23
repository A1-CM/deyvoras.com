<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractObligation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __invoke(Request $request): View
    {
        $days = in_array((int) $request->query('days', 90), [30, 90, 365], true)
            ? (int) $request->query('days', 90)
            : 90;
        $organizationId = $request->user()->organization_id;
        $base = Contract::where('organization_id', $organizationId);
        $expiring = (clone $base)->where('status', '!=', 'archived')->whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [today(), today()->addDays($days)])
            ->orderBy('expiry_date')->with('creator')->get();
        $obligations = ContractObligation::whereHas('contract', fn ($query) => $query->where('organization_id', $organizationId))
            ->where('status', 'open')->with(['contract', 'assignee'])->orderByRaw('due_at is null')->orderBy('due_at')->limit(20)->get();
        $categories = (clone $base)->where('status', '!=', 'archived')
            ->selectRaw('document_type, count(*) as total')->groupBy('document_type')->orderByDesc('total')->get();
        $activeCount = (clone $base)->where('status', '!=', 'archived')->count();

        return view('workspace.reports.index', [
            'days' => $days,
            'activeCount' => $activeCount,
            'reviewCount' => (clone $base)->where('review_status', 'needs_review')->where('status', '!=', 'archived')->count(),
            'expiryCount' => $expiring->count(),
            'overdueCount' => ContractObligation::whereHas('contract', fn ($query) => $query->where('organization_id', $organizationId))
                ->where('status', 'open')->whereNotNull('due_at')->whereDate('due_at', '<', today())->count(),
            'categories' => $categories,
            'expiring' => $expiring,
            'obligations' => $obligations,
        ]);
    }
}
