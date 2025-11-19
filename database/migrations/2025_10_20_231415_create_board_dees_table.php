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
        Schema::create('board_dees', function (Blueprint $table) {
            $table->id();
            $table->integer('board_no');
            $table->date('boar_dee_date')->nullable();
            $table->string('description')->nullable();
            $table->string('voted')->nullable();
            $table->foreignId('meeting_id')->constrained('meetings')->cascadeOnDelete();
            $table->unique(['board_no', 'meeting_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_dees');
    }
};
