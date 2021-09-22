<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardsImg extends Model
{
    use HasFactory;

    protected $table = 'cards_img';

    protected $fillable = [
        'card_id',
        'img',
        'preview',
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Cards::class, 'card_id');
    }
}
