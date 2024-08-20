<?php

namespace App\Models;

use App\Models\Team;
use App\Models\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lineup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'team_id'
    ];

    /**
     * Get the team that owns the Lineup
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * The players that belong to the Lineup
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'lineup_players', 'lineup_id', 'player_id')->withPivot('position_id');
    }
}
