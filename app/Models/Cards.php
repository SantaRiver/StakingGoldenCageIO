<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Cards extends Model
{
    use HasFactory;

    protected $table = 'cards';

    protected $fillable = [
        'name',
        'schema',
        'rarity',
        'template_id',
        'description',
        'active',
    ];

    public function image(): HasOne
    {
        return $this->hasOne(CardsImg::class, 'card_id');
    }

    public function staking(): HasOne
    {
        return $this->hasOne(CardsStaking::class, 'card_id');
    }
}
