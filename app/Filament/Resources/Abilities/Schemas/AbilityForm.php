<?php

namespace App\Filament\Resources\Abilities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AbilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->placeholder('Enter Ability Name')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
