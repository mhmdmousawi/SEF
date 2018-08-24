<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeysLikes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('likes', function (Blueprint $table) {
        
            //post
            $table->index('post_id');
            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->onDelete('cascade');  
                
            //user_liking
            $table->index('user_liking_id');
            $table->foreign('user_liking_id')
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
        Schema::table('likes', function (Blueprint $table) {
            
            //post
            $table->dropForeign('likes_post_id_foreign');
            $table->dropIndex('likes_post_id_index');

            //user_liking
            $table->dropForeign('likes_user_liking_id_foreign');
            $table->dropIndex('likes_user_liking_id_index');
        });
    }
}
