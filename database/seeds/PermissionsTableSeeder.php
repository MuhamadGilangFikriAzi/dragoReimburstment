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

        $users = ['Ajukan Reimburstment', 'Edit Reimburstment', 'Hapus Reimburstment', 'Melihat Reimburstment', 'Melihat Pengembalian Dana', 'Edit Pengembalian Dana'];
        $admins = ['Lihat Reimburstment', 'Terima Reimburstment', 'Tolak Reimburstment', 'Memberikan Dana', 'Edit Pengembalian Dana', 'Hapus Pengembalian Dana', 'Melihat Pengembalian Dana', 'Mencari Laporan Reimburstment', 'Melihat Laporan Reimburstment', 'Eksport Laporan Reimburstment', 'Mencari Laporan Pengembalian Dana', 'Melihat Laporan Pengembalian Dana', 'Eksport Laporan Pengembalian Dana', 'Kirim Email Reimburstment', 'Terima Pengembalian Dana'];

        foreach ($access as $acc) {
            foreach ($permissions as $permission) {
                DB::table('permissions')->insert([
                    'name' => $permission . ' ' . $acc,
                    'guard_name' => 'web',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $settings[] = $permission . ' ' . $acc;
            }
        }

        foreach ($users as $user) {
            DB::table('permissions')->insert([
                'name' => $user,
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        foreach ($admins as $admin) {
            DB::table('permissions')->insert([
                'name' => $admin,
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $permissionsList =  DB::table('permissions')->get()->toArray();

        foreach ($permissionsList as $pl) {
            DB::table('role_has_permissions')->insert([
                'role_id' => 1,
                'permission_id' => $pl->id,
            ]);
        }

        foreach ($admins as $admin) {
            $id = DB::table('permissions')->where('name', $admin)->first()->id;

            DB::table('role_has_permissions')->insert([
                'role_id' => 2,
                'permission_id' => $id,
            ]);
        }

        foreach ($users as $user) {
            $id = DB::table('permissions')->where('name', $user)->first()->id;

            DB::table('role_has_permissions')->insert([
                'role_id' => 3,
                'permission_id' => $id,
            ]);
        }

        foreach ($settings as $setting) {
            $id = DB::table('permissions')->where('name', $setting)->first()->id;

            DB::table('role_has_permissions')->insert([
                'role_id' => 2,
                'permission_id' => $id,
            ]);
        }
    }
}
