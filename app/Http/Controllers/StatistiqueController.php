<?php

namespace App\Http\Controllers;

use App\Services\StatistiqueService;
use Illuminate\Http\Request;
use App\Models\Courrier;
use Carbon\Carbon;

class StatistiqueController extends Controller
{
    protected $statistiqueService;

    public function __construct(StatistiqueService $statistiqueService)
    {
        $this->statistiqueService = $statistiqueService;
    }

    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);

        $weeklyStats = $this->statistiqueService->getWeeklyStats();
        $monthlyStats = $this->statistiqueService->getMonthlyStats($year);
        $totalCourriers = $this->statistiqueService->getTotalCourriers();

        // Chart.js: données par mois
        $monthlyChartData = Courrier::selectRaw('MONTH(date_reception) as month, COUNT(*) as total')
            ->whereYear('date_reception', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(fn($item) => [$item->month => $item->total]);

        // Toujours 12 mois
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyChartData[$i] ?? 0;
        }

        // Liste des années disponibles
        $availableYears = Courrier::selectRaw('YEAR(date_reception) as year')
            ->groupBy('year')
            ->orderByDesc('year')
            ->pluck('year');

        return view('statistiques.index', compact(
            'weeklyStats',
            'monthlyStats',
            'totalCourriers',
            'chartData',
            'availableYears',
            'year'
        ));
    }
}
