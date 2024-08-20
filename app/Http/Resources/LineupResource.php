<?php

namespace App\Http\Resources;

use App\Traits\HasImages;
use Illuminate\Http\Request;
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'players' => function () {
                $players = [];

                foreach ($this->players as $player) {
                    $players[] = [
                        'name' => $player->name,
                        'number' => $player->number,
                        'position' => $player->pivot->position_id,
                    ];
                }

                return $players;
            },
            'created_at' => $this->created_at,
        ];
    }
}
