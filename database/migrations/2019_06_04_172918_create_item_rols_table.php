<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateItemRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_rols', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rol_id');
            $table->foreign('rol_id')->references('id')->on('roles');
            $table->text('item');
            $table->integer('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('item_rols');
            $table->boolean('editable');
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
        Schema::dropIfExists('item_rols');
    }
}
