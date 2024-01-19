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
            $table->integer('t_todepartment');
            $table->integer('t_createdby')->references('u_id')->on('users')->default(1);
            $table->integer('t_assignedby')->references('u_id')->on('users')->nullable();
            $table->integer('t_assignedto')->references('u_id')->on('users')->nullable();
            $table->timestamp('t_assigneddate')->nullable();
            $table->integer('t_openedby')->references('u_id')->on('users')->nullable();
            $table->timestamp('t_dateopened')->nullable();
            $table->integer('t_acknowledgedby')->references('u_id')->on('users')->nullable();
            $table->timestamp('t_acknowledgeddate')->nullable();
            $table->string('t_resolution')->nullable();
            $table->integer('t_resolvedby')->references('u_id')->on('users')->nullable();
            $table->timestamp('t_resolveddate')->nullable();
            $table->integer('t_closedby')->references('u_id')->on('users')->nullable();
            $table->timestamp('t_closeddate')->nullable();
            $table->integer('t_updatedby')->references('u_id')->on('users')->nullable();
            $table->string('t_cancelreason')->nullable();
            $table->string('t_cancelledby')->nullable();
            $table->timestamp('t_cancelleddate')->nullable();
            $table->integer('t_severity')->default(0);
            $table->integer('t_status')->default(1);
            $table->timestamps();
        });
    }

    //CLosed and resolved
    //avg tat from creation to resolution
    //tat within 3days
    //email upon creation of ticket
    //include avg handling time


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
