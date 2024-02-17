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
        Schema::table('severities', function (Blueprint $table) {
            // $table->id('s_id');
            // $table->string('s_title');
            // $table->string('s_description');
            $table->integer('s_responsetime')->nullable()->change();
            $table->integer('s_resolutiontime')->nullable()->change();
            $table->integer('s_escalationtime')->nullable()->change();
            // $table->integer('s_createdby')->default(1);
            // $table->integer('s_updatedby')->default(1);
            // $table->integer('s_status')->default(1);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('severities', function (Blueprint $table){
            $table->dropColumn('s_responsetime');
            $table->dropColumn('s_resolutiontime');
            $table->dropColumn('s_escalationtime');
        });
    }
};
