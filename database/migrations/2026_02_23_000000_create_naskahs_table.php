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
       Schema::create('naskahs', function (Blueprint $table) {

    $table->id();

    $table->date('tanggal_surat');

    $table->string('pengirim');

    $table->string('jenis_naskah');

    $table->string('sifat_naskah');
    $table->string('kode_sifat');

    $table->string('klasifikasi_kode');

    // 🔥 NOMOR MANUAL & UNIK
    $table->string('nomor_naskah')->unique();

    $table->string('hal');
    $table->text('ringkasan');

    $table->string('file')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('naskahs');
    }
};
