<?php

namespace App\Services;

use App\Models\Courrier;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistiqueService
{
    public function getWeeklyStats()
    {
        return Courrier::selectRaw('YEAR(created_at) AS year, WEEK(created_at, 1) AS week, COUNT(*) AS total')
            ->groupBy('year', 'week')
            ->orderBy('year')
            ->orderBy('week')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => "{$item->year} - S{$item->week}",
                    'total' => $item->total,
                ];
            });
    }

    public function getMonthlyStats()
    {
        return Courrier::selectRaw('DATE_FORMAT(created_at, "%Y-%m") AS month, COUNT(*) AS total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->month,
                    'total' => $item->total,
                ];
            });
    }

    public function getTotalCourriers()
    {
        return Courrier::count();
    }
}
