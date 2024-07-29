<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $contact;

    public function __construct($orders,$body,$subject)
    {
        $this->order = $orders;
        $this->body = $body;
        $this->subject = $subject;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this
         ->from('admin@freshhub.ca')
         ->subject('Invoice#'.$this->order->invoice->invoice_number)
         ->view('admin.order.invoice-mail')
         ->with(['order'=>$this->order,'body'=>$this->body,'subject'=>$this->subject]);

        //  return $this
        //     ->from($this->from)
        //     ->subject($this->subject)
        //     ->view('emails.emailsent');
           
    }
}
