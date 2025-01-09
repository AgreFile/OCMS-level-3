<?php namespace AppChat\Chat\Updates;

use AppChat\Chat\Models\ChatRoom;
use AppUser\User\Models\User;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateMessagesTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration
{
    /**
     * up builds the migration
     */
    public function up()
    {
        if (!Schema::hasTable('appchat_chat_messages')) {
            Schema::create('appchat_chat_messages', function(Blueprint $table) {
                $table->id();
                $table
                    ->foreignIdFor(ChatRoom::class)
                    ->nullable()
                    ->constrained("appchat_chat_chat_rooms")
                    ->cascadeOnDelete();
                $table
                    ->foreignIdFor(User::class)
                    ->nullable()
                    ->constrained("appuser_user_users")
                    ->nullOnDelete();
                $table->string("message");
                $table
                    ->foreignId("replying_to_message_id")
                    ->nullable()
                    ->constrained("appchat_chat_messages")
                    ->cascadeOnDelete();
                $table->timestamps();
            });
        }
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('appchat_chat_messages');
    }
};
