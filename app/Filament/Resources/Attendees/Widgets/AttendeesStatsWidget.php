<?php

namespace App\Filament\Resources\Attendees\Widgets;

use App\Filament\Resources\Attendees\Pages\ListAttendees;
use DB;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Schemas\Components\Icon;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class AttendeesStatsWidget extends StatsOverviewWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListAttendees::class;
    }

    protected function getStats(): array
    {
        $lastTenDayAttendeeCount = $this->getPageTableQuery()
        ->where('created_at','>=',now()->subDays(10))
        ->selectRaw('DATE(created_at) as date,COUNT(*) as attendee_count')
        ->groupBy(DB::raw('DATE(created_at)'))
        ->limit(10)
        ->pluck('attendee_count')
        ->values();
        return [
            Stat::make('Total Attendees',$this->getPageTableQuery()->count())
                ->description('Total number of attendees')
                ->descriptionIcon('heroicon-o-user-group',IconPosition::Before)
                ->chart($lastTenDayAttendeeCount)
            ->color('success'),
            Stat::make('Ticket Revenue',Number::currency($this->getPageTableQuery()->sum('ticket_cost') / 100,'usd','en_US',2))
        ];
    }
}
