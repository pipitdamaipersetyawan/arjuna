<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('naskahs', function (Blueprint $table) {
            $table->string('no_urut')->nullable()->index()->after('nomor_naskah');
        });
    }

    public function down(): void
    {
        Schema::table('naskahs', function (Blueprint $table) {
            $table->dropColumn('no_urut');
        });
    }
};
