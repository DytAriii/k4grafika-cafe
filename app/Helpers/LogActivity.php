<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    public static function add($activity, $description = null)
    {
        ActivityLog::create([
    'user_id' => session('users_id'),
    'username' => session('users_username'),
    'activity' => $activity,
    'description' => $description
]);
    }
}
