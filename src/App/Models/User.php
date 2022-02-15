<?php
declare(strict_types=1);

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'User';

    protected $fillable = [
        'access_token',
        'refresh_token',
        'expires',
        'base_domain',
    ];



}