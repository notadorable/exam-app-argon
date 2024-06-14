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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->increments('jadwal_id');
            $table->integer('project_id')->length(11);
            $table->bigInteger('participant_id')->length(20);
            $table->string('nik', 100);
            $table->string('name', 255);
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('status_test')->length(11);
            $table->dateTime('access_time')->nullable();
            $table->integer('is_active')->length(11);
            $table->integer('is_packted')->length(11);
            $table->dateTime('packted_time')->nullable();
            $table->string('created_by', 100);
            $table->dateTime('created_time');
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('updated_time')->nullable();
            $table->string('deleted_by', 100)->nullable();
            $table->dateTime('deleted_time')->nullable();
            $table->dateTime('finish_time')->nullable();
            $table->string('finish_type', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
