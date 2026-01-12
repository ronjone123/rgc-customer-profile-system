<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at','desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:6','confirmed'],
            'role' => ['nullable', Rule::in(['admin','manager','staff'])],
            'branch_id' => ['nullable','integer'],
            'is_admin' => ['nullable','boolean'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            // role & branch_id assume you added those fields earlier per blueprint
            'is_admin' => isset($data['is_admin']) ? (bool)$data['is_admin'] : false,
            'branch_id' => $data['branch_id'] ?? null,
        ]);

        return redirect()->route('admin.users.index')->with('success','User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'password' => ['nullable','string','min:6','confirmed'],
            'role' => ['nullable', Rule::in(['admin','manager','staff'])],
            'branch_id' => ['nullable','integer'],
            'is_admin' => ['nullable','boolean'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->is_admin = isset($data['is_admin']) ? (bool)$data['is_admin'] : $user->is_admin;
        $user->branch_id = $data['branch_id'] ?? $user->branch_id;
        $user->save();

        return redirect()->route('admin.users.index')->with('success','User updated.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if (auth()->id() === $user->id) {
            return back()->with('error','You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted.');
    }
}
