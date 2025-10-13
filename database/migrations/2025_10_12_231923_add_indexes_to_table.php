<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Absensi
        Schema::table('absensi', function (Blueprint $table) {
            if (!Schema::hasIndex('absensi', 'absensi_tanggal_index')) {
                $table->index('tanggal', 'absensi_tanggal_index');
            }
            if (!Schema::hasIndex('absensi', 'absensi_user_id_tanggal_index')) {
                $table->index(['user_id', 'tanggal'], 'absensi_user_id_tanggal_index');
            }
        });

        // Kinerja
        Schema::table('kinerja', function (Blueprint $table) {
            if (!Schema::hasColumn('kinerja', 'tanggal')) return;
            if (!Schema::hasIndex('kinerja', 'kinerja_tanggal_index')) {
                $table->index('tanggal', 'kinerja_tanggal_index');
            }
        });

        // Pengiriman Barang
        Schema::table('pengiriman_barang', function (Blueprint $table) {
            if (!Schema::hasIndex('pengiriman_barang', 'pengiriman_barang_tanggal_kirim_index')) {
                $table->index('tanggal_kirim', 'pengiriman_barang_tanggal_kirim_index');
            }
            if (!Schema::hasIndex('pengiriman_barang', 'pengiriman_barang_tanggal_terima_index')) {
                $table->index('tanggal_terima', 'pengiriman_barang_tanggal_terima_index');
            }
        });

        // Cuti
        Schema::table('cuti', function (Blueprint $table) {
            if (!Schema::hasIndex('cuti', 'cuti_user_tanggal_index')) {
                $table->index(['user_id', 'tanggal_awal', 'tanggal_akhir'], 'cuti_user_tanggal_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropIndex('absensi_tanggal_index');
            $table->dropIndex('absensi_user_id_tanggal_index');
        });

        Schema::table('kinerja', function (Blueprint $table) {
            if (Schema::hasColumn('kinerja', 'tanggal')) {
                $table->dropIndex('kinerja_tanggal_index');
            }
        });

        Schema::table('pengiriman_barang', function (Blueprint $table) {
            $table->dropIndex('pengiriman_barang_tanggal_kirim_index');
            $table->dropIndex('pengiriman_barang_tanggal_terima_index');
        });

        Schema::table('cuti', function (Blueprint $table) {
            $table->dropIndex('cuti_user_tanggal_index');
        });
    }
};
