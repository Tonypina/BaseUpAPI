<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\PositionCatalogResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
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
            'number' => $this->number,
            'positions' => PositionCatalogResource::collection($this->positions),
        ];
    }
}
