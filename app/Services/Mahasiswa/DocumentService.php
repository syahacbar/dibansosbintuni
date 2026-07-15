<?php

namespace App\Services\Mahasiswa;

use App\Enums\StudentDocumentType;
use App\Models\MahasiswaDocument;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    /**
     * @return Collection<string, MahasiswaDocument>
     */
    public function documentsForUser(User $user): Collection
    {
        return $user->mahasiswaDocuments()
            ->latest()
            ->get()
            ->keyBy(fn (MahasiswaDocument $document): string => $document->document_type->value);
    }

    public function upload(User $user, StudentDocumentType $type, UploadedFile $file): MahasiswaDocument
    {
        $existing = $user->mahasiswaDocuments()
            ->where('document_type', $type->value)
            ->first();

        if ($existing) {
            Storage::disk('public')->delete($existing->file_path);
        }

        $path = $file->store("mahasiswa/{$user->id}/documents", 'public');

        return MahasiswaDocument::updateOrCreate(
            [
                'user_id' => $user->id,
                'document_type' => $type->value,
            ],
            [
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ],
        );
    }

    public function delete(User $user, StudentDocumentType $type): void
    {
        $document = $user->mahasiswaDocuments()
            ->where('document_type', $type->value)
            ->first();

        if (! $document) {
            return;
        }

        Storage::disk('public')->delete($document->file_path);
        $document->delete();
    }
}
