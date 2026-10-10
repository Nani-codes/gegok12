<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Usergroup;
use App\Models\Userprofile;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiteAdminSeeder extends Seeder
{
    /**
     * Idempotent overall (SiteAdmin) account for fresh deploys.
     */
    public function run(): void
    {
        Usergroup::query()->firstOrCreate(
            ['id' => User::SITEADMIN_USERGROUP_ID],
            [
                'name' => 'SiteAdmin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $user = User::withTrashed()->firstOrCreate(
            ['email' => 'siteadmin@gegok12.com'],
            [
                'name' => 'siteadmin',
                'password' => Hash::make('password'),
                'mobile_no' => '1230456789',
                'usergroup_id' => User::SITEADMIN_USERGROUP_ID,
                'school_id' => null,
                'status' => 'active',
                'email_verified' => true,
                'email_verified_at' => Carbon::now(),
                'email_verification_code' => Str::random(40),
                'remember_token' => Str::random(10),
            ]
        );

        if ($user->trashed()) {
            $user->restore();
        }

        Userprofile::query()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'usergroup_id' => User::SITEADMIN_USERGROUP_ID,
                'firstname' => 'siteadmin',
                'lastname' => 'siteadmin',
                'profession' => 'admin',
                'status' => 'active',
                'address' => 'Madurai,Tamilnadu,India',
                // Null location FKs until Countries/States/Cities seeders run
                'country_id' => null,
                'city_id' => null,
                'state_id' => null,
                'pincode' => '625001',
            ]
        );
    }
}
