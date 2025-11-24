<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'activity', 'description'];

    public function user()
{
    return $this->belongsTo(\App\Models\users::class, 'user_id');
}
}