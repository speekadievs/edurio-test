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
        Schema::create('survey_options', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('survey_question_id')->unsigned();
            $table->foreign('survey_question_id')
                ->references('id')
                ->on('survey_questions')
                ->onDelete('CASCADE');

            $table->string('label');
            $table->string('value');

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
        Schema::dropIfExists('survey_options');
    }
};
