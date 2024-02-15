<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // $table->id('comment_id');
            // $table->integer('comment_ticketid')->change();
            // $table->integer('comment_sender')->nullable()->change();
            $table->text('comment_message')->nullable()->change();
            // $table->integer('comment_createdby')->nullable()->change();
            // $table->integer('comment_updatedby')->nullable()->change();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       //
    }
};