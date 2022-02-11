<?php

use Phpmig\Migration\Migration;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;


class CreateUser extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        Manager::schema()->create('User', function (Blueprint $table) {
            $table->integer('account_id');
            $table->text('access_token');
            $table->text('refresh_token');
            $table->integer('expires');
            $table->timestamps();
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        Manager::schema()->dropIfExists('User');
    }
}
