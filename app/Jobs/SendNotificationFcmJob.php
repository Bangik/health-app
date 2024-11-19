<?php

namespace App\Jobs;

use App\Helpers\FcmHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotificationFcmJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private $reminder, private $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = FcmHelper::sendWithFcm(
            // topic: 'reminder-' . $this->user->id,
            title: $this->reminder->title,
            bodyMessage: $this->reminder->message,
            type: 'notification',
            // data: [
            //     'id' => $this->reminder->id,
            //     'title' => $this->reminder->title,
            //     'message' => $this->reminder->message,
            // ]
            fcmToken: $this->user->fcm_token
        );

        Log::info('SendNotificationFcmJob', [
            'response' => $response,
            'reminder' => $this->reminder,
            'user' => $this->user,
        ]);
    }
}
