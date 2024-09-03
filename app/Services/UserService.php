<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserService
{
    /**
     * add user and add role for it
     * @param array $data
     * @param string $role
     * @return mixed
     */
    public function StoreUser(array $data, string $role)
    {
        $user = User::create($data);
        $user->assignRole(Role::findByName($role));
        return $user;
    }
}
