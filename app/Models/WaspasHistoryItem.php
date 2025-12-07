<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaspasHistoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'waspas_history_id',
        'influencer_id',
        'final_score',
        'rank',
        'raw_scores',
        'selected',   // <---
    ];
    
    protected $casts = [
        'final_score' => 'decimal:8',
        'raw_scores'  => 'array',
        'selected'    => 'boolean',   // <---
    ];
    
    public function history()
    {
        return $this->belongsTo(WaspasHistory::class, 'waspas_history_id');
    }

    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }
}
