<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('max_loans')->default(5);
            $table->integer('loan_duration_days')->default(14);
            $table->decimal('fine_per_day', 10, 2)->default(1000);
            $table->integer('renewal_limit')->default(1);
            $table->boolean('can_reserve')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_types');
    }
};
