<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOrderTableTelephoneColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('billing_telephone', 'billing_phone')->change();
            $table->renameColumn('shipping_telephone', 'shipping_phone')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('billing_phone', 'billing_telephone')->change();
            $table->renameColumn('shipping_phone', 'shipping_telephone')->change();
        });
    }
}
