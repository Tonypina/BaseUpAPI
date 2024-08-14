<?php

namespace App\Models;

use App\Models\Team;
use App\Models\PositionCatalog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Player extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'number',
        'team_id'
    ];

    protected $table = 'player';

    /**
     * Get the team that owns the Player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
    
    /**
     * The positions that belong to the Player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(PositionCatalog::class, 'player_positions', 'player_id', 'position_id');
    }
}
