<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreaktimesTable extends Migration
{
    public function up()
    {
        Schema::create('breaktimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')->constrained('attendances')->cascadeOnDelete();
            $table->tinyInteger('break_index');
            $table->dateTime('break_start');
            $table->dateTime('break_end')->nullable();
            $table->timestamps();

            $table->unique(['attendance_id', 'break_index']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('breaktimes');
    }
}
