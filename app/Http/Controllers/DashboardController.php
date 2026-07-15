<?php

namespace App\Http\Controllers;

use App\Services\Mahasiswa\DashboardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $dashboardService) {}

    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();

        if ($user->hasRole('Super Admin')) {
            return redirect()->route('monitoring.dashboard');
        }

        if ($user->hasRole('Operator')) {
            return redirect()->route('operator.dashboard');
        }

        return view('mahasiswa.dashboard', [
            'latestPengajuan' => $this->dashboardService->latestPengajuan($user),
            'history' => $this->dashboardService->history($user),
            'summary' => $this->dashboardService->summary($user),
        ]);
    }
}
