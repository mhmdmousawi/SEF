<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeysTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
        
            //post
            $table->index('post_id');
            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->onDelete('cascade');  
                
            //user_tagged
            $table->index('user_tagged_id');
            $table->foreign('user_tagged_id')
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
        Schema::table('tags', function (Blueprint $table) {
            
            //post
            $table->dropForeign('tags_post_id_foreign');
            $table->dropIndex('tags_post_id_index');

            //user_tagged
            $table->dropForeign('tags_user_tagged_id_foreign');
            $table->dropIndex('tags_user_tagged_id_index');
        });
    }
}
