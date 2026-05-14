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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('envelope_id')->nullable()->constrained();
            $table->decimal('amount', 10, 2);
            $table->enum('type',['income', 'expense']);
            $table->string('description');
            $table->date('date');
            $table->json('tags')->nullable();
            $table->string('receipt_path')->nullable(); // para fotos de tickets
            $table->boolean('is_recurring')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
