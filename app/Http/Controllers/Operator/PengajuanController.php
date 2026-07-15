<?php

namespace App\Http\Controllers\Operator;

use App\Enums\PengajuanStatus;
use App\Enums\StudentDocumentType;
use App\Http\Controllers\Controller;
use App\Models\JenisBantuan;
use App\Models\Pengajuan;
use App\Models\PeriodeBansos;
use App\Services\Operator\OperatorPengajuanService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengajuanController extends Controller
{
    public function __construct(private readonly OperatorPengajuanService $pengajuanService) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'periode_bansos_id', 'jenis_bantuan_id']);

        return view('operator.pengajuan.index', [
            'pengajuans' => $this->pengajuanService->paginate($filters),
            'filters' => $filters,
            'statuses' => PengajuanStatus::cases(),
            'periodes' => PeriodeBansos::orderByDesc('tanggal_mulai')->get(),
            'jenisBantuans' => JenisBantuan::orderBy('nama')->get(),
        ]);
    }

    public function show(Pengajuan $pengajuan): View
    {
        return view('operator.pengajuan.show', [
            'pengajuan' => $this->pengajuanService->findForDetail($pengajuan),
            'documentTypes' => StudentDocumentType::options(),
        ]);
    }
}
