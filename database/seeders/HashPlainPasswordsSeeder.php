<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HashPlainPasswordsSeeder extends Seeder
{
    public function run()
    {
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            if (strlen($user->password) < 60) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['password' => Hash::make($user->password)]);
            }
        }
    }
}
