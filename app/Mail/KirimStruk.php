<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KirimStruk extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;

    /**
     * Create a new message instance.
     */
    public function __construct($pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('email.struk')
                    ->subject('Struk Pengembalian')
                    ->attachData($this->pdf, 'struk.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}