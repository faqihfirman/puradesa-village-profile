<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\VisitorStat;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $visits7Days = VisitorStat::query()
            ->where('date', '>=', now()->subDays(6)->toDateString())
            ->sum('visits');

        return [
            Stat::make('Total Artikel', Article::count())
                ->description('Semua artikel (draf + terbit)')
                ->icon('heroicon-o-newspaper'),
            Stat::make('Pesan Belum Dibaca', ContactMessage::unread()->count())
                ->description('Pesan masuk yang perlu ditindaklanjuti')
                ->icon('heroicon-o-envelope')
                ->color('warning'),
            Stat::make('Kunjungan 7 Hari', number_format($visits7Days, 0, ',', '.'))
                ->description('Total kunjungan situs publik')
                ->icon('heroicon-o-chart-bar')
                ->color('success'),
        ];
    }
}
