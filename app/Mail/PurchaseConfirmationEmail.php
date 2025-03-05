<?php

namespace App\Mail;

use App\Models\Purchase;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $purchase;
    public $ticketsArray;

    /**
     * Create a new message instance.
     *
     * @param Purchase $purchase
     * @param Ticket[] $ticketsArray
     */
    public function __construct(Purchase $purchase, array $ticketsArray)
    {
        $this->purchase = $purchase;
        $this->ticketsArray = $ticketsArray;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmação de Compra - Detalhes dos Tickets')
                    ->view('emails.purchase_confirmation');
    }
}
