<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Suratkeluar;

class Buatsuratkeluar extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->subject('Surat Keluar '.Suratkeluar::where('id', $id)->value('perihal'))
        //             ->view('boilerplate::mail.buatsuratkeluar');
        return $this->subject('Notifikasi BDPay E-Office')
                    ->from('lian.cahyo@gmail.com', 'BDPay E-Office')
                    ->view('boilerplate::mail.buatsuratkeluar');
    }
}
