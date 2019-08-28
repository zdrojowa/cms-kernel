<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\Core;

class CreatePermissionsPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Config::get(Core::PERMISSIONS_TABLE), function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->text('anchors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Config::get(Core::PERMISSIONS_TABLE));
    }
}
