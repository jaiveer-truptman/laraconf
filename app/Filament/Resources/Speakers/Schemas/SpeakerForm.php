<?php

namespace App\Filament\Resources\Speakers\Schemas;

use App\Models\Speaker;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SpeakerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Information')
                    ->collapsible()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        RichEditor::make('bio')
                            ->columnSpanFull(),
                        TextInput::make('twitter_handle')
                            ->prefix('@'),
                    ])
                    ->columnSpan([
                        'md' => 2,
                        'lg' => 3,
                        'xl' => 2,
                    ]),

                FileUpload::make('avatar')
                    ->label('Profile Picture')
                    ->avatar()
                    ->imageEditor()
                    ->directory('avatars')
                    ->maxSize(1024 * 1024 * 10), // 10MB,

                Fieldset::make()
                    ->label('Qualifications')
                    ->schema([
                        CheckboxList::make('qualifications')
                            ->options(Speaker::QUALIFICATIONS)
                            ->columns([
                                'md' => 2,
                                'xl' => 3,
                            ])
                            ->columnSpanFull()
                            ->searchable()
                            ->bulkToggleable(),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns([
                'md' => 3,
                'lg' => 4,
            ]);
    }
}
