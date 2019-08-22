<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Zdrojowa\CmsKernel\Utils\Config\ConfigUtils;
use Zdrojowa\CmsKernel\Utils\Enums\CoreEnum;

class CreatePermissionPackagesUsersRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(ConfigUtils::coreConfig(CoreEnum::CMS_MIGRATIONS_USERS_TABLE_OPTION), function(Blueprint $table) {
           $table->foreign(ConfigUtils::coreConfig(CoreEnum::CMS_MIGRATIONS_USERS_TABLE_COLUMN_NAME))->references('id')->on(ConfigUtils::coreConfig(CoreEnum::CMS_MIGRATIONS_PERMISSIONS_TABLE_OPTION))->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(ConfigUtils::coreConfig(CoreEnum::CMS_MIGRATIONS_USERS_TABLE_OPTION), function(Blueprint $table) {
           $table->dropForeign(ConfigUtils::coreConfig(CoreEnum::CMS_MIGRATIONS_PERMISSIONS_USERS_FOREIGN_KEY));
        });
    }
}
