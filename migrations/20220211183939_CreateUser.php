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
            $table->id();
            $table->string('auth_user_id', 1000)->unique();
            $table->string('access_token', 1000)->unique();
            $table->string('refresh_token', 1000)->unique();
            $table->string("base_domain", 1000);
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
