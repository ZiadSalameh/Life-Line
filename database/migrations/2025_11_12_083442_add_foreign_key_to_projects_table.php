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
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('board_dee_id')->constrained('board_dees')->cascadeOnDelete();
            $table->string('project_no');
            $table->unique(['project_no', 'board_dee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // $table->dropForeign(['board_dee_id']);
            // $table->dropIndex(['board_dee_id']);
        });
    }
};
