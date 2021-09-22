<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTransactions extends Model
{
    use HasFactory;

    protected $table = 'users_transaction';

    protected $fillable = [
        'user_id',
        'action',
        'value',
    ];
}
