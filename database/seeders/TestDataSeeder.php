<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create test user
        DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create topics
        $topicIds = [];
        $topics = [
            [
                'name' => 'Arrays and Lists',
                'description' => 'Introduction to arrays, lists, and their operations',
                'order' => 1,
                'status' => 'active',
                'icon' => 'bi bi-list-nested',
                'color' => '#4CAF50',
                'estimated_time' => 120,
            ],
            [
                'name' => 'Stacks and Queues',
                'description' => 'Understanding stack and queue data structures',
                'order' => 2,
                'status' => 'active',
                'icon' => 'bi bi-stack',
                'color' => '#2196F3',
                'estimated_time' => 90,
            ],
            [
                'name' => 'Trees',
                'description' => 'Learning about tree structures and traversal algorithms',
                'order' => 3,
                'status' => 'active',
                'icon' => 'bi bi-diagram-3',
                'color' => '#FF9800',
                'estimated_time' => 150,
            ],
        ];

        foreach ($topics as $topic) {
            $id = DB::table('topics')->insertGetId(array_merge($topic, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
            $topicIds[] = $id;
        }

        // Create lessons
        $lessonData = [
            [
                'topic_id' => $topicIds[0],
                'title' => 'Introduction to Arrays',
                'description' => 'Learn the basics of array data structure',
                'content' => 'Arrays are fundamental data structures that store elements in contiguous memory locations...',
                'difficulty_level' => 'beginner',
                'estimated_time' => 30,
                'order' => 1,
                'status' => 'published',
            ],
            [
                'topic_id' => $topicIds[0],
                'title' => 'Dynamic Arrays',
                'description' => 'Understanding dynamic arrays and their implementation',
                'content' => 'Dynamic arrays are arrays that can grow or shrink in size during program execution...',
                'difficulty_level' => 'intermediate',
                'estimated_time' => 45,
                'order' => 2,
                'status' => 'published',
            ],
        ];

        foreach ($lessonData as $lesson) {
            DB::table('lessons')->insert(array_merge($lesson, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Create tests
        $testIds = [];
        $testData = [
            [
                'topic_id' => $topicIds[0],
                'title' => 'Arrays Basics Test',
                'description' => 'Test your knowledge of basic array operations',
                'time_limit' => 20,
                'passing_score' => 70,
                'difficulty' => 'beginner',
                'status' => 'published',
            ],
            [
                'topic_id' => $topicIds[1],
                'title' => 'Stack Operations Test',
                'description' => 'Test your understanding of stack operations',
                'time_limit' => 30,
                'passing_score' => 75,
                'difficulty' => 'intermediate',
                'status' => 'published',
            ],
        ];

        foreach ($testData as $test) {
            $id = DB::table('tests')->insertGetId(array_merge($test, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
            $testIds[] = $id;
        }

        // Create questions
        $questionData = [
            [
                'test_id' => $testIds[0],
                'question' => 'What is the time complexity of accessing an element in an array by index?',
                'options' => json_encode(['O(1)', 'O(n)', 'O(log n)', 'O(n²)']),
                'correct_answer' => 'O(1)',
                'points' => 2,
                'explanation' => 'Array access by index is constant time because it uses direct memory addressing.',
                'order' => 1,
            ],
            [
                'test_id' => $testIds[0],
                'question' => 'Which operation in an array has a worst-case time complexity of O(n)?',
                'options' => json_encode(['Accessing by index', 'Insertion at end', 'Insertion at beginning', 'Reading length']),
                'correct_answer' => 'Insertion at beginning',
                'points' => 2,
                'explanation' => 'Inserting at the beginning requires shifting all existing elements one position to the right.',
                'order' => 2,
            ],
        ];

        foreach ($questionData as $question) {
            DB::table('questions')->insert(array_merge($question, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Create some test results
        DB::table('results')->insert([
            'user_id' => 2, // test user
            'test_id' => $testIds[0],
            'score' => 85,
            'time_taken' => 900, // 15 minutes in seconds
            'answers' => json_encode([
                ['question_id' => 1, 'answer' => 'O(1)', 'correct' => true],
                ['question_id' => 2, 'answer' => 'Insertion at beginning', 'correct' => true],
            ]),
            'completed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
