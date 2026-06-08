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
        Schema::table('recruiter_profiles', function (Blueprint $table) {
            $table->foreignId('is_managed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_suspended')->default(false);
            $table->timestamp('suspended_at')->nullable();
        });

        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->boolean('is_suspended')->default(false);
            $table->timestamp('suspended_at')->nullable();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users');
            $table->morphs('reportable');
            $table->string('reason'); // Using string for Enum flexibility
            $table->text('comment')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->unique(['reporter_id', 'reportable_type', 'reportable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');

        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropColumn(['is_suspended', 'suspended_at']);
        });

        Schema::table('recruiter_profiles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('is_managed_by');
            $table->dropColumn(['is_suspended', 'suspended_at']);
        });
    }
};
