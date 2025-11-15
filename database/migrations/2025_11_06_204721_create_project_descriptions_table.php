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
        Schema::create('project_descriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projectproposal_id')->constrained('project_proposals')->cascadeOnDelete();
            $table->string('project_proposal_name');
            $table->string('duration_project_proposal')->nullable();
            $table->string('target_area')->nullable();
            $table->string('target_group')->nullable();
            $table->string('no_of_direct_benif')->nullable();
            $table->decimal('estimate_cost',10,2)->nullable();
            $table->string('partners')->nullable();
            $table->string('over_all_project_goal')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_descriptions');
    }
};
