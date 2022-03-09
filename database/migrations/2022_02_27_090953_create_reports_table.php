<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('unit_id');

            $table->integer('total_work');
            $table->integer('total_id');
            $table->string('comment');
            $table->timestamps();


            $table->foreign('division_id')
                ->references('id')->on('divisions')
                ->onDelete('cascade');
            $table->foreign('district_id')
                ->references('id')->on('districts')
                ->onDelete('cascade');
            $table->foreign('unit_id')
                ->references('id')->on('units')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
