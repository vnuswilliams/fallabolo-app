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
        Schema::create('job_offers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('recruiter_profile_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('template');
            $table->string('city');
            $table->string('region')->nullable();
            $table->string('country')->default('Cameroun');

            // Blocking criteria
            $table->string('blocking_language')->nullable();
            $table->string('blocking_education')->nullable();
            $table->string('blocking_experience')->nullable();
            $table->string('blocking_availability')->nullable();
            $table->string('blocking_permit')->nullable();

            // Scored requirements
            $table->string('required_experience');
            $table->string('required_education');
            $table->string('required_availability');
            $table->integer('budget_min')->nullable();
            $table->integer('budget_max')->nullable();

            // Assets
            $table->json('required_assets')->nullable();

            // Lifecycle
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
