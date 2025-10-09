<?php

namespace App\Traits;

trait RoleHelper
{
    public function getUserRole($email) : string
    {
        $admins = [
            'jerry2562005@gmail.com',
            'abdelrahman.elaraby777@gmail.com',
            'ahmedalinaguib33@gmail.com'
        ];

        return in_array($email, $admins) ? 'admin' : 'user';
    }
}
