<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeforeCorrectionsTable extends Migration
{
    public function up()
    {
        Schema::create('beforecorrections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('correction_id')->constrained('corrections')->cascadeOnDelete();
            $table->date('before_work_date')->nullable();
            $table->dateTime('before_clock_in')->nullable();
            $table->dateTime('before_clock_out')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('beforecorrections');
    }
}
