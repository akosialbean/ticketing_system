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
            $table->id('id');
            $table->string('u_fname');
            $table->string('u_lname');
            $table->string('u_mname')->nullable();
            $table->integer('u_department')->references('d_id')->on('departments');
            $table->integer('u_role');
            $table->string('u_email')->nullable();
            $table->string('u_username')->unique();
            $table->string('password');
            $table->integer('u_status');
            $table->integer('u_firstlogin')->default(1);
            $table->string('remember_token')->nullable();
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
