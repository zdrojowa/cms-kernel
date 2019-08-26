<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\Core;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Config::get(Core::USERS_TABLE), function(Blueprint $table) {
            $table->boolean(Config::get(Core::ADMIN_COLUMN))->default(0);
            $table->integer(Config::get(Core::USERS_TABLE))->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Config::get(Core::USERS_TABLE), function(Blueprint $table) {
            $table->dropColumn(Config::get(Core::ADMIN_COLUMN));
            $table->dropColumn(Config::get(Core::USERS_TABLE));
        });
    }
}
