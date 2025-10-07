<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RoleSeeder extends Seeder
{
    public function run()
    {

        $roles = [
            ['name' => 'admin', 'guard_name' => 'api', 'created_at' => Carbon::now()],
            ['name' => 'teacher', 'guard_name' => 'api', 'created_at' => Carbon::now()],
            ['name' => 'student', 'guard_name' => 'api', 'created_at' => Carbon::now()],
            ['name' => 'user', 'guard_name' => 'api', 'created_at' => Carbon::now()],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate($role);
        }
    }
}
