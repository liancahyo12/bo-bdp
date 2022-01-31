<?php

namespace App\Notifications\Boilerplate;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApproveaSuratkeluar extends Notification
{
    use Queueable;

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

        return (new MailMessage())
            ->from('it@bdpay.co.id', '[BDPay E-Office] No-reply')
            ->markdown('boilerplate::notifications.email')
            ->subject(__('Notifikasi Surat Keluar', ['name' => 'BDPay E-Office']))
            ->line(__('Surat keluar telah dikirimkan oleh '.$currentUser->first_name.' '.$currentUser->last_name, [
            ]))
            ->action(
                __('Approve Surat Keluar'),
                route('boilerplate.surat-keluar-approve.edit', $this->id)
            )
            ->line(__('Silahkan tekan tombol di atas untuk approve surat keluar'));
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
