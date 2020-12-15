<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey__details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id')->nullable(true);
            $table->unsignedBigInteger('task_id')->nullable(true);
            $table->string('answer');
            $table->decimal('score');
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
        Schema::dropIfExists('survey__details');
    }
}
