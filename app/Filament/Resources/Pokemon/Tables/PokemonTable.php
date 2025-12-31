<?php

namespace App\Filament\Resources\Pokemon\Tables;


use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\Filter;
use App\Filament\Resources\Pokemon\Columns;
use Filament\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;

class PokemonTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([ 
                TextColumn::make('name'),
                TextColumn::make('weight')
            ])
            ->filters([
                TrashedFilter::make(),
                Filter::make('weight')
                    ->form([
                        \Filament\Forms\Components\Select::make('weight_category')
                            ->label('Kategori Berat')
                            ->options([
                                'light' => 'Light',
                                'medium' => 'Medium',
                                'heavy' => 'Heavy',
                            ])
                            ->placeholder('Pilih kategori'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['weight_category'],
                            function (Builder $query, $category) {
                                return match ($category) {
                                    'light' => $query->where('weight', '<', 200),
                                    'medium' => $query->whereBetween('weight', [201, 300]),
                                    'heavy' => $query->where('weight', '>', 300),
                                    default => $query,
                                };
                            }
                        );
                    }),
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
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
