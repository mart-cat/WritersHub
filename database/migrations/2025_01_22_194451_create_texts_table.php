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
        Schema::create('texts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->foreignId('genre_id')->constrained('genres')->onDelete('cascade');
            $table->text('description');
            $table->json('tags')->nullable();
            $table->enum('status', ['in progress', 'completed', 'frozen'])->default('in progress');
            $table->enum('size', ['mini', 'standard', 'maxi']);
            $table->text('warnings')->nullable();
            $table->string('age_rating')->default('0+');
            $table->string('dedication')->nullable();
            $table->enum('publication_permission', ['allowed', 'forbidden', 'author_only'])->default('author_only');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('texts');
    }
};
