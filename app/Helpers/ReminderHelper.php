<?php

namespace App\Helpers;

use App\Models\Reminder;

class ReminderHelper {
  public static function storeReminderDefault($userId, $i) {
    Reminder::create([
        'user_id' => $userId,
        'title' => 'Sarapan',
        'message' => 'Waktunya sarapan, jangan lupa makan pagi ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '22:32',
        'type' => 'breakfast',
        'status' => 'pending',
    ]);

    Reminder::create([
        'user_id' => $userId,
        'title' => 'Makan Siang',
        'message' => 'Waktunya makan siang, jangan lupa makan siang ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '12:00',
        'type' => 'lunch',
        'status' => 'pending',
    ]);

    Reminder::create([
        'user_id' => $userId,
        'title' => 'Makan Malam',
        'message' => 'Waktunya makan malam, jangan lupa makan malam ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '19:00',
        'type' => 'dinner',
        'status' => 'pending',
    ]);

    Reminder::create([
        'user_id' => $userId,
        'title' => 'Snack',
        'message' => 'Waktunya makan snack, jangan lupa makan snack ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '16:00',
        'type' => 'snack',
        'status' => 'pending',
    ]);

    Reminder::create([
        'user_id' => $userId,
        'title' => 'Minum Air',
        'message' => 'Waktunya minum air, jangan lupa minum air ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '08:00',
        'type' => 'drink',
        'status' => 'pending',
    ]);

    Reminder::create([
        'user_id' => $userId,
        'title' => 'Minum Air',
        'message' => 'Waktunya minum air, jangan lupa minum air ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '13:00',
        'type' => 'drink',
        'status' => 'pending',
    ]);

    Reminder::create([
        'user_id' => $userId,
        'title' => 'Minum Air',
        'message' => 'Waktunya minum air, jangan lupa minum air ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '19:00',
        'type' => 'drink',
        'status' => 'pending',
    ]);

    Reminder::create([
        'user_id' => $userId,
        'title' => 'Membaca Artikel',
        'message' => 'Waktunya membaca artikel, jangan lupa membaca artikel ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '08:00',
        'type' => 'reading',
        'status' => 'pending',
    ]);

    Reminder::create([
        'user_id' => $userId,
        'title' => 'Membaca Artikel',
        'message' => 'Waktunya membaca artikel, jangan lupa membaca artikel ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '12:00',
        'type' => 'reading',
        'status' => 'pending',
    ]);

    Reminder::create([
        'user_id' => $userId,
        'title' => 'Membaca Artikel',
        'message' => 'Waktunya membaca artikel, jangan lupa membaca artikel ya!',
        'reminder_date' => now()->addDays($i),
        'reminder_time' => '19:00',
        'type' => 'reading',
        'status' => 'pending',
    ]);
  }
}