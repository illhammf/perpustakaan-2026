<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->nullable()->constrained()->nullOnDelete();
            $table->string('donor_name');
            $table->string('donor_contact')->nullable();
            $table->string('donor_email')->nullable();
            $table->enum('donation_type', ['book', 'cash', 'supply'])->default('book');
            $table->string('title')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('amount', 12, 2)->nullable();
            $table->text('description')->nullable();
            $table->date('donation_date');
            $table->text('thanks_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
