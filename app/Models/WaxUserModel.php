<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaxUserModel extends Model
{
    use HasFactory;

    protected $table = 'gc_users';

    protected $fillable = [
        'wallet',
        'pubKeys',
    ];
}
