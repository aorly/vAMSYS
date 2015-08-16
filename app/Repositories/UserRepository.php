<?php

namespace vAMSYS\Repositories;

class UserRepository {
    public static function hasRole($role, $user){
        if (strpos($role, '.'))
            return array_key_exists($role, array_dot($user->roles));
        else
            return array_key_exists($role, $user->roles);
    }
}