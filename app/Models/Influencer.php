<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'platform',
        'followers',
        'engagement_rate',
        'niche',
        'email',
        'phone',
        'profile_link',
        'notes',
    ];
}
