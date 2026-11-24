<?php

namespace App\Http\Controllers;

use App\Mail\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
