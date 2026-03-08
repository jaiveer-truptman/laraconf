<?php

namespace App\Filament\Resources\Talks\Pages;

use App\Enums\TalkStatus;
use App\Filament\Resources\Talks\TalkResource;
use App\Models\Talk;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTalks extends ListRecords
{
    protected static string $resource = TalkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->badge(static fn (): int => Talk::count())
                ->deferBadge(),
            'submitted' => Tab::make()
                ->badge(static fn (): int => Talk::whereStatus(TalkStatus::SUBMITTED)->count())
                ->deferBadge()
                ->badgeColor('warning')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('status', TalkStatus::SUBMITTED);
                }),
            'approved' => Tab::make()
                ->badge(static fn (): int => Talk::whereStatus(TalkStatus::APPROVED)->count())
                ->deferBadge()
                ->badgeColor('success')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('status', TalkStatus::APPROVED);
                }),
            'rejected' => Tab::make()
                ->badge(static fn (): int => Talk::whereStatus(TalkStatus::REJECTED)->count())
                ->deferBadge()
                ->badgeColor('danger')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('status', TalkStatus::REJECTED);
                }),
        ];
    }
}
