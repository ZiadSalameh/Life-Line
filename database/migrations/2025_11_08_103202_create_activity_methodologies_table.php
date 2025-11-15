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
        Schema::create('activity_methodologies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projectproposal_id')->constrained('project_proposals')->cascadeOnDelete();
            $table->string('activity_methodology_name');
            $table->string('proposed_implementation_period')->nullable();
            $table->string('logistical_requirements')->nullable();
            $table->string('outputs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_methodologies');
    }
};
