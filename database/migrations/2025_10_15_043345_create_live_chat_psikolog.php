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
        Schema::create('live_chat_psikolog', function (Blueprint $table) {
            $table->id('id_live_chat_psikolog');
            $table->foreignId('id_korban')->constrained('korban', 'id_korban');
            $table->foreignId('id_psikolog')->constrained('psikolog', 'id_psikolog');
            $table->enum('status', ['terkirim', 'dibaca']); // Status pesan
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('ended_at')->nullable();
            // $table->enum('roles', ['korban', 'psikolog']); // Menandai siapa pengirim pesan, korban atau psikolog
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_chat_psikolog');
    }
};
