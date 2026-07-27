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
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('purchase_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('guest_id')->nullable()->after('user_id')->constrained('guests')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['guest_id']);
            $table->dropColumn('guest_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('user_id')->after('purchase_id')->constrained('users')->restrictOnDelete();
        });
    }
};
