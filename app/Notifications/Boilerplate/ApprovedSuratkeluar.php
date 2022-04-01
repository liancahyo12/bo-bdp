<?php

namespace App\Notifications\Boilerplate;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Suratkeluar;

class ApprovedSuratkeluar extends Notification
{
    use Queueable;
    public $id;
    /**
     * Get the notification's delivery channels.
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
        $isi = Suratkeluar::where('id', $this->id)->first();

        return (new MailMessage())
            ->from('it@bdpay.co.id', '[BDPay E-Office] No-reply')
            ->markdown('boilerplate::notifications.email')
            ->subject(__('Notifikasi Surat Keluar', ['name' => 'BDPay E-Office']))
            ->line(__('Surat keluar '.$isi->perihal.' telah diapprove', [
            ]))
            ->action(
                __('Lihat Detail'),
                route('boilerplate.surat-keluar-saya.edit', $this->id)
            )
            ->line(__('Silahkan tekan tombol di atas untuk lihat detail, setelah surat ditandatangani jangan lupa untuk scan dan unggah pada halaman detail surat untuk arsip surat'));
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
