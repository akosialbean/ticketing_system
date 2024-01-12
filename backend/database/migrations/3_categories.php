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
            $table->id('c_id');
            $table->string('c_code');
            $table->string('c_description');
            $table->integer('c_createdby')->references('u_id')->on('users')->default(1);
            $table->integer('c_updatedby')->references('u_id')->on('users')->default(1);
            $table->integer('c_status')->default(1);
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

