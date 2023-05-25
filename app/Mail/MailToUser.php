<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\File;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MailToUser extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('pages.order.user_mail')
            ->from($this->data['mail_from'])
            ->subject($this->data['mail_subject'])
            ->with('data', $this->data)
            ->attach(
                $this->data['mail_attachment']->getRealPath(),
                [
                    'as' =>  $this->data['mail_attachment']->getClientOriginalName(),
                    'mime' =>  $this->data['mail_attachment']->getClientMimeType(),
                ]
            );
    }
}
