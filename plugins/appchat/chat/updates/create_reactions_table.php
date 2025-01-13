<?php namespace AppChat\Chat\Updates;

use AppChat\Chat\Models\Emoji;
use AppUser\User\Models\User;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateReactionsTable Migration
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
        Schema::create('appchat_chat_reactions', function(Blueprint $table) {
            $table->id();
            $table->
                foreignIdFor(User::class)
                ->nullable()
                ->constrained("appuser_user_users")
                ->cascadeOnDelete();

            $table->foreignIdFor(Emoji::class)
                ->nullable()
                ->constrained("appchat_chat_emoji")
                ->cascadeOnDelete();
                
            $table->timestamps();
        });

        // REVIEW - Na toto by mala existovať samostatná migrácia
        Schema::create('reaction_message', function(Blueprint $table){
            $table->integer("reaction_id")->unsigned();
            $table->integer("message_id")->unsigned();
            $table->primary(["reaction_id", "message_id"]);
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('appchat_chat_reactions');
        Schema::dropIfExists('reaction_message');
    }
};
