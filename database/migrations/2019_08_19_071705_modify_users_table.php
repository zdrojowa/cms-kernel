<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Zdrojowa\InvestmentCMS\Utils\Config\ConfigUtils;
use Zdrojowa\InvestmentCMS\Utils\Enums\CoreEnum;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(ConfigUtils::coreConfig(CoreEnum::CMS_MIGRATIONS_USERS_TABLE_OPTION), function(Blueprint $table) {
            $table->boolean(ConfigUtils::coreConfig(CoreEnum::CMS_SUPER_ADMIN_COLUMN_NAME))->default(0);
            $table->integer(ConfigUtils::coreConfig(CoreEnum::CMS_MIGRATIONS_USERS_TABLE_COLUMN_NAME))->nullable()->unsigned();
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
            $table->dropColumn(ConfigUtils::coreConfig(CoreEnum::CMS_SUPER_ADMIN_COLUMN_NAME));
            $table->dropColumn(ConfigUtils::coreConfig(CoreEnum::CMS_MIGRATIONS_USERS_TABLE_COLUMN_NAME));
        });
    }
}
