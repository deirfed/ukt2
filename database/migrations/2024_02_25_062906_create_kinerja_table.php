<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kinerja', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('ticket_number')->unique();
            $table->bigInteger('formasi_tim_id')->unsigned()->nullable();
            $table->bigInteger('unitkerja_id')->unsigned()->nullable();
            $table->bigInteger('seksi_id')->unsigned()->nullable();
            $table->bigInteger('tim_id')->unsigned()->nullable();
            $table->bigInteger('pulau_id')->unsigned()->nullable();
            $table->bigInteger('koordinator_id')->unsigned()->nullable();
            $table->bigInteger('anggota_id')->unsigned()->nullable();
            $table->string('kegiatan')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('lokasi')->nullable();
            $table->dateTime('mulai')->nullable();
            $table->dateTime('selesai')->nullable();
            $table->string('photo_before')->nullable();
            $table->string('photo_after')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('formasi_tim_id')->on('formasi_tim')->references('id');
            $table->foreign('unitkerja_id')->on('unitkerja')->references('id');
            $table->foreign('seksi_id')->on('seksi')->references('id');
            $table->foreign('tim_id')->on('tim')->references('id');
            $table->foreign('pulau_id')->on('pulau')->references('id');
            $table->foreign('koordinator_id')->on('users')->references('id');
            $table->foreign('anggota_id')->on('users')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja');
    }
};