<?php

namespace App\Notifications\Boilerplate;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\closing;

class RevieweddepClosing extends Notification
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
        $isi = closing::leftJoin('isi_closings', 'isi_closings.pengajuan_id', 'closings.id')->leftJoin('jenis_pengajuans', 'closings.jenis_pengajuan_id', 'jenis_pengajuans.id')->leftJoin('users', 'users.id', 'closings.user_id')->where('closings.id', $this->id)->first();

        return (new MailMessage())
            ->from('it@bdpay.co.id', '[BDPay E-Office] No-reply')
            ->markdown('boilerplate::notifications.email')
            ->subject(__('Notifikasi Closing Pengajuan', ['name' => 'BDPay E-Office']))
            ->line(__('Closing pengajuan '.$isi->jenis_pengajuan.' '.$isi->transaksi.$isi->jenis_transaksi.' telah direview', [
            ]))
            ->action(
                __('Lihat Detail'),
                route('boilerplate.edit-closing-pengajuan', $this->id)
            )
            ->line(__('Silahkan tekan tombol di atas untuk lihat detail'));
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
