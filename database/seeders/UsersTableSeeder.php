<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Modelni import qilish

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin foydalanuvchisi
        User::create([
            'name' => 'Akobir Tohirov',
            'email' => 'akobir@gmail.com',
            'password' => Hash::make('Aspire578'), // Parolni shifrlash
            'role' => 'admin',
        ]);

        // Oddiy foydalanuvchi
        User::create([
            'name' => 'To\'lqin Tohirov',
            'email' => 'tulkin@gmail.com',
            'password' => Hash::make('Aspire578'), // Parolni shifrlash
            'role' => 'user',
        ]);
    }
}
