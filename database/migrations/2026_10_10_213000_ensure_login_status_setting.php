<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        $exists = DB::table('settings')->where('key', 'login_status')->exists();

        if ($exists) {
            return;
        }

        DB::table('settings')->insert([
            'key' => 'login_status',
            'name' => 'login',
            'description' => 'login',
            'value' => '1',
            'field' => '{"name":"value","label":"Userlogin" ,"type":"radio", "options":{"1":"Active", "0":"Inactive"}}',
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Keep the setting — removing it would reintroduce the maintenance false-positive.
    }
};
