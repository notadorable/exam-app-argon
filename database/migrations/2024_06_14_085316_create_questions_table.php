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
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subtest_id');
            $table->integer('is_grup');
            $table->longText('question_name');
            $table->longText('question_detail');
            $table->integer('is_active');
            $table->string('created_by');
            $table->dateTime('created_time');
            $table->string('updated_by')->nullable();
            $table->dateTime('updated_time')->nullable();
            $table->string('deleted_by')->nullable();
            $table->dateTime('deleted_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
