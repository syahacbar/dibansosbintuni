<?php

namespace App\Http\Controllers\Operator;

use App\Enums\PengajuanStatus;
use App\Enums\StudentDocumentType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\VerificationRequest;
use App\Models\JenisBantuan;
use App\Models\Pengajuan;
use App\Models\PeriodeBansos;
use App\Services\Operator\OperatorPengajuanService;
use App\Services\Operator\VerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengajuanController extends Controller
{
    public function __construct(
        private readonly OperatorPengajuanService $pengajuanService,
        private readonly VerificationService $verificationService,
    ) {}

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
            'pengajuan' => $this->pengajuanService->findForDetail($this->verificationService->runSystemLayers($pengajuan)),
            'documentTypes' => StudentDocumentType::options(),
        ]);
    }

    public function verify(VerificationRequest $request, Pengajuan $pengajuan): RedirectResponse
    {
        $this->verificationService->humanDecision(
            $pengajuan,
            $request->user(),
            $request->validated('decision'),
            $request->validated('notes'),
        );

        return redirect()
            ->route('operator.pengajuan.show', $pengajuan)
            ->with('success', 'Keputusan verifikasi berhasil disimpan.');
    }

    public function salurkan(Request $request, Pengajuan $pengajuan): RedirectResponse
    {
        $request->validate([
            'nomor_sp2d' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $this->verificationService->markAsDisalurkan(
            $pengajuan,
            $request->user(),
            $request->input('nomor_sp2d'),
            $request->input('notes'),
        );

        return redirect()
            ->route('operator.pengajuan.show', $pengajuan)
            ->with('success', 'Bantuan sosial berhasil ditandai sebagai Disalurkan.');
    }

    public function penerima(Request $request): View
    {
        $filters = $request->only(['search', 'periode_bansos_id', 'jenis_bantuan_id']);
        $query = Pengajuan::with(['user.mahasiswaProfile', 'periodeBansos', 'jenisBantuan'])
            ->whereIn('status', [PengajuanStatus::Disetujui, PengajuanStatus::Disalurkan]);

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%")
                      ->orWhereHas('mahasiswaProfile', fn ($qp) => $qp->where('nim', 'like', "%{$search}%")->orWhere('nik', 'like', "%{$search}%"));
                })->orWhere('nomor_pengajuan', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['periode_bansos_id'])) {
            $query->where('periode_bansos_id', $filters['periode_bansos_id']);
        }

        if (! empty($filters['jenis_bantuan_id'])) {
            $query->where('jenis_bantuan_id', $filters['jenis_bantuan_id']);
        }

        return view('operator.penerima.index', [
            'pengajuans' => $query->latest('verified_at')->paginate(15),
            'filters' => $filters,
            'periodes' => PeriodeBansos::orderByDesc('tanggal_mulai')->get(),
            'jenisBantuans' => JenisBantuan::orderBy('nama')->get(),
        ]);
    }
}
