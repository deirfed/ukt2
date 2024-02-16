<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('seksi', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('code')->nullable();
            $table->bigInteger('unitkerja_id')->unsigned();
            $table->bigInteger('walikota_id')->unsigned();
            $table->bigInteger('provinsi_id')->unsigned();
            $table->bigInteger('admin_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('unitkerja_id')->on('unitkerja')->references('id');
            $table->foreign('walikota_id')->on('walikota')->references('id');
            $table->foreign('provinsi_id')->on('provinsi')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seksi');
    }
};
