<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_copies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bookshelf_id')->nullable()->constrained()->nullOnDelete();
            $table->string('barcode')->unique();
            $table->enum('condition', ['good', 'fair', 'damaged', 'lost'])->default('good');
            $table->enum('status', ['available', 'borrowed', 'reserved', 'damaged', 'lost', 'weeded'])->default('available');
            $table->date('acquisition_date')->nullable();
            $table->enum('acquisition_type', ['purchase', 'donation', 'grant'])->default('purchase');
            $table->decimal('price', 12, 2)->nullable();
            $table->string('source')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_copies');
    }
};
