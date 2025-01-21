<?php
namespace AppUser\User\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('appuser_user_users', function (Blueprint $table) {
            $table->id();
            $table->string("username");
            $table->string("password");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appuser_user_users');
    }
};
