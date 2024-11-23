<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertRoleMigration extends Seeder
{
    public function run()
    {
        DB::table('migrations')->insert([
            'migration' => '2024_02_14_000000_add_role_to_users_table',
            'batch' => 1
        ]);
    }
}
