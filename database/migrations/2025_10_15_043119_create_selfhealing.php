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
        Schema::create('selfhealing', function (Blueprint $table) {
            $table->id('id_selfhealing');
            // $table->foreignId('id_admin')->constrained('admin');
            $table->string('jenis_konten');
            $table->string('judul');
            $table->string('link_konten');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selfhealing');
    }
};
