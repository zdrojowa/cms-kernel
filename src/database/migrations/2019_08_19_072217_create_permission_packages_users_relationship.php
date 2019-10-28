<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\Core;

class CreatePermissionPackagesUsersRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Config::get(Core::USERS_TABLE), function(Blueprint $table) {
            $table->foreign(Config::get(Core::USERS_TABLE_COLUMN))->references('id')->on(Config::get(Core::PERMISSIONS_TABLE))->onDelete('set null');
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
            $table->dropForeign(Config::get(Core::PERMISSIONS_FOREIGN_KEY));
        });
    }
}
