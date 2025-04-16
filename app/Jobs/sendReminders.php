<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Event;
use App\Enums\EventStatus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReminders implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $events = Event::where('status', EventStatus::NOT_STARTED)
            ->where('time', '<=', Carbon::now()->addDay())
            ->where('time', '>', Carbon::now()->subDay())
            ->get();

        $events->each(function ($event) {
            $event->sendReminders();
        });
    }
}
