<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamps', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("rest_id")->nullable();
            $table->date("date");
            $table->time("start_at");
            $table->time("end_at")->nullable();
            $table->time("work_at")->nullable();
            $table->timestamp("created_at")->useCurrent()->nullable();
            $table->timestamp("updated_at")->useCurrent()->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stamps');
    }
}
