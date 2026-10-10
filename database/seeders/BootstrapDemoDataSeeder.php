<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

/**
 * One-time demo dataset for empty Coolify / Docker deploys.
 * Skips when at least one school already exists.
 */
class BootstrapDemoDataSeeder extends Seeder
{
    public function run(): void
    {
        if (! School::query()->exists()) {
            $this->command?->info('No schools found — seeding demo school data…');
            $this->call(DatabaseSeeder::class);
            $this->call(SiteAdminSeeder::class);
        } else {
            $this->command?->info('Schools already present — skipping full demo seed.');
        }

        // Always ensure a school admin exists (partial boots often created the school only).
        $this->call(SchoolAdminSeeder::class);
    }
}
