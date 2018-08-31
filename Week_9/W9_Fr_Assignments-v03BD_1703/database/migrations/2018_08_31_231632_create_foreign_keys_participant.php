<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeysParticipant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants', function (Blueprint $table) {
            
            $table->index('profile_id');
            $table->foreign('profile_id')
                ->references('user_id')
                ->on('profiles')
                ->onDelete('cascade');
            
            $table->index('channel_id');
            $table->foreign('channel_id')
                ->references('id')
                ->on('channels')
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
        Schema::table('participants', function (Blueprint $table) {

            $table->dropForeign('participants_profile_id_foreign');
            $table->dropForeign('participants_channel_id_foreign');
            $table->dropIndex('participants_profile_id_index');
            $table->dropIndex('participants_channel_id_index');
            
        });
    }
}
