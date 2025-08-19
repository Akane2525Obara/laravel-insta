<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Story;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            Story::where('expires_at', '<', now()->subDays(2))
                ->each(function ($s) {
                    Storage::disk('public')->delete($s->image_path);
                    $s->delete();
                });
        })->dailyAt('03:00'); // 毎日03:00に実行（お好みで変更）
    }
}
