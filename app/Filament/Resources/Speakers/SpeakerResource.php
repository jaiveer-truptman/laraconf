<?php

namespace App\Filament\Resources\Speakers;

use App\Enums\TalkStatus;
use App\Filament\Resources\Speakers\Pages\CreateSpeaker;
use App\Filament\Resources\Speakers\Pages\ListSpeakers;
use App\Filament\Resources\Speakers\Pages\ViewSpeaker;
use App\Filament\Resources\Speakers\RelationManagers\TalksRelationManager;
use App\Filament\Resources\Speakers\Schemas\SpeakerForm;
use App\Filament\Resources\Speakers\Tables\SpeakersTable;
use App\Models\Speaker;
use BackedEnum;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;


class SpeakerResource extends Resource
{
    protected static ?string $model = Speaker::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSpeakerWave;
    protected static string | UnitEnum | null $navigationGroup = 'Standard';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SpeakerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpeakersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TalksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSpeakers::route('/'),
            'create' => CreateSpeaker::route('/create'),
            'view' => ViewSpeaker::route('/{record}'),
        ];
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Personal Information')
                ->columns(3)
                ->columnSpanFull()
                ->schema([
                    ImageEntry::make('avatar')
                        ->label('Avatar')
                        ->circular()
                        ->defaultImageUrl(function ($record) {
                            return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff/&name='.urlencode($record->name);
                        }),

                    Group::make()
                        ->columnSpan(2)
                        ->columns(2)
                        ->schema([
                            TextEntry::make('name')
                                ->label('Name'),
                            TextEntry::make('email')
                                ->label('Email address'),
                            TextEntry::make('twitter_handle')
                                ->label('Twitter handle')
                                ->prefix('@')
                                ->url(fn ($record) => 'https://twitter.com/'.$record->twitter_handle)
                                ->color('primary'),
                            TextEntry::make('has_spoken')
                                ->getStateUsing(fn ($record) => $record->talks()->where('status', TalkStatus::APPROVED)->count() > 0 ? 'Previous Speaker' : 'Has Not Spoken')
                                ->badge()
                                ->color(function ($state) {
                                    return $state == 'Previous Speaker' ? 'success' : 'primary';
                                }),
                        ]),
                ]),

            Section::make('Other Information')
                ->schema([
                    TextEntry::make('bio')
                        ->html()
                        ->prose()
                        ->label('Biography')
                        ->columnSpanFull(),
                    TextEntry::make('qualifications')
                        ->listWithLineBreaks()
                        ->bulleted()
                        ->label('Qualifications'),
                ]),
        ]);
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $hasSpeaker =  $record->talks()->where('status', TalkStatus::APPROVED)->count() > 0 ? 'Previous Speaker' : 'Has Not Spoken';
        return [
            'email' => $record->email,
            'experience' => $hasSpeaker
        ];
    }
}
