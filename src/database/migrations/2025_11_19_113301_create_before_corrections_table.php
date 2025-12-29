<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeforeCorrectionsTable extends Migration
{
    public function up()
    {
        Schema::create('before_corrections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('correction_id')->constrained('corrections')->cascadeOnDelete();
            $table->date('before_work_date')->nullable();
            $table->dateTime('before_clock_in')->nullable();
            $table->dateTime('before_clock_out')->nullable();
            $table->timestamps();

            // ★ 1対1制約
            $table->unique('correction_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('before_corrections');
    }
}
