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
            $table->timestamp("start_rest")->nullable();
            $table->timestamp("end_rest")->nullable();
            $table->timestamp("total_rest")->nullable();
            $table->timestamp("created_at")->useCurrent()->nullable();
            $table->timestamp("update_at")->useCurrent()->nullable();
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
