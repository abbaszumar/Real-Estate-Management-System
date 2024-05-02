<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Add the user_id column
            $table->foreign('user_id')->references('id')->on('users'); // Add a foreign key constraint to link user_id to the users table
            $table->string('city');
            $table->string('type')->nullable();
            $table->string('purpose')->nullable();
            $table->integer('bedroom')->nullable();
            $table->integer('bathroom')->nullable();
            $table->decimal('minprice', 10, 2)->nullable();
            $table->decimal('maxprice', 10, 2)->nullable();
            $table->decimal('minarea', 10, 2)->nullable();
            $table->decimal('maxarea', 10, 2)->nullable();
            $table->boolean('featured')->default(false)->nullable();
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
        Schema::dropIfExists('search_histories');
    }
}
