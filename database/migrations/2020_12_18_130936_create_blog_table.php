<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->id();

            $table->string("title")->nullable();
            $table->text("description")->nullable();
            $table->binary("image")->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('created_by')->comment('created by user id')->nullable();
            $table->unsignedBigInteger('updated_by')->comment('updated by user id')->nullable();
            $table->unsignedBigInteger('deleted_by')->comment('deleted by user id')->nullable();

            $table->index("title");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog');
    }
}
