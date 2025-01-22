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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('text_id')->constrained('texts')->onDelete('cascade');
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('favorites_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
