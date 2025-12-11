<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('selfhealing', function (Blueprint $table) {
            $table->id('id_selfhealing');
            $table->unsignedBigInteger('id_emosi')->nullable();
            $table->string('jenis_konten');
            $table->string('judul');
            $table->string('link_konten')->nullable();
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->string('audio')->nullable();
            $table->timestamps();

            $table->foreign('id_emosi')->references('id_emosi')->on('emosi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('selfhealing');
    }
};
