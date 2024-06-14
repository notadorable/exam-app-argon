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
        Schema::create('exam_maps', function (Blueprint $table) {
            $table->increments('map_id');
            $table->integer('project_id')->length(11);
            $table->integer('disclaimer_id')->length(11);
            $table->integer('disclaimerfinish_id')->length(11);
            $table->integer('agreement_id')->length(11);
            $table->integer('durasi')->length(11);
            $table->integer('is_active')->length(11);
            $table->string('created_by', 100);
            $table->dateTime('created_time');
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('updated_time')->nullable();
            $table->string('deleted_by', 100)->nullable();
            $table->dateTime('deleted_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_maps');
    }
};
