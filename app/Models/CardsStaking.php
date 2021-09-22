<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardsStaking extends Model
{
    use HasFactory;

    protected $table = 'cards_staking';

    protected $fillable = [
        'card_id',
        'staking_rate',
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Cards::class,'card_id');
    }
}
