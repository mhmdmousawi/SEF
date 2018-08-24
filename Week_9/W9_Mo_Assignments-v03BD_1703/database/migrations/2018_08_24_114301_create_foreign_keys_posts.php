<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeysPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            
            //user
            $table->index('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            //picture
            $table->index('picture_id');
            $table->foreign('picture_id')
                ->references('id')->on('pictures')
                ->onDelete('cascade');
            
            //location
            $table->index('location_id');
            $table->foreign('location_id')
                ->references('id')->on('locations')
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
        Schema::table('posts', function (Blueprint $table) {
            
            //user
            $table->dropForeign('posts_user_id_foreign');
            $table->dropIndex('posts_user_id_index');
            
            //picture
            $table->dropForeign('posts_picture_id_foreign');
            $table->dropIndex('posts_picture_id_index');
            
            //location
            $table->dropForeign('posts_location_id_foreign');
            $table->dropIndex('posts_location_id_index');
        });
    }
}
