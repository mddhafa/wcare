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
        Schema::create('emosi', function (Blueprint $table) {
            $table->id('id_emosi');
            $table->foreignId('id_korban')->constrained('korban', 'id_korban');
            $table->integer('skor');
            $table->string('jenis_emosi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emosi');
    }
};
