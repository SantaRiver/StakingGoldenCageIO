<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardPool extends Model
{
    use HasFactory;

    protected $table = 'reward_pool';

    protected $fillable = [
        'pool',
        'start',
        'end',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public $timestamps = false;

    public static function create(int $pool): RewardPool
    {
        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i:s');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i:s');

        $rewardPool = new RewardPool(
            [
                'pool' => $pool,
                'start' => $weekStartDate,
                'end' => $weekEndDate,
            ]
        );
        $rewardPool->save();
        return $rewardPool;

    }
}
