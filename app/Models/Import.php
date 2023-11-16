<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'division',
        'email',
        'assigned_table',
        'lucky_draw_blacklist',
        'lucky_draw_number',
        'auth_key',
        'dietary_prefrences',
    ];
}
