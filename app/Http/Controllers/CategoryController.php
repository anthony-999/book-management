<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();
        return Inertia::render('Category/Index', ['categories' => $categories]);
    }

    public function create()
    {
        return Inertia::render('Category/Create');
    }

    public function store(Request $request)
    {
        // dd($request);

        //validate form input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|'
        ]);

        // save to database
        Category::create($validated);

        // Redirect or return response
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
       $category->delete();
       
       // Redirect or return response
        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
       
         return Inertia::render('Category/Edit',[ 'category' => $category ]);
    }

    public function update(Request $request, Category $category)
    {
        // validate input
            $validated =   $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|'
        ]);

         // save to database
         $category->update($validated);

          // Redirect or return response
        return redirect()->route('categories.index');

    }
}
