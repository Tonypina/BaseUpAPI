<?php

namespace App\Http\Resources;

use App\Traits\HasImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\JsonResource;

class LineupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $players = [];

        foreach ($this->players as $player) {
            $players[] = [
                'name' => $player->name,
                'number' => $player->number,
                'position' => $player->pivot->position_id,
                'is_flex' => $player->pivot->is_flex,
            ];
        }
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'opposing_team' => $this->opposing_team,
            'players' => $players,
            'created_at' => $this->created_at,
        ];
    }
}
