<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('price')->nullable();
            $table->text('description');
            $table->integer('user_id');
            $table->integer('discount');
            $table->string('username')->nullable();
            $table->string('phone',13)->nullable();
            $table->string('email',70)->nullable();
            $table->text('images')->nullable();
            $table->string('category_name')->nullable();
            $table->string('sub_category_nmae')->nullable();
            $table->string('brand')->nullable();
            $table->string('location_name')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
