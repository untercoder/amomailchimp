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

    public function getAccessTokenAttribute():string {
        return $this->getAttributeFromArray('access_token');
    }

    public function setAccessTokenAttribute(string $value) {
        $this->setAttribute('access_token',$value);
    }

    public function getRefreshTokenAttribute():string {
        return $this->getAttributeFromArray('refresh_token');
    }

    public function setRefreshTokenAttribute(string $value) {
        $this->setAttribute('refresh_token',$value);
    }

    public function getExpiresAttribute():int {
        return $this->getAttributeFromArray('expires');
    }

    public function setExpiresAttribute(int $value) {
        $this->setAttribute('expires',$value);
    }

    public function getBaseDomainAttribute():string {
        return $this->getAttributeFromArray('base_domain');
    }

    public function setBaseDomainAttribute(string $value) {
        $this->setAttribute('base_domain',$value);
    }

}