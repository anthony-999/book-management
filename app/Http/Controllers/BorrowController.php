<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowRequest;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::latest()->get();
      $borrows = Borrow::with(['book', 'user'])
        ->when($request->search, function ($query, $search) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
        })
        ->latest()
        ->paginate(5)
        ->withQueryString(); // ✅ keeps search in pagination links

    $users = User::latest()->get();

        return Inertia::render('Borrow/Index', [
            'borrows' => $borrows,
            'books' => $books,
            'users' => $users,
            'filters' => $request->only(['search'])
        ]);
    }

    public function store(BorrowRequest $request)
    {
        Borrow::create($request->validated());

        return redirect()->route('borrows.index');
    }

    public function destroy(Borrow $borrow)
    {
        $borrow->delete();
        return redirect()->route('borrows.index');
    }

    public function update(BorrowRequest $request, Borrow $borrow)
    {
        $borrow->update($request->validated());

        return redirect()->route('borrows.index');
    }
}
