<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_peringatan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('nomor')->unique()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->enum('jenis', ['SP1', 'SP2', 'SP3'])->nullable();
            $table->date('tanggal')->nullable();
            $table->date('tanggal_berlaku')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->text('alasan')->nullable();
            $table->text('sanksi')->nullable();
            $table->text('dokumen')->nullable();
            $table->enum('status', ['aktif', 'kadaluarsa', 'dicabut'])->default('aktif')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_peringatan');
    }
};
