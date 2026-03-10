<?php

namespace App\Filament\Resources\Speakers\Pages;

use App\Filament\Resources\Speakers\SpeakerResource;
use Filament\Actions\EditAction;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Resources\Pages\ViewRecord;

class ViewSpeaker extends ViewRecord implements HasInfolists
{
    protected static string $resource = SpeakerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->slideOver(),
        ];
    }
}
