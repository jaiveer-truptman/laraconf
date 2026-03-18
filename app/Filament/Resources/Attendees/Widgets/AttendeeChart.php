<?php

namespace App\Filament\Resources\Attendees\Widgets;

use App\Models\Attendee;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AttendeeChart extends ChartWidget
{
    protected ?string $heading = 'Attendee Signups';

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '250px';

    public ?string $filter = 'week';

    protected function getFilters(): ?array
    {
        return [
            'week' => 'Last week',
            'month' => 'Last month',
            '3months' => 'Last 3 months',
        ];
    }

    protected function getData(): array
    {

        $filter = $this->filter;

        match ($filter) {
            'week' => $data = Trend::model(Attendee::class)
            ->between(
                start: now()->subWeek(),
                end: now(),
            )
            ->perDay()
            ->count(),
            'month' => $data = Trend::model(Attendee::class)
            ->between(
                start: now()->subMonth(),
                end: now(),
            )
            ->perDay()
            ->count(),
            '3months' => $data = Trend::model(Attendee::class)
            ->between(
                start: now()->subMonths(3),
                end: now(),
            )
            ->perMonth()
            ->count(),
        };

        // $data = Trend::model(Attendee::class)
        //     ->between(
        //         start: now()->subMonths('3'),
        //         end: now(),
        //     )
        //     ->perMonth()
        //     ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Signups',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
