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
        if (School::query()->exists()) {
            $this->command?->info('Schools already present — skipping demo bootstrap.');

            return;
        }

        $this->command?->info('No schools found — seeding demo school data…');

        $this->call(DatabaseSeeder::class);
        $this->call(SiteAdminSeeder::class);
    }
}
