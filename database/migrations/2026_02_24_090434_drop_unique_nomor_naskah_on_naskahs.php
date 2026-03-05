<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('naskahs', function (Blueprint $table) {

            // pastikan nama index benar
            $table->dropUnique(['nomor_naskah']);

        });
    }

    public function down(): void
    {
        Schema::table('naskahs', function (Blueprint $table) {

            // kembalikan unique saat rollback
            $table->unique('nomor_naskah');

        });
    }
};
