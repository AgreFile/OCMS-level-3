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
        Schema::create('reaction_message', function(Blueprint $table){
            $table->integer("reaction_id")->unsigned();
            $table->integer("message_id")->unsigned();
            $table->primary(["reaction_id", "message_id"]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reaction_message');
    }
};
