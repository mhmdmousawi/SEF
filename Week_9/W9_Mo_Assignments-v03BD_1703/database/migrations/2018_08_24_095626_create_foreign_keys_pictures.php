<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeysPictures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pictures', function (Blueprint $table) {
        
            $table->index('user_id');
            $table->foreign('user_id')
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
        Schema::table('pictures', function (Blueprint $table) {
            
            $table->dropForeign('pictures_user_id_foreign');
            $table->dropIndex('pictures_user_id_index');
        });
    }
}
