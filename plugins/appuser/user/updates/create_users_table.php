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
        // REVIEW - Nepotrebuješ robiť check či existuje appuser_user_users, pretože táto migrácia zbehne ako prvá v plugina (podľa version.yaml), toto sa deje na viacerých miestach pozri si to
        // a teda appuser_user_users tam nemôže byť, resp. žiadna iná migrácia ktorá by ju mohla vytvoriť pred touto migráciou nezbehne
        // Pozri vysvetlenie migrácií v REVIEW.md a premýšlaj v kontexte: "Aké migrácie zbehli pred touto a po tejto migrácii"
        if (!Schema::hasTable("appuser_user_users")) {
            Schema::create('appuser_user_users', function(Blueprint $table) {
                $table->id();
                $table->string("username");
                $table->string("password");
                $table->string("token")->nullable();
                $table->timestamps();
            });
        }

        // REVIEW - Tento block patrí skôr do appchat pluginu a každopádne nemal by si vytvárať 2 tabulky cez jednu migráciu, taktiež máš tento istý kód aj v create_chat_rooms_table.php
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
        Schema::dropIfExists('user_chat_room'); // REVIEW - To isté čo vyššie
        Schema::dropIfExists('appuser_user_users');
    }
};
