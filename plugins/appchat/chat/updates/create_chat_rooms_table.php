<?php
namespace AppChat\Chat\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateChatRoomsTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration {
    /**
     * up builds the migration
     */
    public function up()
    {
        if (!Schema::hasTable('appchat_chat_chat_rooms')) {
            Schema::create('appchat_chat_chat_rooms', function (Blueprint $table) {
                $table->id();
                $table->string("room_name")->default("Chatroom");
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('user_chat_room')) {
            Schema::create('user_chat_room',function(Blueprint $table) {
                $table->integer("user_id")->unsigned();
                $table->integer("chat_room_id")->unsigned();
                $table->primary(['user_id', 'chat_room_id']);
            });
        }
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        if (Schema::hasTable('appchat_chat_messages')) {
            Schema::table("appchat_chat_messages", function($table){
                $table->dropForeign('appchat_chat_messages_chat_room_id_foreign');
            });
        }

        Schema::dropIfExists('user_chat_room');
        Schema::dropIfExists('appchat_chat_chat_rooms');
    }
};
