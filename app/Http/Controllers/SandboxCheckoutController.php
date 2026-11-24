<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SandboxCheckoutController extends Controller
{
    private const PLANS = [
        'team' => ['name' => 'Team', 'monthly' => 29, 'yearly' => 290],
        'business' => ['name' => 'Business', 'monthly' => 99, 'yearly' => 990],
    ];

    public function show(Request $request, string $plan): View
    {
        abort_unless(isset(self::PLANS[$plan]), 404);

        $billing = $request->query('billing', 'monthly');
        abort_unless(in_array($billing, ['monthly', 'yearly'], true), 404);

        return view('site.checkout', [
            'planKey' => $plan,
            'plan' => self::PLANS[$plan],
            'billing' => $billing,
            'amount' => self::PLANS[$plan][$billing],
        ]);
    }

    public function confirm(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'plan' => ['required', Rule::in(array_keys(self::PLANS))],
            'billing' => ['required', Rule::in(['monthly', 'yearly'])],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:254'],
        ]);

        $plan = self::PLANS[$data['plan']];

        return redirect()->route('checkout.complete')->with('sandbox_checkout', [
            'name' => $data['name'],
            'plan' => $plan['name'],
            'billing' => $data['billing'],
            'amount' => $plan[$data['billing']],
        ]);
    }

    public function complete(): View
    {
        return view('site.checkout-complete', [
            'checkout' => session('sandbox_checkout'),
        ]);
    }
}
