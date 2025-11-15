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
        Schema::create('partner_entities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('qualification_field_work')->nullable();
            $table->string('role_responsibility')->nullable();
            $table->foreignId('projectproposal_id')->constrained('project_proposals')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_entities');
    }
};
