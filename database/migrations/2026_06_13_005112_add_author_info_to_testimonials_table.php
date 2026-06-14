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
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('author_name')->nullable();
            $table->string('author_role')->nullable();
            $table->string('author_company')->nullable();
            $table->string('author_color')->nullable();
            $table->string('author_badge')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['author_name', 'author_role', 'author_company', 'author_color', 'author_badge']);
        });
    }
};
