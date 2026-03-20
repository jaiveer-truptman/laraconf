<?php

namespace App\Filament\Resources\Attendees;

use App\Filament\Resources\Attendees\Pages\CreateAttendee;
use App\Filament\Resources\Attendees\Pages\EditAttendee;
use App\Filament\Resources\Attendees\Pages\ListAttendees;
use App\Filament\Resources\Attendees\Schemas\AttendeeForm;
use App\Filament\Resources\Attendees\Tables\AttendeesTable;
use App\Filament\Resources\Attendees\Widgets\AttendeeChart;
use App\Filament\Resources\Attendees\Widgets\AttendeesStatsWidget;
use App\Models\Attendee;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class AttendeeResource extends Resource
{
    protected static ?string $model = Attendee::class;


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string | UnitEnum | null $navigationGroup = 'Basic';


    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return AttendeeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttendeesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttendees::route('/'),
            'create' => CreateAttendee::route('/create'),
            'edit' => EditAttendee::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            AttendeesStatsWidget::class,
            AttendeeChart::class,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Attendee::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'conference' => $record->conference->name
        ];
    }
}
