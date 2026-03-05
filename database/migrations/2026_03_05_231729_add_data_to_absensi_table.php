<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->text('lokasi_masuk')->nullable();
            $table->text('lokasi_pulang')->nullable();
            $table->text('dokumentasi_masuk')->nullable();
            $table->text('dokumentasi_pulang')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropColumn('lokasi_masuk');
            $table->dropColumn('lokasi_pulang');
            $table->dropColumn('dokumentasi_masuk');
            $table->dropColumn('dokumentasi_pulang');
        });
    }
};
