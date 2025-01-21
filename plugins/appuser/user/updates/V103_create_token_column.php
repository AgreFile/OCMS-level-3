<?php
namespace AppUser\User\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('appuser_user_users', function (Blueprint $table) {
            $table->string("token")->nullable();
        });
    }

    public function down()
    {
        Schema::table('appuser_user_users', function (Blueprint $table) {
            $table->dropColumn("token");
        });
    }
};
