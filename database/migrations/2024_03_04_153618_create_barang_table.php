<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('kontrak_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('merk')->nullable();
            $table->string('jenis')->nullable();
            $table->string('stock_awal')->nullable();
            $table->string('satuan')->nullable();
            $table->string('harga')->nullable();
            $table->string('spesifikasi')->nullable();

            $table->foreign('kontrak_id')->on('kontrak')->references('id');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
