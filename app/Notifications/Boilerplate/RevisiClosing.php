<?php

namespace App\Notifications\Boilerplate;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RevisiClosing extends Notification
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
            ->subject(__('Notifikasi Closing Pengajuan', ['name' => 'BDPay E-Office']))
            ->line(__('Closing pengajuan perlu direvisi', [
            ]))
            ->action(
                __('Revisi Closing Pengajuan'),
                route('boilerplate.edit-closing-pengajuan', $this->id)
            )
            ->line(__('Silahkan tekan tombol di atas untuk revisi pengajuan'));
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
