<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    use HasFactory;

    protected $table = 'criteria';

    protected $fillable = [
        'code',
        'name',
        'type',
        'weight',
        'description',
        'is_active',
    ];

    protected $casts = [
        'weight'    => 'decimal:4',
        'is_active' => 'boolean',
    ];
}
