<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Carbon;

class RoleSeeder extends Seeder
{
    public function run()
    {

        $roles = [
            ['name' => 'admin', 'guard_name' => 'web','created_at'=>Carbon::now()],
            ['name' => 'teacher', 'guard_name' => 'web','created_at'=>Carbon::now()],
            ['name' => 'student', 'guard_name' => 'web','created_at'=>Carbon::now()],
            ['name' => 'user', 'guard_name' => 'web','created_at'=>Carbon::now()],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate($role);
        }
    }

}
