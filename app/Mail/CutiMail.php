<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CutiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Notifikasi SIMOJA] - Pengajuan Cuti',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'pages.cuti.template.email',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
