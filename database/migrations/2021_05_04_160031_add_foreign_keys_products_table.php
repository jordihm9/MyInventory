<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('condition_id')->references('id')->on('conditions')->nullable()->onUpdate('cascade');
            $table->foreignId('state_id')->references('id')->on('states')->onUpdate('cascade');
            $table->foreignId('category_id')->references('id')->on('categories')->nullable()->onUpdate('cascade');
            $table->foreignId('subcategory_id')->references('id')->on('subcategories')->nullable()->onUpdate('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('condition_id');
            $table->dropForeign('state_id');
            $table->dropForeign('category_id');
            $table->dropForeign('subcategory_id');
            $table->dropForeign('user_id');
        });
    }
}
