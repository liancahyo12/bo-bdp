<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Notifications\Notifiable;
use App\Models\pengajuan;
use App\Models\Boilerplate\User;
use App\Notifications\Boilerplate\JatuhTempo;
use Carbon\Carbon;
use Notification;
use DB;

class notif_jatuhtempo extends Command
{
    use Notifiable;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notif:jatuhtempo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifikasi Pengingat Jatuh Tempo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pengajuan = pengajuan::leftJoin('isi_pengajuans', 'isi_pengajuans.pengajuan_id', 'pengajuans.id')->select(DB::raw('any_value(jatuhtempo) as jatuhtempo'), DB::raw('any_value(pengajuans.id) as id'))->whereRaw('any_value(pengajuans.status) = 1 and any_value(bayar_status)=1 and datediff(any_value(jatuhtempo),date(?)) <= 7', Carbon::now()->toDateTimeString())->groupBy('isi_pengajuans.pengajuan_id')->get();

        if (count($pengajuan)>0) {
            foreach ($pengajuan as $pengajuan) {
                $user=User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where('permission_id', 17)->get();
                foreach ($user as $user) {
                    $user->notify(new JatuhTempo($pengajuan->id));
                }
            }
        }
        
        return 0;
    }
}
