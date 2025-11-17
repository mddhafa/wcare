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
            $table->unsignedBigInteger('jenis_konten')->nullable();
            $table->foreign('jenis_konten')->references('id')->on('jenis_konten')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selfhealing', function (Blueprint $table) {
            $table->dropForeign(['jenis_konten']);
            $table->dropColumn('jenis_konten');
        });
    }
};
