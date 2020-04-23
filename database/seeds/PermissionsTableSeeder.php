<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $access = ['User', 'Role', 'Permission'];

        $permissions = ['Index', 'Create', 'Read', 'Update', 'Delete'];

        foreach ($access as $acc) {
            foreach ($permissions as $permission) {
                DB::table('permissions')->insert([
                    'name' => $permission . ' ' . $acc,
                    'guard_name' => 'web',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        $permissionsList =  DB::table('permissions')->get()->toArray();

        foreach ($permissionsList as $pl) {
            DB::table('role_has_permissions')->insert([
                'role_id' => 1,
                'permission_id' => $pl->id,
            ]);
        }
    }
}
