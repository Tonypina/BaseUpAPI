<?php

namespace App\Http\Validations;

trait PlayerValidationRules
{
    protected function playerStoreValidationRules(): array
    {
        return [
            'positions' => ['required', 'array'],
            'name' => ['required', 'string'],
            'number' => ['required', 'numeric', 'integer'],
        ];
    }
    
    protected function playerUpdateValidationRules(): array
    {
        return [
            'positions' => ['array'],
            'name' => ['string'],
            'number' => ['numeric', 'integer'],
        ];
    }
}