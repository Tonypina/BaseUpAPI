<?php

namespace App\Http\Validations;

trait TeamValidationRules
{
    protected function teamStoreValidationRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:25'],
            'logo' => ['required'],
            'players' => ['required', 'array:name,number,positions'],
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
            'players' => ['array:name,number,positions'],
            'players.*.positions' => ['array'],
            'players.*.name' => ['string'],
            'players.*.number' => ['numeric', 'integer'],
        ];
    }
}