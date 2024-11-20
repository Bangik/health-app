<?php

namespace App\Console\Commands;

use App\Jobs\SendNotificationFcmJob;
use App\Models\Reminder;
use Illuminate\Console\Command;

class FillReminderToJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fill-reminder-to-job-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // where created_at is before today in date
        $reminders = Reminder::with('user')
        ->where('status', 'pending')
        ->whereDate('created_at', '<', now()->toDateString())
        ->get();

        if ($reminders->isEmpty()) {
            $this->info('No reminder found');
            return;
        }

        foreach ($reminders as $reminder) {
            $explodeTime = explode(':', $reminder->reminder_time);
            dispatch(new SendNotificationFcmJob($reminder, $reminder->user))->delay(now()->addDays($reminder->reminder_date)->setTime($explodeTime[0], $explodeTime[1]));

            $this->info('Reminder with id ' . $reminder->id . ' has been dispatched');
        }

        $this->info('All reminders has been dispatched');

        return;
    }
}
