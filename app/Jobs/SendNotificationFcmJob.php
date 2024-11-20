<?php

namespace App\Jobs;

use App\Helpers\FcmHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        if (empty($this->user?->fcm_token)) {
            Log::info('SendNotificationFcmJob', [
                'message' => 'User fcm token is empty',
                'reminder' => $this->reminder,
                'user' => $this->user,
            ]);
            return;
        }

        try {
            DB::beginTransaction();
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

            $this->reminder->update([
                'status' => 'completed',
            ]);
    
            Log::info('SendNotificationFcmJob', [
                'response' => $response,
                'reminder' => $this->reminder,
                'user' => $this->user,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('SendNotificationFcmJob', [
                'message' => $e->getMessage(),
                'reminder' => $this->reminder,
                'user' => $this->user,
            ]);
        }
    }
}
