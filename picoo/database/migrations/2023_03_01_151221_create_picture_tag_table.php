<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePictureTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picture_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('picture_id');
            $table->unsignedBigInteger('tag_id');

            $table->primary(['picture_id', 'tag_id']);

            $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('picture_tag');
    }
}
