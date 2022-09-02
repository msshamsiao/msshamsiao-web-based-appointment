<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('client_id');

            $table->integer('service_id');

            $table->integer('lawyer_id');

            $table->datetime('start_time');

            $table->datetime('finish_time');

            $table->longText('comments')->nullable();

            $table->string('status');

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
