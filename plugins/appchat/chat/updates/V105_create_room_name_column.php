<?php
namespace AppChat\Chat\Updates;

use AppChat\Chat\Models\ChatRoom;
use AppUser\User\Models\User;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('appchat_chat_chat_rooms', function (Blueprint $table) {
            $table->string("room_name")->default("Chatroom");
        });
    }

    public function down()
    {
        Schema::table('appchat_chat_chat_rooms', function (Blueprint $table) {
            $table->dropColumn("room_name");
        });
    }
};
