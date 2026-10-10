<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use App\Models\Usergroup;
use App\Models\Userprofile;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Idempotent school admin for Demo School (and any school missing an admin).
 */
class SchoolAdminSeeder extends Seeder
{
    public function run(): void
    {
        Usergroup::query()->firstOrCreate(
            ['id' => User::SCHOOLADMIN_USERGROUP_ID],
            [
                'name' => 'SchoolAdmin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $schools = School::query()->where('status', 1)->get();

        if ($schools->isEmpty()) {
            $this->command?->warn('No active schools — skipping SchoolAdminSeeder.');

            return;
        }

        foreach ($schools as $school) {
            $email = $school->id === 1
                ? 'demoschool@mailinator.com'
                : 'schooladmin'.$school->id.'@mailinator.com';

            $user = User::withTrashed()->firstOrCreate(
                ['email' => $email],
                [
                    'school_id' => $school->id,
                    'name' => 'demoschool',
                    'password' => Hash::make('password'),
                    'mobile_no' => '2230456789',
                    'usergroup_id' => User::SCHOOLADMIN_USERGROUP_ID,
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

            $user->forceFill([
                'school_id' => $school->id,
                'usergroup_id' => User::SCHOOLADMIN_USERGROUP_ID,
                'status' => 'active',
                'password' => Hash::make('password'),
            ])->save();

            Userprofile::query()->firstOrCreate(
                ['user_id' => $user->id],
                [
                    'school_id' => $school->id,
                    'usergroup_id' => User::SCHOOLADMIN_USERGROUP_ID,
                    'firstname' => 'demo',
                    'lastname' => 'school',
                    'profession' => 'admin',
                    'status' => 'active',
                    'address' => 'Namakkal,Tamilnadu,India',
                    'country_id' => null,
                    'city_id' => null,
                    'state_id' => null,
                    'pincode' => '625001',
                ]
            );
        }
    }
}
