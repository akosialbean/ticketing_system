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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('t_id');
            $table->string('t_title');
            $table->string('t_description');
            $table->string('t_category');
            $table->string('t_todepartment')->references('d_id')->on('departments')->default(0);
            $table->integer('t_createdby')->references('u_id')->on('users')->default(1);
            $table->integer('t_assignedby')->references('u_id')->on('users')->default(1);
            $table->integer('t_assignedto')->references('u_id')->on('users')->default(1);
            $table->integer('t_openedby')->references('u_id')->on('users')->default(1);
            $table->integer('t_acknowledgedby')->references('u_id')->on('users')->default(1);
            $table->integer('t_resolvedby')->references('u_id')->on('users')->default(1);
            $table->integer('t_closedby')->references('u_id')->on('users')->default(1);
            $table->integer('t_updatedby')->references('u_id')->on('users')->default(1);
            $table->string('t_resolution')->references('d_id')->on('departments');
            $table->string('t_cancellation')->references('d_id')->on('departments');
            $table->integer('t_severity')->default(1);
            $table->integer('c_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
