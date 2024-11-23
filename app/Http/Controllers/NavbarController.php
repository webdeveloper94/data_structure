<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class NavbarController extends Controller
{
    public function getMenuItems()
    {
        // Get all published topics
        $menuItems = Topic::where('status', 'active')->get();

        return $menuItems;
    }
}
