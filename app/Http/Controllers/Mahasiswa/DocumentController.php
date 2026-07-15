<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Enums\StudentDocumentType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mahasiswa\DocumentUploadRequest;
use App\Services\Mahasiswa\DocumentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function __construct(private readonly DocumentService $documentService) {}

    public function index(Request $request): View
    {
        return view('mahasiswa.documents', [
            'documentTypes' => StudentDocumentType::options(),
            'documents' => $this->documentService->documentsForUser($request->user()),
        ]);
    }

    public function store(DocumentUploadRequest $request): RedirectResponse
    {
        $this->documentService->upload(
            $request->user(),
            StudentDocumentType::from($request->validated('document_type')),
            $request->file('document_file'),
        );

        return redirect()
            ->route('mahasiswa.documents.index')
            ->with('success', 'Dokumen mahasiswa berhasil diunggah.');
    }

    public function destroy(Request $request, string $documentType): RedirectResponse
    {
        $this->documentService->delete($request->user(), StudentDocumentType::from($documentType));

        return redirect()
            ->route('mahasiswa.documents.index')
            ->with('success', 'Dokumen mahasiswa berhasil dihapus.');
    }
}
