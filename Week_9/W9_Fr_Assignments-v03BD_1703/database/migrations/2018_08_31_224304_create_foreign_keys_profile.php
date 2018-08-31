<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeysProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            
            $table->index('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            $table->index('profile_picture_id');
            $table->foreign('profile_picture_id')
                ->references('id')
                ->on('pictures')
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
        Schema::table('profiles', function (Blueprint $table) {

            $table->dropForeign('profiles_user_id_foreign');
            $table->dropForeign('profiles_profile_picture_id_foreign');
            $table->dropIndex('profiles_user_id_index');
            $table->dropIndex('profiles_profile_picture_id_index');
        });
    }
}
