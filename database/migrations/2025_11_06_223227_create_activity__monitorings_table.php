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
        Schema::create('activity__monitorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projectproposal_id')->constrained('project_proposals')->cascadeOnDelete();
            $table->string('name');
            $table->string('monitors_name')->nullable();
            $table->date('date_tracking')->nullable();
            $table->text('monitors_note')->nullable();
            $table->string('monitroing_mechanism')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity__monitorings');
    }
};
