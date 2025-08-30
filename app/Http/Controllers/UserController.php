<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {

        $users = User::with(['borrows.book'])->when($request->search, fn ($query) =>
            $query->where('name', 'like', "%{$request->search}%"))->latest()->paginate(5)
          ->withQueryString();
        return Inertia::render('User/Index', ['users' => $users,    'filters' => $request->only(['search'])]);

    }

    public function store(UserRequest $request)
    {
        User::create($request->validated());
           return redirect()->route('users.index');
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        return redirect()->route('users.index');

    }

    public function destroy(User $user)
    {
       $user->delete();
        return redirect()->route('users.index');
    }

}
