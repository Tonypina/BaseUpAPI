<?php

namespace App\Http\Resources;

use App\Traits\HasImages;
use Illuminate\Http\Request;
use App\Http\Resources\PlayerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    use HasImages;

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
            'logo' => $this->getImageFromPath($this->logo_path),
            'players' => PlayerResource::collection($this->players),
        ];
    }
}
