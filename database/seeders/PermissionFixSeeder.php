<?php

namespace Database\Seeders;

use App\Models\Auth\Role;
use Illuminate\Database\Seeder;

class PermissionFixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [47];
        $role = Role::where('name', '=', 'student')->first();
        $role->syncPermissions($permissions);
    }
}
