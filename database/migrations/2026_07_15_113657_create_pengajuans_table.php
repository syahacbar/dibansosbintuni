<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('periode_bansos_id')->constrained('periode_bansos')->cascadeOnDelete();
            $table->foreignId('jenis_bantuan_id')->constrained('jenis_bantuans')->cascadeOnDelete();
            $table->string('nomor_pengajuan')->unique();
            $table->string('status', 30)->default('draft');
            $table->text('catatan')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'periode_bansos_id', 'jenis_bantuan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
