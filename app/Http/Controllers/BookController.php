<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    //
    public function index(Request $request){
        $categories = Category::all();


         $books = Book::query()->when($request->search, fn($query) => $query->where('title', 'like', "%{$request->search}%"))
          ->latest()
        ->paginate(5)
        ->withQueryString();

        return Inertia::render('Book/Index',
        [
            'categories' => $categories,
              'books' => $books,
              'filters' => $request->only(['search'])
        ]);
    }

    public function store(Request $request)
    {
        //validate form input
         $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:100',
            'author' => 'required|string|max:25',
'isbn' => 'required|string|max:15|',
            'copies'  => 'required|integer|max:10',
        ]);
        

          // save to database
          Book::create($validated);

            // Redirect or return response
        return redirect()->route('books.index');

    }

     public function update(Request $request, Book $book)
    {
        // validate input
        $validated =   $request->validate([
           'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:100',
            'author' => 'required|string|max:25',
'isbn' => 'required|string|max:15|',
            'copies'  => 'required|integer|max:10',
        ]);

        // save to database
        $book->update($validated);

        // Redirect or return response
        return redirect()->route('books.index');
    }

    public function destroy(Book $book)
    {
        $book->delete();
         // Redirect or return response
        return redirect()->route('books.index');
    }
}
