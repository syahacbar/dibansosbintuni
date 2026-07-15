<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Services\Operator\OperatorPengajuanService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly OperatorPengajuanService $pengajuanService) {}

    public function __invoke(): View
    {
        return view('operator.dashboard', [
            'stats' => $this->pengajuanService->stats(),
        ]);
    }
}
