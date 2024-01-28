<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TicketController;
use App\Models\Users;
use App\Models\Ticket;

class TicketCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    // public $ticket;
    public function __construct(){
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope{
        $subject = Ticket::select('t_id', 't_title')
        ->where('t_createdby', Auth::user()->id)
        ->orderby('t_id', 'desc')
        ->first();
        return new Envelope(
            subject: '#' . $subject['t_id'] . '#' . ' - ' . $subject['t_title'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $ticket = Ticket::select('tickets.t_id', 'tickets.t_title', 'tickets.t_description', 'departments.d_description')
        ->join('departments', 't_todepartment', 'd_id')
        ->where('t_createdby', Auth::user()->id)
        ->orderby('t_id', 'desc')
        ->first();
        return new Content(
            view: 'mail.ticketcreated',
            with: ['ticket' => $ticket],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
