<?php

namespace App\Filament\Resources\Speakers\RelationManagers;

use App\Filament\Resources\Talks\TalkResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TalksRelationManager extends RelationManager
{
    protected static string $relationship = 'talks';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return TalkResource::form($schema);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('abstract')
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state->label())
                    ->color(function ($state) {
                        return $state->getColor();
                    }),
            ]);
    }

    public function table(Table $table): Table
    {
        // return TalkResource::table($table); 1st way & clean way
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state->label())
                    ->sortable()
                    ->color(function ($state) {
                        return $state->getColor();
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
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
