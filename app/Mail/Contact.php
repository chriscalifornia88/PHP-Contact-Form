<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string */
    private $name, $email, $phone, $message;

    /**
     * Create a new message instance.
     * @param $name
     * @param $email
     * @param $message
     * @param null $phone
     */
    public function __construct($name, $email, $message, $phone = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Contact Form Submission')
            ->markdown('emails.contact', [
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'message' => $this->message
        ]);
    }
}
