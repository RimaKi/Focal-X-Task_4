<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            "admin",
            "author",
            "user"
        ];
        foreach ($roles as $role) {
            Role::create(["name" => $role]);
        }
        $admin = Role::findByName("admin");
        $user = User::create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => 'Admin123123123*',
        ]);
        $user->assignRole($admin);

        $author = Role::findByName("author");
        $user_1 = User::create([
            "name" => "author",
            "email" => "author@gmail.com",
            "password" => 'Author123123123*',
        ]);
        $user_1->assignRole($author);
    }
}
