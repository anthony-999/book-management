<?php

namespace App\Http\Controllers;

use \App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //
    public function index()
    {
        
        return Inertia::render('Dashboard', [
            'categoriesCount' => Category::count(),
        ]);
        
    }

}
