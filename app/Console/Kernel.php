<?php

namespace App\Console;

use App\Http\Controllers\NotificationController;
use App\Models\Notification;
use App\Models\Pemesanan;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        date_default_timezone_set('Asia/Jakarta');
        $schedule->call(
            function () {
                $pemesanans = Pemesanan::all()->where('status', 'Menunggu Pembayaran' || 'status', 'Dibatalkan' )->where('dedline', '<', Carbon::now());
                $validateData['status'] = 'Kadaluarsa';
                foreach ($pemesanans as $pemesanan) {
                    $pemesanan->update($validateData);
                }
            }
        )->everyMinute(1);

        // $schedule->call(
        //     function () {
        //         $pemesanans = Pemesanan::all()->where('status', 'Kadaluarsa');
        //         foreach ($pemesanans as $pemesanan) {
        //             $pemesanan->delete();
        //         }
        //     }
        // )->everySixHours();
    }



    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
