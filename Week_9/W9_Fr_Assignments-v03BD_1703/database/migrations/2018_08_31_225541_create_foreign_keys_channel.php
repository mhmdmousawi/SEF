<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeysChannel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channels', function (Blueprint $table) {
            
            $table->index('creator_id');
            $table->foreign('creator_id')
                ->references('profile_id')
                ->on('profiles')
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
        Schema::table('channels', function (Blueprint $table) {

            $table->dropForeign('channels_creator_id_foreign');
            $table->dropForeign('channels_profile_picture_id_foreign');
            $table->dropIndex('channels_creator_id_index');
            $table->dropIndex('channels_profile_picture_id_index');
            
        });
    }
}
