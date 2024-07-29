<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RunsheetSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $contact;

    public function __construct($orders)
    {
        $this->orders = $orders;
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
         ->subject('Runsheet')
         ->view('admin.order.runsheet1')
         ->with(['orders'=>$this->orders]);

        //  return $this
        //     ->from($this->from)
        //     ->subject($this->subject)
        //     ->view('emails.emailsent');
           
    }
}
