<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateItemValueReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_value_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('report_id');
            $table->foreign('report_id')->references('id')->on('reports');
            $table->integer('item_rol_id');
            $table->foreign('item_rol_id')->references('id')->on('item_rols');
            $table->integer('value');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_value_reports');
    }
}
