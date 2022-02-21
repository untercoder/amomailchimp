<?php

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;
use Phpmig\Migration\Migration;

class CreateContact extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        Manager::schema()->create('Contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('owner');
            $table->integer('contact_id');
            $table->text('name');
            $table->text('email');
            $table->timestamps();
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        Manager::schema()->dropIfExists('Contacts');
    }
}
