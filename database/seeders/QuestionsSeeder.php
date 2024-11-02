<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionsSeeder extends Seeder
{
    public function run()
    {
        // Massivlar mavzusi bo'yicha savollar
        $arrayQuestions = [
            [
                'topic' => 'Massivlar',
                'question' => 'Massivlar nima?',
                'option_a' => 'Bir xil turdagi ma\'lumotlarni saqlovchi struktura',
                'option_b' => 'Foydalanuvchidan olingan ma\'lumotlar',
                'option_c' => 'Faoliyatlar ro\'yxati',
                'correct_option' => 'a'
            ],
            [
                'topic' => 'Massivlar',
                'question' => 'PHPda massiv qanday yaratiladi?',
                'option_a' => '$arr = array();',
                'option_b' => 'array[];',
                'option_c' => '$arr = [];',
                'correct_option' => 'c'
            ],
            [
                'topic' => 'Massivlar',
                'question' => 'Massivdagi elementni qanday olish mumkin?',
                'option_a' => '$arr[index];',
                'option_b' => 'get($arr, index);',
                'option_c' => '$arr[index]();',
                'correct_option' => 'a'
            ],
            [
                'topic' => 'Massivlar',
                'question' => 'PHPda massivlar necha turga bo\'linadi?',
                'option_a' => '1',
                'option_b' => '2',
                'option_c' => '3',
                'correct_option' => 'b'
            ],
            [
                'topic' => 'Massivlar',
                'question' => 'Massivni qanday to\'ldirish mumkin?',
                'option_a' => '$arr[] = value;',
                'option_b' => 'array_push($arr, value);',
                'option_c' => 'add($arr, value);',
                'correct_option' => 'a'
            ],
            [
                'topic' => 'Massivlar',
                'question' => 'Massivni qanday tartiblash mumkin?',
                'option_a' => 'sort($arr);',
                'option_b' => 'order($arr);',
                'option_c' => 'arr_sort($arr);',
                'correct_option' => 'a'
            ],
            [
                'topic' => 'Massivlar',
                'question' => 'Massiv uzunligini qanday olish mumkin?',
                'option_a' => 'length($arr);',
                'option_b' => 'count($arr);',
                'option_c' => 'sizeof($arr);',
                'correct_option' => 'b'
            ],
            [
                'topic' => 'Massivlar',
                'question' => 'Massivni qanday bo\'lishi mumkin?',
                'option_a' => 'slice();',
                'option_b' => 'split();',
                'option_c' => 'divide();',
                'correct_option' => 'a'
            ],
            [
                'topic' => 'Massivlar',
                'question' => 'Associative massivlar nima?',
                'option_a' => 'Kalit-qiymat juftlari',
                'option_b' => 'Faqat raqamli indekslar',
                'option_c' => 'Oddiy massivlar',
                'correct_option' => 'a'
            ],
            [
                'topic' => 'Massivlar',
                'question' => 'Massivni qanday tozalash mumkin?',
                'option_a' => 'clear($arr);',
                'option_b' => 'unset($arr);',
                'option_c' => 'delete($arr);',
                'correct_option' => 'b'
            ],
        ];

        // Listlar mavzusi bo'yicha savollar
        $listQuestions = [
            [
                'topic' => 'Listlar',
                'question' => 'Listlar nima?',
                'option_a' => 'O\'zgaruvchilar ro\'yxati',
                'option_b' => 'Massivlar',
                'option_c' => 'Fayllar',
                'correct_option' => 'a'
            ],
            [
                'topic' => 'Listlar',
                'question' => 'Listda elementni qanday qo\'shish mumkin?',
                'option_a' => 'add($list, value);',
                'option_b' => 'list[] = value;',
                'option_c' => 'push($list, value);',
                'correct_option' => 'b'
            ],
            [
                'topic' => 'Listlar',
                'question' => 'Listdagi birinchi elementni qanday olish mumkin?',
                'option_a' => 'first($list);',
                'option_b' => '$list[0];',
                'option_c' => '$list->head;',
                'correct_option' => 'b'
            ],
            [
                'topic' => 'Listlar',
                'question' => 'Listni qanday aylantirish mumkin?',
                'option_a' => 'rotate($list);',
                'option_b' => 'shuffle($list);',
                'option_c' => 'sort($list);',
                'correct_option' => 'b'
            ],
            [
                'topic' => 'Listlar',
                'question' => 'Listdagi elementni qanday o\'chirish mumkin?',
                'option_a' => 'remove($list, index);',
                'option_b' => 'unset($list[index]);',
                'option_c' => 'delete($list[index]);',
                'correct_option' => 'b'
            ],
            [
                'topic' => 'Listlar',
                'question' => 'Listlarni birlashtirish qanday amalga oshiriladi?',
                'option_a' => 'merge($list1, $list2);',
                'option_b' => '$list1 + $list2;',
                'option_c' => 'combine($list1, $list2);',
                'correct_option' => 'b'
            ],
            [
                'topic' => 'Listlar',
                'question' => 'Listda elementni qanday qidirish mumkin?',
                'option_a' => 'find($list, value);',
                'option_b' => 'search($list, value);',
                'option_c' => 'in_array(value, $list);',
                'correct_option' => 'c'
            ],
            [
                'topic' => 'Listlar',
                'question' => 'Listning uzunligini qanday olish mumkin?',
                'option_a' => 'count($list);',
                'option_b' => 'length($list);',
                'option_c' => 'sizeof($list);',
                'correct_option' => 'a'
            ],
            [
                'topic' => 'Listlar',
                'question' => 'Listni qanday tozalash mumkin?',
                'option_a' => 'clear($list);',
                'option_b' => 'reset($list);',
                'option_c' => 'unset($list);',
                'correct_option' => 'c'
            ],
        ];

        // Massivlar savollarini saqlash
        foreach ($arrayQuestions as $question) {
            Question::create($question);
        }

        // Listlar savollarini saqlash
        foreach ($listQuestions as $question) {
            Question::create($question);
        }
    }
}
