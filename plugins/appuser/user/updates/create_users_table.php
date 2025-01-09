<?php namespace AppUser\User\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateUsersTable Migration
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
        if (!Schema::hasTable("appuser_user_users")) {
            Schema::create('appuser_user_users', function(Blueprint $table) {
                $table->id();
                $table->string("username");
                $table->string("password");
                $table->string("token")->nullable();
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
        Schema::dropIfExists('user_chat_room');
        Schema::dropIfExists('appuser_user_users');
    }
};
