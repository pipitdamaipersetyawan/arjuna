<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoUrutColumnToNaskahs extends Migration
{
   public function up(): void
{
    Schema::table('naskahs', function (Blueprint $table) {

        if (!Schema::hasColumn('naskahs', 'no_urut')) {
            $table->string('no_urut')->nullable()->after('nomor_naskah')->index();
        }

    });
}

    public function down(): void
    {
        Schema::table('naskahs', function (Blueprint $table) {
            $table->dropColumn('no_urut');
        });
    }
}
