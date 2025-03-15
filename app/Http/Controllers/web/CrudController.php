<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CrudController extends Controller
{
    // Show all users
    public function index(Request $request) {
        $query = User::query();

        // Filtering (Search Users)
        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
        }

        $users = $query->paginate(5);
        return view('crud.index', compact('users'));
    }

    // Show create user form
    public function create() {
        return view('crud.create');
    }

    // Store a new user in the database
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('crud.index')->with('success', 'User created successfully.');
    }

    // Show edit form
    public function edit(User $user) {
        return view('crud.edit', compact('user'));
    }

    // Update user in the database
    public function update(Request $request, User $user) {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('crud.index')->with('success', 'User updated successfully.');
    }



public function destroy(User $user) {
    $user->delete();
    return redirect()->route('crud.index')->with('success', 'User deleted successfully');
}

}
