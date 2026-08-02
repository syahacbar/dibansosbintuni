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
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->timestamp('disalurkan_at')->nullable()->after('verified_at');
            $table->string('nomor_sp2d')->nullable()->after('disalurkan_at');
            $table->text('catatan_penyaluran')->nullable()->after('nomor_sp2d');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn(['disalurkan_at', 'nomor_sp2d', 'catatan_penyaluran']);
        });
    }
};
