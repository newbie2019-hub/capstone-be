<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class NewAccountMail extends Mailable implements ShouldQueue
{
    use Queueable;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->details = $data->all();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Created Account')
            ->markdown('emails.NewAccount', [
                'details' => $this->details
            ]);
    }
}
