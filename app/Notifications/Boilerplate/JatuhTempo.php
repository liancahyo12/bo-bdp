<?php

namespace App\Notifications\Boilerplate;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\pengajuan;
use Carbon\Carbon;
use DB;

class JatuhTempo extends Notification
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
        $pengajuan = pengajuan::where('id', $this->id)->first();
        $jt = date_diff(date_create(Carbon::now()->toDateTimeString()), date_create($pengajuan->jatuhtempo))->format('%R%a');
        $jta = date_diff(date_create(Carbon::now()->toDateTimeString()), date_create($pengajuan->jatuhtempo))->format('%a');
        $teks ='';
        if ($jt<0) {
            $teks = 'sudah melewati jatuh tempo pada '.$pengajuan->jatuhtempo;
        }elseif ($jt==0) {
            $teks = 'jatuh tempo pada hari ini '.$pengajuan->jatuhtempo;
        }elseif ($jt>0) {
            $teks = $jta.' hari lagi akan jatuh tempo pada '.$pengajuan->jatuhtempo;
        }else {
            $teks = 'a';
        }
        $isi = pengajuan::leftJoin('isi_pengajuans', 'isi_pengajuans.pengajuan_id', 'pengajuans.id')->leftJoin('jenis_pengajuans', 'pengajuans.jenis_pengajuan_id', 'jenis_pengajuans.id')->leftJoin('users', 'users.id', 'pengajuans.user_id')->where('pengajuans.id', $this->id)->first();

        return (new MailMessage())
            ->from('it@bdpay.co.id', '[BDPay E-Office] No-reply')
            ->markdown('boilerplate::notifications.email')
            ->subject(__('Notifikasi Pengingat Jatuh Tempo', ['name' => 'BDPay E-Office']))
            ->line(__('Pengajuan '.$isi->jenis_pengajuan.' '.$isi->transaksi.$isi->jenis_transaksi.'..... '.$teks, [
            ]))
            ->action(
                __('Bayar Pengajuan'), 
                'https://e-office.bdpay.co.id/detail-bayar-pengajuan/'.$this->id
            )
            ->line(__('Silahkan tekan tombol di atas untuk bayar pengajuan'));
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
