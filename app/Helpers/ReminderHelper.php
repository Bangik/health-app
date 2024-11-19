<?php

namespace App\Helpers;

use App\Jobs\SendNotificationFcmJob;
use App\Models\Reminder;

class ReminderHelper {
  public static function storeReminderDefault($userId, $i) {
    $reminder1 = Reminder::create([
        'user_id' => $userId,
        'title' => 'Sarapan',
        'message' => 'Waktunya sarapan, jangan lupa makan pagi ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '07:00',
        'type' => 'breakfast',
        'status' => 'pending',
    ]);

    dispatch(new SendNotificationFcmJob($reminder1, $reminder1->user))->delay(now()->addDays($i)->setTime(7, 0));

    $reminder2 = Reminder::create([
        'user_id' => $userId,
        'title' => 'Makan Siang',
        'message' => 'Waktunya makan siang, jangan lupa makan siang ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '12:00',
        'type' => 'lunch',
        'status' => 'pending',
    ]);

    dispatch(new SendNotificationFcmJob($reminder2, $reminder2->user))->delay(now()->addDays($i)->setTime(12, 0));

    $reminder3 = Reminder::create([
        'user_id' => $userId,
        'title' => 'Makan Malam',
        'message' => 'Waktunya makan malam, jangan lupa makan malam ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '19:00',
        'type' => 'dinner',
        'status' => 'pending',
    ]);

    dispatch(new SendNotificationFcmJob($reminder3, $reminder3->user))->delay(now()->addDays($i)->setTime(19, 0));

    $reminder4 = Reminder::create([
        'user_id' => $userId,
        'title' => 'Snack',
        'message' => 'Waktunya makan snack, jangan lupa makan snack ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '16:00',
        'type' => 'snack',
        'status' => 'pending',
    ]);

    dispatch(new SendNotificationFcmJob($reminder4, $reminder4->user))->delay(now()->addDays($i)->setTime(16, 0));

    $reminder6 = Reminder::create([
        'user_id' => $userId,
        'title' => 'Minum Air',
        'message' => 'Waktunya minum air, jangan lupa minum air ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '08:00',
        'type' => 'drink',
        'status' => 'pending',
    ]);

    dispatch(new SendNotificationFcmJob($reminder6, $reminder6->user))->delay(now()->addDays($i)->setTime(8, 0));

    $reminder7 = Reminder::create([
        'user_id' => $userId,
        'title' => 'Minum Air',
        'message' => 'Waktunya minum air, jangan lupa minum air ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '13:00',
        'type' => 'drink',
        'status' => 'pending',
    ]);

    dispatch(new SendNotificationFcmJob($reminder7, $reminder7->user))->delay(now()->addDays($i)->setTime(13, 0));

    $reminder8 = Reminder::create([
        'user_id' => $userId,
        'title' => 'Minum Air',
        'message' => 'Waktunya minum air, jangan lupa minum air ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '19:00',
        'type' => 'drink',
        'status' => 'pending',
    ]);

    dispatch(new SendNotificationFcmJob($reminder8, $reminder8->user))->delay(now()->addDays($i)->setTime(19, 0));

    $reminder9 = Reminder::create([
        'user_id' => $userId,
        'title' => 'Membaca Artikel',
        'message' => 'Waktunya membaca artikel, jangan lupa membaca artikel ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '08:00',
        'type' => 'reading',
        'status' => 'pending',
    ]);

    dispatch(new SendNotificationFcmJob($reminder9, $reminder9->user))->delay(now()->addDays($i)->setTime(8, 0));

    $reminder10 = Reminder::create([
        'user_id' => $userId,
        'title' => 'Membaca Artikel',
        'message' => 'Waktunya membaca artikel, jangan lupa membaca artikel ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '12:00',
        'type' => 'reading',
        'status' => 'pending',
    ]);

    dispatch(new SendNotificationFcmJob($reminder10, $reminder10->user))->delay(now()->addDays($i)->setTime(12, 0));

    $reminder11 = Reminder::create([
        'user_id' => $userId,
        'title' => 'Membaca Artikel',
        'message' => 'Waktunya membaca artikel, jangan lupa membaca artikel ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '19:00',
        'type' => 'reading',
        'status' => 'pending',
    ]);

    dispatch(new SendNotificationFcmJob($reminder11, $reminder11->user))->delay(now()->addDays($i)->setTime(19, 0));
  }
}