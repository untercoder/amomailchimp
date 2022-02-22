<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'Contacts';
    protected $fillable = [
        'owner',
        'contact_id',
        'name',
        'email',
    ];
}