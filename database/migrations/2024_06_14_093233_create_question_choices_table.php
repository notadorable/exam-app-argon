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
        Schema::create('question_choices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->length(11);
            $table->enum('choice_type', ['A', 'B', 'C', 'D', 'E']); // Modify as per your choice types
            $table->text('choice_name');
            $table->enum('choice_answer', ['Y', 'N']);
            $table->integer('is_active')->length(11);
            $table->integer('created_by')->length(11);
            $table->dateTime('created_time');
            $table->integer('updated_by')->length(11)->nullable();
            $table->dateTime('updated_time')->nullable();
            $table->integer('deleted_by')->length(11)->nullable();
            $table->dateTime('deleted_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_choices');
    }
};
