<?php

namespace App\Models;

use App\Models\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'logo_path',
        'user_id',
    ];

    protected $table = 'team';

    /**
     * Get all of the players for the Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'team_id', 'id');
    }

    /**
     * Get the user that owns the Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
