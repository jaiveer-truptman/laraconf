<?php

namespace App\Filament\Resources\Talks\Tables;

use App\Models\Talk;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ToggleColumn;

class TalksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->description(fn ($record) => str()->limit($record->abstract, 40))
                    ->searchable(),
                ImageColumn::make('speaker.avatar')
                    ->label('Speaker Avatar')
                    ->defaultImageUrl(function(Talk $record) {
                        return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff/&name=' . urlencode($record->speaker->name);
                    })
                    ->circular(),
                TextColumn::make('speaker.name')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('is_new')
                    ->label('New Talk'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state->label())
                    ->sortable()
                    ->color(function ($state){
                        return $state->getColor();
                    })
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
