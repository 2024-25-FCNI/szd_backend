<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('termeks', function (Blueprint $table) {
            $table->id('termek_id');
            $table->string('cim');
            $table->string('leiras');
            $table->string('url');
            $table->integer('hozzaferesi_ido');
            $table->integer('ar');
            $table->string('jelzes');
            $table->foreignId('cimke_id')->references('cimke_id')->on('cimkes');
            $table->string('kep');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('termeks');
    }
};
