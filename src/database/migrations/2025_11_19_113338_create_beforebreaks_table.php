<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeforeBreaksTable extends Migration
{
    public function up()
    {
        Schema::create('beforebreaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beforecorrection_id')->constrained('beforecorrections')->cascadeOnDelete();
            $table->tinyInteger('break_index');
            $table->dateTime('before_break_start');
            $table->dateTime('before_break_end')->nullable();
            $table->timestamps();

            $table->unique(['beforecorrection_id', 'break_index']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('beforebreaks');
    }
}
