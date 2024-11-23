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
        // Drop existing tables if they exist
        Schema::dropIfExists('results');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('tests');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('topics');
        
        // Create topics table first (no dependencies)
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description');
            $table->integer('order')->default(1);
            $table->enum('status', ['active', 'draft', 'archived'])->default('active');
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->integer('estimated_time')->nullable(); // in minutes
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes
            $table->index('status');
            $table->index('order');
        });

        // Create lessons table (depends on topics)
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('content');
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->integer('estimated_time')->nullable(); // in minutes
            $table->string('attachment')->nullable();
            $table->integer('order')->default(1);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes for better performance
            $table->index(['topic_id', 'status']);
            $table->index('difficulty_level');
            $table->index('order');
        });

        // Create tests table (depends on topics)
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->integer('time_limit')->default(30); // in minutes
            $table->integer('passing_score')->default(70); // percentage
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamps();
            $table->softDeletes();

            // Add indexes
            $table->index(['topic_id', 'status']);
            $table->index('difficulty');
        });

        // Create questions table (depends on tests)
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->json('options'); // Array of possible answers
            $table->string('correct_answer');
            $table->integer('points')->default(1);
            $table->text('explanation')->nullable(); // Explanation for the correct answer
            $table->integer('order')->default(1);
            $table->timestamps();
            $table->softDeletes();

            // Add indexes
            $table->index(['test_id', 'order']);
        });

        // Create results table (depends on tests and users)
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('test_id')->constrained()->onDelete('cascade');
            $table->integer('score');
            $table->integer('time_taken'); // in seconds
            $table->json('answers'); // User's answers for each question
            $table->timestamp('completed_at');
            $table->timestamps();
            $table->softDeletes();

            // Add indexes
            $table->index(['user_id', 'test_id']);
            $table->index('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order of creation
        Schema::dropIfExists('results');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('tests');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('topics');
    }
};
