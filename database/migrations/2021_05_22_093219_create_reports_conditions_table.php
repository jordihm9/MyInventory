<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports_conditions', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('stat_id')->references('id')->on('stats');
            $table->foreignId('report_id')->references('id')->on('reports')->onDelete('cascade');
            $table->foreignId('condition_id')->references('id')->on('conditions');
            $table->integer('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports_conditions');
    }
}
