<?php
declare(strict_types=1);

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\Types\Mixed_;

class User extends Model
{
    protected $table = 'User';



    protected $fillable = [
        'auth_user_id',
        'access_token',
        'refresh_token',
        'expires',
        'base_domain',
    ];


    /**
     * @return string
     */
    public function getAccessTokenAttribute():string {
        return $this->getAttributeFromArray('access_token');
    }

    /**
     * @param string $value
     * @return void
     */
    public function setAccessTokenAttribute(string $value) {
        $this->setAttribute('access_token',$value);
    }

    /**
     * @return string
     */
    public function getRefreshTokenAttribute():string {
        return $this->getAttributeFromArray('refresh_token');
    }

    /**
     * @param string $value
     * @return void
     */
    public function setRefreshTokenAttribute(string $value) {
        $this->setAttribute('refresh_token',$value);
    }

    /**
     * @return int
     */
    public function getExpiresAttribute():int {
        return $this->getAttributeFromArray('expires');
    }

    /**
     * @param int $value
     * @return void
     */
    public function setExpiresAttribute(int $value) {
        $this->setAttribute('expires',$value);
    }

    /**
     * @return string
     */
    public function getBaseDomainAttribute():string {
        return $this->getAttributeFromArray('base_domain');
    }

    /**
     * @param string $value
     * @return void
     */
    public function setBaseDomainAttribute(string $value) {
        $this->setAttribute('base_domain',$value);
    }
    /**
     * @return string
     */
    public function getAuthUserIdAttribute():string {
        return $this->getAttributeFromArray('auth_user_id');
    }

    /**
     * @param mixed
     * @return void
     */
    public function setAuthUserIdAttribute($value) {
        $this->setAttribute('auth_user_id',(string)$value);
    }

}