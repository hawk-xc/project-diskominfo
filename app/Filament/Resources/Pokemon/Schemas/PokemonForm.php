<?php

namespace App\Filament\Resources\Pokemon\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;

class PokemonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->placeholder('Enter Pokemon Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('weight')
                    ->label('Weight')
                    ->placeholder('Enter Weight in kg')
                    ->required()
                    ->numeric(),
                TextInput::make('best_experience')
                    ->label('Best Experience')
                    ->placeholder('Enter Best Experience')
                    ->required()
                    ->numeric(),
                Select::make('abilities')
                    ->label('Abilities')
                    ->placeholder('Select Abilities')
                    ->multiple()
                    ->relationship('abilities', 'name')
                    ->preload(),
            ]);
    }
}
