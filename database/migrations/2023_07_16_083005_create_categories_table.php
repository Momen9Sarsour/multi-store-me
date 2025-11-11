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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories','id')
                  ->nullOnDelete();
            $table->foreignId('store_id');
            $table->string('name')->require(); // Name is required
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image');
            $table->enum('status',['active','archived'],)->default('active');
            // $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
