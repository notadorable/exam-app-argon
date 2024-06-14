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
        Schema::create('tr_answers', function (Blueprint $table) {
            $table->bigIncrements('transwer_id');
            $table->integer('project_id')->length(11);
            $table->bigInteger('participant_id')->length(20);
            $table->integer('question_id')->length(11);
            $table->integer('choice_id')->length(11);
            $table->enum('choice_type', ['A', 'B', 'C', 'D', 'E']); // Adjust enum values as needed
            $table->string('created_by', 100);
            $table->dateTime('created_time');
            
            // Foreign keys (optional)
            $table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade');
            $table->foreign('participant_id')->references('participant_id')->on('participants')->onDelete('cascade');
            $table->foreign('question_id')->references('question_id')->on('questions')->onDelete('cascade');
            $table->foreign('choice_id')->references('choice_id')->on('question_choices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_answers');
    }
};
