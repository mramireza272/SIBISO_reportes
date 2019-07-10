<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateRolStructureItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rol_structure_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_rol_id');
            $table->foreign('item_rol_id')->references('id')->on('item_rols');
            $table->string('columns');
            $table->integer('order');
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
        Schema::dropIfExists('rol_structure_items');
    }
}
