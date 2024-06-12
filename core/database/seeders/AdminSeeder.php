<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::firstOrCreate([
            'email' => 'shoaib@urapptech.com',
        ], [
            'name' => 'Shoaib',
            'username' => 'super_admin',
            'password' => Hash::make('123123123'),
        ]);

        $admin->assignRole(1);
    }
}
