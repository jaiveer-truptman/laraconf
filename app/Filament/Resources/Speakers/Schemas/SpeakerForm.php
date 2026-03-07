<?php

namespace App\Filament\Resources\Speakers\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
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
                        Textarea::make('bio')
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
                            ->options([
                                'business-leader' => 'Business Leader',
                                'charisma' => 'Charismatic Speaker',
                                'first-time' => 'First Time Speaker',
                                'hometown-hero' => 'Hometown Hero',
                                'humanitarian' => 'Works in Humanitarian Field',
                                'laracasts-contributor' => 'Laracasts Contributor',
                                'twitter-influencer' => 'Large Twitter Following',
                                'youtube-influencer' => 'Large YouTube Following',
                                'open-source' => 'Open Source Creator / Maintainer',
                                'unique-perspective' => 'Unique Perspective',
                            ]
                            )
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
