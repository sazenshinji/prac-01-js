<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('requestdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('requests')->cascadeOnDelete();
            $table->tinyInteger('field_id'); // 0:clock_in / 1:clock_out / 2:break_start / 3:break_end
            $table->dateTime('before_value')->nullable();
            $table->dateTime('after_value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('request_details');
    }
}
