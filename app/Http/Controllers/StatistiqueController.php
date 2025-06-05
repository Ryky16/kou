<?php

namespace App\Http\Controllers;

use App\Services\StatistiqueService;

class StatistiqueController extends Controller
{
    protected $statistiqueService;

    public function __construct(StatistiqueService $statistiqueService)
    {
        $this->statistiqueService = $statistiqueService;
    }

    public function index()
    {
        $weeklyStats = $this->statistiqueService->getWeeklyStats();
        $monthlyStats = $this->statistiqueService->getMonthlyStats();

        return view('statistiques.index', compact('weeklyStats', 'monthlyStats'));
    }
}
