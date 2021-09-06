<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_choices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->text('text');
            $table->unsignedInteger('question_id');
            $table->tinyInteger('is_answer');
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answer_choices');
    }
}
