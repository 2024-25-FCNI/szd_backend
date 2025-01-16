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
        Schema::create('vasarlas_fejs', function (Blueprint $table) {
            $table->id('vasarlas_id');
            $table->foreignId('user_id')->references('user_id')->on('users');
            $table->integer('osszeg');
            $table->date('datum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vasarlas_fejs');
    }
};
