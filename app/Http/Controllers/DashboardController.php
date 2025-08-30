<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use \App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //
    public function index()
    {

        return Inertia::render('Dashboard', [
            'categoriesCount' => Category::count(),
            'booksCount' => Book::count(),
            'borrowsCount' => Borrow::count(),
            'usersCount' => User::count()
        ]);
    }
}
