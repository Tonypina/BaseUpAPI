<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PlayerPositions extends Pivot
{
    protected $fillable = [
        'player_id',
        'position_id',
    ];

    protected $table = 'player_positions';
}
