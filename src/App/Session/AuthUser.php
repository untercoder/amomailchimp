<?php

namespace App\Session;
session_start();

class AuthUser
{
    private const AUTH_USER = 'auth_amo_user_id';

    public static function setAuthUser(int $authUser) : void {
        $_SESSION[self::AUTH_USER] = $authUser;
    }

    public static function unsetAuthUser() : void {
        unset($_SESSION[self::AUTH_USER]);
    }

    public static function getAuthUser() : int {
        return $_SESSION[self::AUTH_USER];
    }

    public static function userIsAuth() : bool {
        if(isset($_SESSION[self::AUTH_USER])) {
            return true;
        } else {
            return false;
        }
    }
}