<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCommentMapperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_comment_mapper', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("blog_id")->unsigned()->nullable();
            $table->foreign('blog_id')->references("id")->on("blog")->onDelete('cascade');

            $table->text("comment")->nullable();
            $table->unsignedBigInteger('created_by')->comment('created by user id')->nullable();
            $table->unsignedBigInteger('updated_by')->comment('updated by user id')->nullable();
            $table->unsignedBigInteger('deleted_by')->comment('deleted by user id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('blog_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_comment_mapper');
    }
}
