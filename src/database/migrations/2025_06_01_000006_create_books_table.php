<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->string('isbn')->nullable()->unique();
            $table->string('issn')->nullable();
            $table->string('edition')->nullable();
            $table->foreignId('publisher_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->year('publication_year')->nullable();
            $table->integer('pages')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->string('language')->default('Indonesia');
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('ddc_classification')->nullable();
            $table->text('subject_headings')->nullable();
            $table->text('abstract')->nullable();
            $table->enum('status', ['available', 'unavailable', 'weeding'])->default('available');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
