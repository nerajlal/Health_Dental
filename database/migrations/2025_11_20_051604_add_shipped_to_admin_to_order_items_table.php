<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->boolean('shipped_to_admin')->default(false)->after('price');
            $table->timestamp('shipped_at')->nullable()->after('shipped_to_admin');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['shipped_to_admin', 'shipped_at']);
        });
    }
};