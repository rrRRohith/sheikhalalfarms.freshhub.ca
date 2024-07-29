<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $contact;

    public function __construct($message)
    {
        $this->message = $message;
        $this->subject = $message->subject;
        $this->from = $message->sender_email;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->view('emails.emailsent');

        //  return $this
        //     ->from($this->from)
        //     ->subject($this->subject)
        //     ->view('emails.emailsent');
           
    }
}
