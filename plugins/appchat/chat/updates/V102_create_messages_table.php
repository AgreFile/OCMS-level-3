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
        Schema::create('appchat_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->string("message");
            $table
                ->foreignId("replying_to_message_id")
                ->nullable()
                ->constrained("appchat_chat_messages")
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appchat_chat_messages');
    }
};
