<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedbigInteger('category_id');
            $table->unsignedbigInteger('answer_id');
            $table->text('note')->nullable();
            $table->boolean('is_active')->nullable();
            $table->unsignedbigInteger('author_id');
            $table->timestamps();

            // $table->foreign('answer_id')->references('id')->on('question_options')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('question_categories')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}