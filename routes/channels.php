<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Private channel untuk dashboard sales (per user)
Broadcast::channel('dashboard.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Jika kamu punya role admin dan ingin channel khusus admin
Broadcast::channel('admin-dashboard', function ($user) {
    return $user->role === 'admin'; // sesuaikan nama kolom/role
});
