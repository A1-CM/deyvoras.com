<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $inquiry) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.contact_from_address', 'no-reply@deyvoras.com'), 'Deyvoras'),
            replyTo: [new Address($this->inquiry['email'], $this->inquiry['name'])],
            subject: 'Website enquiry: '.$this->inquiry['subject'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact-inquiry',
            with: ['inquiry' => $this->inquiry],
        );
    }
}
