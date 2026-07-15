<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Services\Mahasiswa\DashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $dashboardService) {}

    public function __invoke(Request $request): View
    {
        return view('mahasiswa.dashboard', [
            'latestPengajuan' => $this->dashboardService->latestPengajuan($request->user()),
            'history' => $this->dashboardService->history($request->user()),
            'summary' => $this->dashboardService->summary($request->user()),
        ]);
    }
}
