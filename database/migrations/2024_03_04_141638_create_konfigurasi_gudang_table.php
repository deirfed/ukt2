<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konfigurasi_gudang', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('gudang_id')->unsigned()->nullable();
            $table->bigInteger('pulau_id')->unsigned()->nullable();
            $table->bigInteger('seksi_id')->unsigned()->nullable();
            $table->year('periode')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('gudang_id')->on('gudang')->references('id');
            $table->foreign('pulau_id')->on('pulau')->references('id');
            $table->foreign('seksi_id')->on('seksi')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_gudang');
    }
};
