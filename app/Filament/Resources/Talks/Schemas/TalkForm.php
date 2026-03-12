<?php

namespace App\Filament\Resources\Talks\Schemas;

use App\Enums\TalkLength;
use App\Enums\TalkStatus;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TalkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Talk Information')
                    ->columnSpanFull()
                    ->components([
                        Group::make()
                            ->columns(2)
                            ->components([
                                TextInput::make('title')
                                    ->required(),
                                Select::make('speaker_id')
                                    ->relationship('speaker', 'name')
                                    ->required()
                                    ->preload()
                                    ->searchable(),
                                RichEditor::make('abstract')
                                    ->required(),

                                Select::make('status')
                                    ->visible(function ($operation) {
                                        return $operation === 'edit';
                                    })
                                    ->options(TalkStatus::class),
                                Radio::make('length')
                                    ->label('Talk Length')
                                    ->options(TalkLength::class)
                                    ->descriptions([
                                        TalkLength::LIGHTNING->value => '20 minutes',
                                        TalkLength::NORMAL->value => '40 minutes',
                                        TalkLength::KEYNOTE->value => '60 minutes',
                                    ])
                                    ->inline()
                                    ->required(),
                                Toggle::make('is_new')
                                    ->label('New Talk')
                                    ->helperText('Indicates if this talk is already given at any conference.'),
                            ]),
                    ]),
            ]);
    }
}
