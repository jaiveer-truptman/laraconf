<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Attendees\AttendeeResource;
use App\Filament\Resources\Speakers\SpeakerResource;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;

class TestWidget extends Widget implements HasActions, HasForms
{
    use InteractsWithActions,InteractsWithForms;

    protected string $view = 'filament.widgets.test-widget';

    public function callNotification(): Action
    {
        return Action::make('callNotification')
            ->button()
            ->color('warning')
            ->label('send a test notification')
            ->action(function () {
                Notification::make()
                    ->title('Test Notification')
                    ->warning()
                    ->body('example notificatino body content')
                    ->actions([
                        Action::make('mark')
                        ->dispatch('mark')
                        ->button(),
                        Action::make('go-to-attendees')
                            ->color('warning')
                            ->url(SpeakerResource::getUrl('view',['record' => 1]))
                    ])
                    ->send();
            });
    }

    #[On('mark')]
    public function markAsRead()
    {
        info('marked as read');
    }
}
