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
        Schema::create('users', function (Blueprint $table) {
            $table->id('u_id');
            $table->string('u_fname');
            $table->string('u_lname');
            $table->string('u_mname')->default('N/A');
            $table->integer('u_department')->references('d_id')->on('departments');
            $table->integer('u_role');
            $table->string('u_email')->unique()->default('no email');
            $table->string('u_username');
            $table->string('password');
            $table->integer('u_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
