<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LineupPlayer extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'position_id'
    ];
}
