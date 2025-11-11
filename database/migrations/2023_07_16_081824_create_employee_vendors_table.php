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
        Schema::create('employee_vendors', function (Blueprint $table) {
            $table->id();
            //employe store owner tabel code laravel?
            $table->string('name')->require();
            $table->string('phone')->nullable();
            $table->string('address');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image');
            $table->unsignedBigInteger('store_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_vendors');
    }
};
