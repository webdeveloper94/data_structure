<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // "massivlar" mavzusiga mos 3 ta mavzu
        $massivlarTopics = [
            [
                'lesson_id' => 1, // Bu yerda mos keluvchi lesson_id ni o'rnating
                'title' => 'Massivlar haqida kirish',
                'content' => 'Bu mavzuda massivlar haqida asosiy tushunchalar beriladi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lesson_id' => 1,
                'title' => 'Massivlar yaratish',
                'content' => 'Massivlarni qanday yaratish mumkinligi haqida ma\'lumot.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lesson_id' => 1,
                'title' => 'Massivlar bilan ishlash',
                'content' => 'Massivlar bilan qanday ishlash mumkinligi haqida ko\'rsatmalar.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // "listlar" mavzusiga mos 3 ta mavzu
        $listlarTopics = [
            [
                'lesson_id' => 2, // Bu yerda mos keluvchi lesson_id ni o'rnating
                'title' => 'Listlar haqida kirish',
                'content' => 'Listlar, ya\'ni ro\'yxatlar, dasturlashda muhim tushuncha.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lesson_id' => 2,
                'title' => 'Listlarni yaratish',
                'content' => 'Listlarni qanday yaratish mumkinligi haqida ma\'lumot.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lesson_id' => 2,
                'title' => 'Listlar bilan ishlash',
                'content' => 'Listlar bilan qanday ishlash mumkinligi haqida ko\'rsatmalar.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Mavzularni `topics` jadvaliga qo'shish
        DB::table('topics')->insert(array_merge($massivlarTopics, $listlarTopics));
    }
}
