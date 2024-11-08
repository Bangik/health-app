<?php

namespace App\Console\Commands;

use App\Helpers\FcmHelper;
use App\Jobs\SendNotificationFcmJob;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendNotificationFcmCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-notification-fcm-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification FCM command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reminders = Reminder::with([
            'user' => function ($query) {
                $query->whereNotNull('fcm_token');
            }
        ])
        ->where('status', 'pending')
        ->whereDate('reminder_date', Carbon::now()->toDateString())
        ->whereBetween('reminder_time', [Carbon::now()->subMinute()->toTimeString(), Carbon::now()->addMinute()->toTimeString()])
        ->get();
        // ->each(function ($reminder) {
        //     dispatch(new SendNotificationFcmJob($reminder, $reminder->user));
        //     // FcmHelper::send(
        //     //     topic: $reminder->user->id,
        //     //     title: $reminder->title,
        //     //     bodyMessage: $reminder->message,
        //     //     type: 'notification',
        //     //     data: [
        //     //         'id' => $reminder->id,
        //     //         'title' => $reminder->title,
        //     //         'message' => $reminder->message,
        //     //     ]
        //     // );

        //     $reminder->update(['status' => 'completed']);
        // });

        if (!$reminders->isEmpty() || $reminders->count() !== 0) {
            foreach ($reminders as $reminder) {
                dispatch(new SendNotificationFcmJob($reminder, $reminder->user))->delay(now()->addSeconds(3));
                $reminder->update(['status' => 'completed']);
                $this->info('Send notification FCM command for reminder title ' . $reminder->title . ' successfully.');
                sleep(3);
            }
        }

        $this->info('Send notification FCM command successfully.');
    }
}
