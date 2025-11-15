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
        Schema::create('task_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->string('duration')->nullable();
            $table->string('description')->nullable();
            $table->enum('step', ['step_1', 'step_2', 'step_3'])->default('step_1');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('real_start_date')->nullable();
            $table->date('real_end_date')->nullable();
            $table->unique(['task_id','step']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_steps');
    }
};
