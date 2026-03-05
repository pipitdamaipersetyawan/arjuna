<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixNomorNaskahColumn extends Migration
{
    public function up(): void
    {
        Schema::table('naskahs', function (Blueprint $table) {

            if (Schema::hasColumn('naskahs', 'nomor_urut')) {
                $table->dropColumn('nomor_urut');
            }

           $table->string('nomor_naskah')->change();

        });
    }

    public function down(): void
    {
        Schema::table('naskahs', function (Blueprint $table) {

            $table->dropUnique(['nomor_naskah']);

            $table->string('nomor_naskah')->nullable()->change();
            $table->string('nomor_urut')->nullable();

        });
    }
}
