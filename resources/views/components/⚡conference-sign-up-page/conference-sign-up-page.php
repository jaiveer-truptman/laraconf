<?php

use App\Models\Attendee;
use App\Models\Conference;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Conference Signup - Form')] class extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions,InteractsWithSchemas;    

    public Conference $conference;

    public function mount()
    {
        $this->conference = Conference::findOrFail(1);
    }

    public function signUpAction(): Action
    {
        return Action::make('signup')
            ->slideOver()
            ->color(Color::Indigo)
            ->form([
                Placeholder::make('total_price')
                    ->content(function ($get) {
                        return '$'.count($get('attendees')) * 500;
                    })
                    ->html(),
                Repeater::make('attendees')
                    ->schema([
                        Group::make()->columns(2)
                            ->schema([
                             TextInput::make('name')
                                ->required()
                                ->maxLength('100'),
                            TextInput::make('email')
                                ->required()
                                ->maxLength('100'),
                        ])
                    ])
            ])->label('Sign up for conference')
            ->action(function (array $data){
                collect($data['attendees'])->each(function ($attendee){
                    $this->conference->attendees()->create([
                        'name' => $attendee['name'],
                        'email' => $attendee['email'],
                        'is_paid' => true,
                        'ticket_cost' => 50000
                    ]);
                });
            })
            ->after(function() {
                Notification::make()->success()->title('Success!')
                    ->body(new HtmlString('You have successfully signed up for the conference.'))
                    ->send();
            });
    }
};