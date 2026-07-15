<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\Services\Monitoring\MonitoringDashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly MonitoringDashboardService $dashboardService) {}

    public function __invoke(): View
    {
        return view('monitoring.dashboard', [
            'widgets' => $this->dashboardService->widgets(),
            'dummyChart' => $this->dashboardService->dummyChart(),
            'statusDistribution' => $this->dashboardService->statusDistribution(),
        ]);
    }
}
