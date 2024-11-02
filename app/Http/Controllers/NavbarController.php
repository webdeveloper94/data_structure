<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Menu; // Menu modelini o'z ichiga oling
use Illuminate\Http\Request;

class NavbarController extends Controller
{
    public function getMenuItems()
    {
        // Menu ma'lumotlarini olish
        $menuItems = Lesson::all(); 

        return $menuItems;
    }
}
