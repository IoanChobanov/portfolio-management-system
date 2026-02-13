<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Clients
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('site_url')->nullable();
            $table->string('contact_email');
            $table->timestamps();
        });

        // 2. Technologies
        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // 3. Projects
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->date('started_at')->nullable();
            $table->date('finished_at')->nullable();
            $table->enum('status', ['idea', 'in_progress', 'completed', 'on_hold'])->default('idea');
            $table->timestamps();

        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE projects ADD CONSTRAINT check_dates CHECK (finished_at >= started_at)');
        }

        // 4. Project <-> Client 
        Schema::create('project_client', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->primary(['project_id', 'client_id']); 
        });

        // 5. Project <-> Technology
        Schema::create('project_technology', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('technology_id')->constrained()->cascadeOnDelete();
            $table->primary(['project_id', 'technology_id']); 
        });

        // 6. Media (Gallery)
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('file_path');
            $table->string('kind')->default('image'); 
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();
        });

        // 7. Testimonials
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('author');
            $table->text('quote');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('media');
        Schema::dropIfExists('project_technology');
        Schema::dropIfExists('project_client');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('technologies');
        Schema::dropIfExists('clients');
    }
};
