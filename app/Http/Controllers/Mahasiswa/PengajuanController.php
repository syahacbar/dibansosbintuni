<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mahasiswa\PengajuanRequest;
use App\Models\JenisBantuan;
use App\Models\Pengajuan;
use App\Models\PeriodeBansos;
use App\Services\Mahasiswa\PengajuanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengajuanController extends Controller
{
    public function __construct(private readonly PengajuanService $pengajuanService) {}

    public function index(Request $request): View
    {
        return view('mahasiswa.pengajuan.index', [
            'pengajuans' => $this->pengajuanService->paginateForUser($request->user()),
        ]);
    }

    public function create(): View
    {
        return view('mahasiswa.pengajuan.form', [
            'pengajuan' => null,
            'periodes' => PeriodeBansos::where('aktif', true)->orderByDesc('tanggal_mulai')->get(),
            'jenisBantuans' => JenisBantuan::where('aktif', true)->orderBy('nama')->get(),
            'action' => route('mahasiswa.pengajuan.store'),
            'method' => 'POST',
        ]);
    }

    public function store(PengajuanRequest $request): RedirectResponse
    {
        $pengajuan = $this->pengajuanService->createDraft($request->user(), $request->validated());

        return redirect()
            ->route('mahasiswa.pengajuan.show', $pengajuan)
            ->with('success', 'Draft pengajuan berhasil dibuat.');
    }

    public function show(Request $request, Pengajuan $pengajuan): View
    {
        $this->ensureOwnedByUser($request, $pengajuan);

        return view('mahasiswa.pengajuan.show', [
            'pengajuan' => $pengajuan->load(['periodeBansos', 'jenisBantuan', 'timelines']),
        ]);
    }

    public function edit(Request $request, Pengajuan $pengajuan): View
    {
        $this->ensureOwnedByUser($request, $pengajuan);
        abort_unless($pengajuan->isDraft(), 403);

        return view('mahasiswa.pengajuan.form', [
            'pengajuan' => $pengajuan,
            'periodes' => PeriodeBansos::where('aktif', true)->orderByDesc('tanggal_mulai')->get(),
            'jenisBantuans' => JenisBantuan::where('aktif', true)->orderBy('nama')->get(),
            'action' => route('mahasiswa.pengajuan.update', $pengajuan),
            'method' => 'PUT',
        ]);
    }

    public function update(PengajuanRequest $request, Pengajuan $pengajuan): RedirectResponse
    {
        $this->ensureOwnedByUser($request, $pengajuan);
        abort_unless($pengajuan->isDraft(), 403);

        $this->pengajuanService->updateDraft($pengajuan, $request->validated());

        return redirect()
            ->route('mahasiswa.pengajuan.show', $pengajuan)
            ->with('success', 'Draft pengajuan berhasil diperbarui.');
    }

    public function submit(Request $request, Pengajuan $pengajuan): RedirectResponse
    {
        $this->ensureOwnedByUser($request, $pengajuan);

        $this->pengajuanService->submit($pengajuan);

        return redirect()
            ->route('mahasiswa.pengajuan.show', $pengajuan)
            ->with('success', 'Pengajuan bantuan berhasil diajukan.');
    }

    private function ensureOwnedByUser(Request $request, Pengajuan $pengajuan): void
    {
        abort_unless($pengajuan->user_id === $request->user()->id, 403);
    }
}
