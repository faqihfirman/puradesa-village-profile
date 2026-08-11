<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $contactMessage)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('Pesan Baru dari Formulir Kontak — '.config('village.name'))
            ->replyTo($this->contactMessage->email, $this->contactMessage->name)
            ->view('emails.contact-message');
    }
}
