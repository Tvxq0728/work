<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rests', function (Blueprint $table) {
            $table->id();
            $table->integer("stamp_id");
            $table->date("date")->nullable();
            $table->datetime("start_at")->nullable();
            $table->datetime("end_at")->nullable();
            $table->datetime("total_at")->nullable();
            $table->timestamp("created_at")->useCurrent()->nullable();
            $table->timestamp("updated_at")->useCurrent()->nullable();
        });
    }
//     id
// stamp_id
// strat_break
// end_break
// total_break
// created_at
// updated_at


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rests');
    }
}
