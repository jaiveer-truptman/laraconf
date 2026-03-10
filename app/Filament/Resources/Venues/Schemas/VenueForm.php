<?php

namespace App\Filament\Resources\Venues\Schemas;

use App\Enums\Region;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VenueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('city')
                    ->required(),
                TextInput::make('country')
                    ->required(),
                TextInput::make('postal_code')
                    ->required(),
                Select::make('region')
                    ->options(Region::class)
                    ->enum(Region::class)
                    ->required(),
                SpatieMediaLibraryFileUpload::make('images')
                    ->collection('venue-images')
                    ->multiple()
                    ->image()
                    ->required(),
            ]);
    }
}
