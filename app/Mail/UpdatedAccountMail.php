<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdatedAccountMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->details = $data;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Account Information Update')
                ->markdown('emails.UpdatedAccount', [
                    'url' => 'localhost:8081', 
                    'first_name' => $this->details['first_name'],
                    'middle_name' => $this->details['middle_name'],
                    'email' => $this->details['email'],
                    'gender' => $this->details['gender'],
                    'last_name' => $this->details['last_name']
                ]);
    }
}
