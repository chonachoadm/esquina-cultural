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
        Schema::create('plays', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('theater_id')->nullable()->constrained('theaters')->onDelete('set null');
            $table->decimal('ticket_price', 10, 2); 
            $table->string('cover_photo')->nullable(); 
            $table->integer('duration'); 
            $table->boolean('is_published'); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plays');
    }
};
