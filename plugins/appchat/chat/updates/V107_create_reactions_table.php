<?php namespace AppChat\Chat\Updates;

use AppChat\Chat\Models\Emoji;
use AppUser\User\Models\User;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appchat_chat_reactions', function(Blueprint $table) {
            $table->id();
            $table->
                foreignIdFor(User::class)
                ->nullable()
                ->cascadeOnDelete();

            $table->foreignIdFor(Emoji::class)
                ->nullable()
                ->constrained("appchat_chat_emoji")
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('appchat_chat_reactions');
    }
};
