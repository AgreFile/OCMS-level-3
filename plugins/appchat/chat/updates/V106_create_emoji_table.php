<?php namespace AppChat\Chat\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appchat_chat_emoji', function(Blueprint $table) {
            $table->id();
            $table->string("char");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appchat_chat_emoji');
    }
};
