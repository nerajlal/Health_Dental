<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributor_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->string('company')->nullable();
            $table->string('category')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->decimal('admin_margin', 10, 2)->default(0);
            $table->decimal('final_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('unit')->default('piece');
            $table->boolean('is_active')->default(false);
            $table->text('admin_notes')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};