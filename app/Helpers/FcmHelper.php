<?php

namespace App\Helpers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class FcmHelper
{
    public static function send(
        string $topic = '',
        string $title,
        string $bodyMessage,
        string $type = '',
        string $image = '',
        string $fcmToken = '',
        array $data = [],
        array $notification = [],
        array $android = [],
        array $apns = []
    ) {
        $server = config('app.server');
        if ($server == 'local' || $server == 'staging') {
            $topic = 'staging-' . $topic;
        }

        $body = [
            // 'topic' => $topic,
            'data' => [
                'title' => $title,
                'body' => $bodyMessage,
                'type' => $type,
                'is_ios' => 1,
                'is_android' => 1
            ],
            'notification' => [
                'title' => $title,
                'body' => $bodyMessage,
            ],
        ];

        if (!empty($topic)) {
            $body['topic'] = $topic;
        }

        if (!empty($notification)) {
            $body['notification'] = array_merge($body['notification'], $notification);
        }

        if (!empty($image)) {
            $body['notification']['image'] = $image;
        }

        if (!empty($fcmToken)) {
            $body['token'] = $fcmToken;
        }

        if (!empty($data)) {
            $body['data'] = array_merge($body['data'], $data);
        }

        if (!empty($android)) {
            $body['android'] = $android;
        }

        if (!empty($apns)) {
            $body['apns'] = array_merge($body['apns'], $apns);
        }

        $message = CloudMessage::fromArray($body);

        $fcm = self::init();
        return $fcm->send($message);
    }

    public static function init()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path(config('fcm.credential_file_path')))
            ->withProjectId(config('fcm.project_id'));

        return $factory->createMessaging();
    }
}
