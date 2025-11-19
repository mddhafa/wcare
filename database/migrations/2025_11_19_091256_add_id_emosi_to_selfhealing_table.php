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
        Schema::table('selfhealing', function (Blueprint $table) {
            $table->unsignedBigInteger('id_emosi')->nullable();
            $table->foreign('id_emosi')->references('id_emosi')->on('emosi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selfhealing', function (Blueprint $table) {
            $table->dropForeign(['id_emosi']);
            $table->dropColumn('id_emosi');
        });
    }
};
