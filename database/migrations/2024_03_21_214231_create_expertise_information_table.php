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
        Schema::create('expertise_information', function (Blueprint $table) {
            $table->id();
            $table->string('user_token');
             $table->integer('year_of_experience');
            $table->integer('number_of_clients');
            $table->integer('number_of_projects');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expertise_information');
    }
};
