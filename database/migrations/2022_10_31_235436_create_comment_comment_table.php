<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_comment', function (Blueprint $table) {
            $table->integer('main_comment_id')->unsigned();
            $table->integer('reply_comment_id')->unsigned();

            $table->foreign('reply_comment_id')
                ->references('id')->on('comments')
                ->onDelete('cascade');
            $table->foreign('main_comment_id')->references('id')->on('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_comment');
    }
}
