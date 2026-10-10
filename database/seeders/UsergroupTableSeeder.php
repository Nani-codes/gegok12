<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsergroupTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $groups = [
            1 => 'SiteAdmin',
            2 => 'SiteSubadmin',
            3 => 'SchoolAdmin',
            4 => 'SchoolSubadmin',
            5 => 'Teacher',
            6 => 'Student',
            7 => 'Parent',
            8 => 'Librarian',
            9 => 'OldStudent',
            10 => 'Receptionist',
            11 => 'Accountant',
            12 => 'Stock Keeper',
            13 => 'Non Teaching',
        ];

        foreach ($groups as $id => $name) {
            DB::table('usergroups')->updateOrInsert(
                ['id' => $id],
                [
                    'name' => $name,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
