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
        Schema::create('departments', function (Blueprint $table) {
            $table->id('d_id');
            $table->string('d_code');
            $table->string('d_description');
            $table->string('d_email')->default(null);
            $table->integer('d_createdby')->default(1);
            $table->integer('d_updatedby')->default(1);
            $table->integer('d_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
