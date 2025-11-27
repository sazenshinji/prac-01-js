<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAfterBreaksTable extends Migration
{
    public function up()
    {
        Schema::create('afterbreaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aftercorrection_id')->constrained('aftercorrections')->cascadeOnDelete();
            $table->tinyInteger('break_index');
            $table->dateTime('after_break_start');
            $table->dateTime('after_break_end');
            $table->timestamps();

            $table->unique(['aftercorrection_id', 'break_index']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('afterbreaks');
    }
}
