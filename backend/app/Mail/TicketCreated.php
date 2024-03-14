<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $ticketReceipt;

    public function __construct($ticketReceipt){
        $this->ticketReceipt = $ticketReceipt;
    }

    public function build()
    {
        return $this->view('mail.ticketcreated')
                    ->with('ticket', $this->ticketReceipt)
                    ->subject('#' . $this->ticketReceipt->t_id . '#' . ' - ' . $this->ticketReceipt->t_title);
    }
}
