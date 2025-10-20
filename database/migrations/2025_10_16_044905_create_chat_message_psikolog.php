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
        Schema::create('chat_message_psikolog', function (Blueprint $table) {
            $table->id('id_message');
            $table->foreignId('id_live_chat_psikolog')->constrained('live_chat_psikolog', 'id_live_chat_psikolog')->onDelete('cascade');
            $table->enum('sender_type', ['korban', 'psikolog']); // siapa pengirimnya
            $table->unsignedBigInteger('sender_id'); // id pengirim (id_Korban atau id_Psikolog)
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_message_psikolog');
    }
};
