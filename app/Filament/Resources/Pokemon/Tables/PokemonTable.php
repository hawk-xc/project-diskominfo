<?php

namespace App\Filament\Resources\Pokemon\Tables;

use App\Filament\Resources\Pokemon\Columns;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PokemonTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([ 
                Columns\Text::make('name'),
                ('name')->sortable()->searchable(),
                $table->stringColumn('best_experience')->sortable()->searchable(),
                $table->stringColumn('weight')->sortable()->searchable(),
                $table->stringColumn('image_path')->sortable()->searchable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
