<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'plaisance']);
        Role::create(['name' => 'tresorier']);
        Role::create(['name' => 'comptable']);
        Role::create(['name' => 'admin juridique']);    
        Role::create(['name' => 'user']);    

        $admin = User::find(1);
        if ($admin) {
            $admin->assignRole('admin');
        }
        $plaisance = User::find(2);
        if ($plaisance) {
            $plaisance->assignRole('plaisance');
        }
        $tresorier = User::find(3);
        if ($tresorier) {
            $tresorier->assignRole('tresorier');
        }

        $comptable = User::find(4);
        if ($comptable) {
            $comptable->assignRole('comptable');
        }
        $admin_juridique = User::find(5);
        if ($admin_juridique) {
            $admin_juridique->assignRole('admin juridique');
        }
        $user1 = User::find(6);
        if ($user1) {
            $user1->assignRole('user');
        }
        $user1 = User::find(7);
        if ($user1) {
            $user1->assignRole('user');
        }
        $user1 = User::find(8);
        if ($user1) {
            $user1->assignRole('user');
        }


    }
}