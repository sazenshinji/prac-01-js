<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAfterCorrectionsTable extends Migration
{
    public function up()
    {
        Schema::create('aftercorrections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('correction_id')->constrained('corrections')->cascadeOnDelete();
            $table->date('after_work_date');
            $table->dateTime('after_clock_in');
            $table->dateTime('after_clock_out');
            $table->timestamps();

            // ★ 1対1制約
            $table->unique('correction_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('aftercorrections');
    }
}
