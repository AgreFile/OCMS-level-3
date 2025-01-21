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
        
        Schema::create('user_chat_room', function (Blueprint $table) {
            $table->integer("user_id")->unsigned();
            $table->integer("chat_room_id")->unsigned();
            $table->primary(['user_id', 'chat_room_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_chat_room');
    }
};
