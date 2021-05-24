<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports_categories', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('stat_id')->references('id')->on('stats');
            $table->foreignId('report_id')->references('id')->on('reports')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->references('id')->on('categories');
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
        Schema::dropIfExists('reports_categories');
    }
}
