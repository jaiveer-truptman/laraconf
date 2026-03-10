<?php

namespace App\Filament\Resources\Talks\Tables;

use App\Models\Talk;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
                    ->defaultImageUrl(function (Talk $record) {
                        return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff/&name='.urlencode($record->speaker->name);
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
                    ->color(function ($state) {
                        return $state->getColor();
                    }),
            ])
            ->filters([
                TernaryFilter::make('is_new'),
                SelectFilter::make('speakers')
                    ->relationship('speaker', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Filter::make('has_avatar')
                    ->label('Speaker With Avatar')
                    ->query(function (Builder $query) {
                        $query->whereHas('speaker', function (Builder $query) {
                            $query->whereNotNull('avatar');
                        });
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->slideOver(),
                ActionGroup::make([
                    Action::make('approve')
                    ->visible(fn (Talk $record) => $record->status === \App\Enums\TalkStatus::SUBMITTED)
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->action(function (Talk $record) {
                        $record->approve();
                    })
                    ->after(function () {
                        Notification::make()
                            ->title('Talk Approved')
                            ->body('The talk has been approved successfully.')
                            ->success()
                            ->send()
                            ->duration(2500);
                    })
                    ->color('success'),
                Action::make('reject')
                    ->visible(fn (Talk $record) => $record->status === \App\Enums\TalkStatus::SUBMITTED)
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->action(function (Talk $record) {
                        $record->reject();
                    })
                    ->after(function () {
                        Notification::make()
                            ->title('Talk Rejected')
                            ->body('The talk has been rejected successfully.')
                            ->danger()
                            ->send()
                            ->duration(2500);
                    })
                    ->color('danger'),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('approve')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function(Collection $records) {
                            $records->each->approve();
                        }),
                    BulkAction::make('reject')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function(Collection $records) {
                            $records->each->reject();
                        })                        
                ]),
            ])
            ->headerActions([
                Action::make('export')
                    ->action(function ($livewire) {
                        $count = $livewire->getFilteredTableQuery()->count();
                        info('exporting talks...', ['count' => $count]);
                    })
            ]);
    }
}
