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
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_name', 255);
            $table->text('project_description')->nullable();
            $table->integer('is_active')->length(11);
            $table->string('created_by', 100);
            $table->dateTime('created_time');
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('updated_time')->nullable();
            $table->string('deleted_by', 100)->nullable();
            $table->dateTime('deleted_time')->nullable();

            // Foreign keys
            $table->foreign('id')->references('project_id')->on('jadwal');
            $table->foreign('id')->references('project_id')->on('participant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
