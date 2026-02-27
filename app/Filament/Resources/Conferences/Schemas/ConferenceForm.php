<?php

namespace App\Filament\Resources\Conferences\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ConferenceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Conference Name')
                    ->helperText('Enter the name of the conference')
                    ->hint('e.g., Laravel Live 2026')
                    ->required(),
                RichEditor::make('description')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'link',
                        'codeBlock',
                    ])
                    ->label('Conference Description')
                    ->helperText('Provide a detailed description of the conference')
                    ->required()
                    ->maxLength(5000),
                DateTimePicker::make('start_date')
                    ->native(false)
                    ->required(),
                DateTimePicker::make('end_date')
                    ->native(false)
                    ->required(),
                Select::make('status')
                    ->options([
                        0 => 'Draft',
                        1 => 'Published',
                        2 => 'Archived',
                    ])
                    ->required(),
                TextInput::make('region')
                    ->required(),
                Toggle::make('is_published')
                        ->label('Published'),
                Select::make('venue_id')
                    ->relationship('venue', 'name')
                    ->required(),
            ]);
    }
}
