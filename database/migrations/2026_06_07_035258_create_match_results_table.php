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
        Schema::create('match_results', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('job_offer_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('candidate_profile_id')->constrained()->cascadeOnDelete();
            $table->boolean('passed_blocking')->index();
            $table->decimal('score_skills', 5, 2)->nullable();
            $table->decimal('score_experience', 5, 2)->nullable();
            $table->decimal('score_education', 5, 2)->nullable();
            $table->decimal('score_availability', 5, 2)->nullable();
            $table->decimal('score_location', 5, 2)->nullable();
            $table->decimal('score_salary', 5, 2)->nullable();
            $table->decimal('score_principal', 5, 2)->nullable()->index();
            $table->json('assets_matched')->nullable();
            $table->json('extra_skills')->nullable();
            $table->boolean('is_stale')->default(false)->index();
            $table->timestamp('calculated_at');
            $table->unique(['job_offer_id', 'candidate_profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_results');
    }
};
