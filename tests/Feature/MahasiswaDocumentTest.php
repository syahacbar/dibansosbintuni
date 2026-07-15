<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MahasiswaDocumentTest extends TestCase
{
    use RefreshDatabase;

    public function test_document_page_can_be_accessed(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('mahasiswa.documents.index'))
            ->assertOk()
            ->assertSee('Upload Dokumen Mahasiswa')
            ->assertSee('KTP');
    }

    public function test_document_can_be_uploaded_and_deleted(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('ktp.jpg');

        $this->actingAs($user)
            ->post(route('mahasiswa.documents.store'), [
                'document_type' => 'ktp',
                'document_file' => $file,
            ])
            ->assertRedirect(route('mahasiswa.documents.index'));

        $document = $user->mahasiswaDocuments()->firstOrFail();

        Storage::disk('public')->assertExists($document->file_path);
        $this->assertDatabaseHas('mahasiswa_documents', [
            'user_id' => $user->id,
            'document_type' => 'ktp',
            'original_name' => 'ktp.jpg',
        ]);

        $this->actingAs($user)
            ->delete(route('mahasiswa.documents.destroy', 'ktp'))
            ->assertRedirect(route('mahasiswa.documents.index'));

        Storage::disk('public')->assertMissing($document->file_path);
        $this->assertDatabaseMissing('mahasiswa_documents', [
            'user_id' => $user->id,
            'document_type' => 'ktp',
        ]);
    }

    public function test_document_upload_validates_file_type(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create())
            ->post(route('mahasiswa.documents.store'), [
                'document_type' => 'ktp',
                'document_file' => UploadedFile::fake()->create('script.exe', 10, 'application/octet-stream'),
            ])
            ->assertSessionHasErrors('document_file');
    }
}
