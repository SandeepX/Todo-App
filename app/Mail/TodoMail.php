<?php

namespace App\Mail;

use App\Models\Todo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TodoMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

   public $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), 'Sandeep Pant'),
            subject: 'Todo Reminder Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.todo_reminder',
            with: ['todo', $this->todo]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
