<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeysComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
        
            //post
            $table->index('post_id');
            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->onDelete('cascade');  
                
            //user_commenting_id
            $table->index('user_commenting_id');
            $table->foreign('user_commenting_id')
                ->references('id')->on('users')
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
        Schema::table('comments', function (Blueprint $table) {
            
            //post
            $table->dropForeign('comments_post_id_foreign');
            $table->dropIndex('comments_post_id_index');

            //user_liking
            $table->dropForeign('comments_user_commenting_id_foreign');
            $table->dropIndex('comments_user_commenting_id_index');
        });
    }
}
