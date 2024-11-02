<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lessons')->insert([
            [
                'name' => 'Massivlar',
                'description' => 'Massivlar haqida tushuncha',
                'title' => 'massive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Listlar (Linked lists)',
                'description' => 'Listlar haqida tushuncha',
                'title' => 'lists',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staklar (Staks)',
                'description' => 'Staklar haqida tushuncha',
                'title' => 'staks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Qo'shimcha darslar qo'shishingiz mumkin
        ]);
    }
}
