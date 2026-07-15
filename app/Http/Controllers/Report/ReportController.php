<?php

namespace App\Http\Controllers\Report;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Services\Report\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reportService) {}

    public function index(Request $request): View
    {
        $type = $this->normalizeType($request->string('type')->toString() ?: 'mahasiswa');

        return view('reports.index', [
            'type' => $type,
            'types' => $this->types(),
            'title' => $this->reportService->title($type),
            'headings' => $this->reportService->headings($type),
            'rows' => $this->reportService->rows($type),
        ]);
    }

    public function pdf(string $type): Response
    {
        $type = $this->normalizeType($type);

        $pdf = Pdf::loadView('reports.pdf', [
            'title' => $this->reportService->title($type),
            'headings' => $this->reportService->headings($type),
            'rows' => $this->reportService->rows($type),
            'generatedAt' => now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download($this->reportService->filename($type, 'pdf'));
    }

    public function excel(string $type): BinaryFileResponse
    {
        $type = $this->normalizeType($type);

        return Excel::download(
            new ReportExport(
                $this->reportService->headings($type),
                $this->reportService->rows($type),
            ),
            $this->reportService->filename($type, 'xlsx'),
        );
    }

    private function normalizeType(string $type): string
    {
        abort_unless(array_key_exists($type, $this->types()), 404);

        return $type;
    }

    private function types(): array
    {
        return [
            'mahasiswa' => 'Mahasiswa',
            'pengajuan' => 'Pengajuan',
            'penerima' => 'Penerima',
        ];
    }
}
