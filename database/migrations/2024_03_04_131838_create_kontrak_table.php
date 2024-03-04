<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontrak', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('no_kontrak');
            $table->year('periode');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontrak');
    }
};
