<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateVariableFormulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variable_formulas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('formula_id');
            $table->foreign('formula_id')->references('id')->on('formula_results');

            $table->integer('itemrol_id');
            $table->foreign('itemrol_id')->references('id')->on('item_rols');

            $table->integer('itemstructure_id');
            $table->foreign('itemstructure_id')->references('id')->on('rol_structure_items');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variable_formulas');
    }
}
