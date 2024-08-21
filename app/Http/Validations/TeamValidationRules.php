<?php

namespace App\Http\Validations;

trait TeamValidationRules
{
    protected function teamStoreValidationRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:25'],
            'manager' => ['required', 'string', 'max:100'],
            'coach' => ['required', 'string', 'max:100'],
            'logo' => ['required'],
            'players' => ['required'],
            'players.*.positions' => ['required', 'array'],
            'players.*.name' => ['required', 'string'],
            'players.*.number' => ['required', 'numeric', 'integer'],
        ];
    }
    
    protected function teamUpdateValidationRules(): array
    {
        return [
            'name' => ['string', 'max:25'],
            'logo' => [],
            'manager' => ['string', 'max:25'],
            'coach' => ['string', 'max:25'],
            'players' => [],
            'players.*.positions' => ['array'],
            'players.*.name' => ['string'],
            'players.*.number' => ['numeric', 'integer'],
        ];
    }
}