<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('clinic_id')->constrained('users')->onDelete('cascade');
            $table->decimal('custom_price', 10, 2);
            $table->timestamps();
            
            // Ensure one custom price per product-clinic combination
            $table->unique(['product_id', 'clinic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_pricing');
    }
};