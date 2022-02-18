<?php
declare(strict_types=1);

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\Types\Mixed_;
use phpDocumentor\Reflection\Types\Nullable;

class User extends Model
{
    protected $table = 'User';
    protected $fillable = [
        'amo_auth_user_id',
        'access_token',
        'refresh_token',
        'expires',
        'base_domain',
    ];
}

