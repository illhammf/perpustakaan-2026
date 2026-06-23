<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->nullable()->constrained()->nullOnDelete();
            $table->string('supplier_name');
            $table->string('supplier_contact')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2)->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->date('procurement_date');
            $table->string('invoice_number')->nullable();
            $table->enum('status', ['ordered', 'received', 'cancelled'])->default('ordered');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procurements');
    }
};
