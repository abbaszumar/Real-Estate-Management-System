<?php

namespace App\Mail;
use App\Http\Controllers\MailController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Mail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $mailData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Demo Mail',
        );
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.sendmail',
        );
    }
}
