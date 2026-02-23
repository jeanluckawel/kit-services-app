<?php

namespace App\Mail;

use App\Models\QuickPay;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuickPayMail extends Mailable
{
    use Queueable, SerializesModels;

    public QuickPay $quickPay;

    /**
     * Create a new message instance.
     */
    public function __construct(QuickPay $quickPay)
    {
        $this->quickPay = $quickPay;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Bulletin the pay',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.quick_pay',
            with: [
                'quickPay' => $this->quickPay,
                'employee' => $this->quickPay->employee,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
