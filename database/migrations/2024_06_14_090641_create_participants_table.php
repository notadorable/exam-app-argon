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
        Schema::create('participants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->length(11);
            $table->integer('map_id')->length(11);
            $table->integer('subtest_id')->length(11);
            $table->string('nik', 100);
            $table->string('name', 255);
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
        Schema::dropIfExists('participants');
    }
};
