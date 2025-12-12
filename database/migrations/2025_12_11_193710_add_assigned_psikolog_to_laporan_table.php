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
        Schema::table('laporan', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned_psikolog_id')->nullable();
            $table->foreign('assigned_psikolog_id')
                  ->references('id_psikolog') 
                  ->on('psikolog')
                  ->nullOnDelete();
            $table->timestamp('assigned_at')->nullable()->after('assigned_psikolog_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropForeign(['assigned_psikolog_id']);
            $table->dropColumn('assigned_psikolog_id');
            $table->dropColumn('assigned_at');;
        });
    }
};
