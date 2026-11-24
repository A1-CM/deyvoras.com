<?php

namespace App\Http\Controllers;

use App\Mail\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('site.contact');
    }

    public function send(Request $request): RedirectResponse
    {
        if ($request->filled('website')) {
            return back()->with('status', 'Thanks for reaching out. Your note has been received.');
        }

        $siteKey = config('services.turnstile.site_key');
        $secretKey = config('services.turnstile.secret_key');

        if (! $siteKey || ! $secretKey) {
            if (! app()->environment(['local', 'testing'])) {
                return back()->withInput()->withErrors([
                    'contact' => 'Contact form verification is not configured. Please email support@deyvoras.com.',
                ]);
            }
        } else {
            $token = (string) $request->input('cf-turnstile-response', '');

            try {
                $verification = $token === '' ? null : Http::asForm()->timeout(5)->post(
                    'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                    ['secret' => $secretKey, 'response' => $token, 'remoteip' => $request->ip()],
                );
            } catch (Throwable $exception) {
                report($exception);
                $verification = null;
            }

            $expectedHost = parse_url((string) config('app.url'), PHP_URL_HOST);
            $validToken = $verification?->successful()
                && $verification->json('success') === true
                && (! $expectedHost || $verification->json('hostname') === $expectedHost);

            if (! $validToken) {
                return back()->withInput()->withErrors([
                    'contact' => 'Please complete the security check and try sending your message again.',
                ]);
            }
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'not_regex:/[\r\n]/'],
            'email' => ['required', 'email:rfc', 'max:254'],
            'organization' => ['nullable', 'string', 'max:150'],
            'subject' => ['required', 'string', 'max:140', 'not_regex:/[\r\n]/'],
            'message' => ['required', 'string', 'min:20', 'max:6000'],
        ]);

        try {
            Mail::to(config('mail.contact_to'))->send(new ContactInquiry($data));
        } catch (Throwable $exception) {
            report($exception);

            return back()->withInput()->withErrors([
                'contact' => 'Your message could not be delivered right now. Please email support@deyvoras.com.',
            ]);
        }

        return redirect()->route('contact')->with('status', 'Thanks for reaching out. Your note has been sent to our team.');
    }
}
