<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['clinic', 'distributor']);
            
            // Personal Information
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            
            // Business Information
            $table->string('business_name');
            $table->string('business_address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('country')->default('USA');
            
            // Additional Information
            $table->string('license_number')->nullable();
            $table->text('description')->nullable();
            $table->integer('years_in_business')->nullable();
            $table->string('website')->nullable();
            
            // Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_requests');
    }
};