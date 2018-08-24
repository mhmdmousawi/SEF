<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeysFollows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('follows', function (Blueprint $table) {
        
            //following user id
            $table->index('user_id_following');
            $table->foreign('user_id_following')
                ->references('id')->on('users')
                ->onDelete('cascade');
            
            //followed used id
            $table->index('user_id_followed');
            $table->foreign('user_id_followed')
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
        Schema::table('follows', function (Blueprint $table) {
            
            //following user id
            $table->dropForeign('follows_user_id_following_foreign');
            $table->dropIndex('follows_user_id_following_index');

            //followed used id
            $table->dropForeign('follows_user_id_followed_foreign');
            $table->dropIndex('follows_user_id_followed_index');
        });
    }
}
