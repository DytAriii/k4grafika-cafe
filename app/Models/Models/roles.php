<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class roles extends Model
{
    protected $fillable = ['nama_role'];
    use HasFactory;

    public function users(): HasMany
    {
        return $this->hasMany(users::class);
    }
}
