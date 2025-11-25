<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained('users')->onDelete('cascade');
            $table->string('product_name');
            $table->string('company')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->integer('estimated_quantity')->nullable();
            $table->string('urgency')->default('normal'); // normal, urgent, very_urgent
            $table->string('preferred_distributor')->nullable();
            $table->decimal('expected_price', 10, 2)->nullable();
            $table->string('reference_link')->nullable();
            $table->string('status')->default('pending'); // pending, reviewing, approved, rejected, fulfilled
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_requests');
    }
};