<?php namespace vAMSYS\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;
use vAMSYS\Pirep;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'vAMSYS\Console\Commands\Inspire',
        'vAMSYS\Console\Commands\ImportCountries',
        'vAMSYS\Console\Commands\ImportRegions',
        'vAMSYS\Console\Commands\ImportAirports',
        'vAMSYS\Console\Commands\ParseTextDataCommand',
        'vAMSYS\Console\Commands\vramsimport'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $pirepsByUser = null;
            Pirep::where('pirep_data', '!=', '{"jumpseat":true}')->chunk(100, function ($pirepsChunk) use (&$pirepsByUser) { // TODO Improve this detection...
                $pirepsByUser = $pirepsChunk->groupBy(function ($item, $key) {
                    return $item->booking->pilot->id;
                });
            });

            // Most Points
            $pointsPirepsByUser = $pirepsByUser->sortByDesc(function (&$item, $key){
                $totalPoints = 0;
                foreach ($item as $pirep){
                    $totalPoints += $pirep->points;
                }
                $item->totalPoints = $totalPoints;
                return $totalPoints;
            });

            // Most Hours
            $timePirepsByUser = $pirepsByUser->sortByDesc(function (&$item, $key){
                $totalSeconds = 0;
                foreach ($item as $pirep){
                    $totalSeconds += $pirep->landing_time->getTimestamp() - $pirep->departure_time->getTimestamp();
                }
                $item->totalInterval = Carbon::now()->addSeconds($totalSeconds);
                return $totalSeconds;
            });

            // Most PIREPs
            $countPirepsByUser = $pirepsByUser->sortByDesc(function ($item, $key){
                return count($item);
            });

            Cache::forever('RYR:Leaderboards:Global', [
              'pirepCounts' => $countPirepsByUser->slice(0, 30),
              'pirepHours' => $timePirepsByUser->slice(0, 30),
              'pirepPoints' => $pointsPirepsByUser->slice(0, 30)
            ]); // TODO: Make this run for each airline
        })->hourly();
    }

}
