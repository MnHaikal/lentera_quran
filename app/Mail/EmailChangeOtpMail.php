<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailChangeOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $newEmail,
        public string $otp
    ) {}

    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address', 'no-reply@lenteraquran.com');
        $fromName = config('mail.from.name', 'Lentera Quran');

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: 'Kode Verifikasi Perubahan Email - Lentera Quran',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.email-change-otp',
            text: 'emails.email-change-otp-text',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

