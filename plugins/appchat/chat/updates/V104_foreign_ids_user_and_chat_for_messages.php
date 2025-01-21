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
        Schema::table('appchat_chat_messages', function (Blueprint $table) {
            $table
                ->foreignIdFor(ChatRoom::class)
                ->nullable()
                ->constrained("appchat_chat_chat_rooms")
                ->cascadeOnDelete();
            $table
                ->foreignIdFor(User::class)
                ->nullable()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        if (Schema::hasTable("appchat_chat_messages")) {
            Schema::table('appchat_chat_messages', function (Blueprint $table) {
                $table
                    ->dropConstrainedForeignIdFor(ChatRoom::class);
                $table
                    ->dropConstrainedForeignIdFor(User::class);
            });
        }
    }
};
