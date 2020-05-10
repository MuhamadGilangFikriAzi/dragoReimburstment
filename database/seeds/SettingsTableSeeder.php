<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data['langsung'] = ['petty cash', 'uang pribadi'];
        $data['transfer'] = ['BCA', 'Cimb Niaga'];
        $data['email'] = ['mgfa9802@gmail.com'];

        foreach ($data as $key => $value) {
            DB::table('settings')->insert([
                'nama' => $key,
                'value' => json_encode($value),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
