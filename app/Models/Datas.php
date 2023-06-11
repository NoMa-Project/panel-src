<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datas extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'maxCpu',
        'cpuUsage',
        'maxRam',
        'ramUsage',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'maxCpu' => "integer",
        'cpuUsage' => "float",
        'maxRam' => "integer",
        'ramUsage' => "float",
    ];
}

