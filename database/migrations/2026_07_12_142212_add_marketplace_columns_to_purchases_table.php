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
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('payment_gateway_id');
            $table->dropColumn('payment_status');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('platform_fee_rate', 5, 2);
            $table->decimal('platform_fee_amount', 10, 2);
            $table->enum('status', [
                'pending',
                'confirmed',
                'cancelled',
                'expired'
            ])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('payment_status');
            $table->string('payment_gateway_id')->nullable();
            $table->dropColumn('subtotal');
            $table->dropColumn('platform_fee_rate');
            $table->dropColumn('platform_fee_amount');
            $table->dropColumn('status');
        });
    }
};
