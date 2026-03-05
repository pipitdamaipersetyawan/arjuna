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
        Schema::create('naskah_tujuan', function (Blueprint $table) {
    $table->id();

    $table->foreignId('naskah_id')
          ->constrained('naskahs')   // ⬅️ sesuaikan dengan nama tabel naskah
          ->cascadeOnDelete();

    $table->foreignId('tujuan_id')
          ->constrained('tujuan')    // ⬅️ INI YANG PENTING
          ->cascadeOnDelete();

});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('naskah_tujuan');
    }
};
