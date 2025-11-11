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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->string('slug')->unique();
            $table->string('image')->require();
            $table->text('description')->nullable();
            $table->enum('status',['active','archived'],)->default('active');
            $table->string('email')->require();
            $table->string('password')->require();
            $table->string('phone')->nullable(); 
            // $table->foreignId('vendor_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
