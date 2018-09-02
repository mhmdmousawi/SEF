<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeysChatDms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_dms', function (Blueprint $table) {
            
            $table->index('sender_id');
            $table->foreign('sender_id')
                ->references('profile_id')
                ->on('profiles')
                ->onDelete('cascade');

            $table->index('reciever_id');
            $table->foreign('reciever_id')
                ->references('profile_id')
                ->on('profiles')
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
        Schema::table('chat_dms', function (Blueprint $table) {

            $table->dropForeign('chat_dms_sender_id_foreign');
            $table->dropIndex('chat_dms_sender_id_index');
            $table->dropForeign('chat_dms_reciever_id_foreign');
            $table->dropIndex('chat_dms_reciever_id_index');
            
        });
    }
}
