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
        Schema::create('locals', function (Blueprint $table) {
            $table->id('l_id');
            $table->integer('l_user')->nullable()->references('id')->on('users');
            $table->integer('l_department')->nullable()->references('d_id')->on('departments');
            $table->integer('l_level')->nullable();
            $table->integer('l_number')->required();
            $table->integer('l_createdby')->nullable()->references('id')->on('users');
            $table->integer('l_updatedby')->nullable()->references('id')->on('users');
            $table->integer('l_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locals');
    }
};
