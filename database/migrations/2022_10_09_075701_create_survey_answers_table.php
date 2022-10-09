<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->bigInteger('survey_question_id')->unsigned();
            $table->foreign('survey_question_id')
                ->references('id')
                ->on('survey_questions')
                ->onDelete('CASCADE');

            $table->bigInteger('survey_option_id')->unsigned()->nullable();
            $table->foreign('survey_option_id')
                ->references('id')
                ->on('survey_options')
                ->onDelete('CASCADE');

            $table->string('value')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_answers');
    }
};
