<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IndowireMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->msg = $data;
        // $this->unpaid = $data['unpaid'];
        // $this->pdf = $data['pdf'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('indowire@ezu.my.id')
                   ->view('message')
                   ->with(
                    [
                        'id' => $this->msg->id,
                        'first_name' => $this->msg->first_name,
                        'last_name' => $this->msg->last_name,
                        'email' => $this->msg->email,
                        'msg' => $this->msg->message,
                        'created_at' => $this->msg->created_at
                    ])
                   ;
        return $this->view('view.name');
    }
}
