<?php

namespace App\Jobs;

use App\Helpers\FcmHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        FcmHelper::send(
            topic: 'reminder-' . $this->user->id,
            title: $this->reminder->title,
            bodyMessage: $this->reminder->message,
            type: 'notification',
            data: [
                'id' => $this->reminder->id,
                'title' => $this->reminder->title,
                'message' => $this->reminder->message,
            ]
        );
    }
}
