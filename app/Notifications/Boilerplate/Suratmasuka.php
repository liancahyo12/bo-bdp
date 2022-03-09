<?php

namespace App\Notifications\Boilerplate;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Suratmasuk;

class Suratmasuka extends Notification
{
    use Queueable;
    public $id;
    /**
     * Get the notification's delivery <channels class=""></channels>
     *
     * @param  mixed  $notifiable
     * @return string[]
     */
    public function __construct($id)
    {
        $this->id = $id;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return string[]
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $currentUser = \Auth::user();
        $isi = Suratmasuk::where('suratmasuks.id', $this->id)->first();

        return (new MailMessage())
            ->from('it@bdpay.co.id', '[BDPay E-Office] No-reply')
            ->markdown('boilerplate::notifications.email')
            ->subject(__('Notifikasi Surat Masuk', ['name' => 'BDPay E-Office']))
            ->line(__('Surat masuk baru '.$isi->ringkasan.' dari '.$isi->pengirim, [
            ]))
            ->action(
                __('Lihat Surat'),
                route('boilerplate.surat-masuk-detail', $this->id)
            )
            ->line(__('Silahkan tekan tombol di atas untuk lihat surat masuk'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
