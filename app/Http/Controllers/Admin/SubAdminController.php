<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SubAdminController extends Controller
{
    public function index()
    {
        $subAdmins = User::where('role', 'sub_admin')->latest()->paginate(10);
        return view('admin.sub-admins.index', compact('subAdmins'));
    }

    public function create()
    {
        return view('admin.sub-admins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => true,
            'role' => 'sub_admin',
        ]);

        return redirect()->route('admin.sub-admins.index')
            ->with('success', 'Sub admin created successfully.');
    }

    public function edit(User $subAdmin)
    {
        if ($subAdmin->role !== 'sub_admin') {
            abort(403, 'Cannot edit this user.');
        }

        return view('admin.sub-admins.edit', compact('subAdmin'));
    }

    public function update(Request $request, User $subAdmin)
    {
        if ($subAdmin->role !== 'sub_admin') {
            abort(403, 'Cannot edit this user.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $subAdmin->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $subAdmin->name = $validated['name'];
        $subAdmin->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $subAdmin->password = Hash::make($validated['password']);
        }
        
        $subAdmin->save();

        return redirect()->route('admin.sub-admins.index')
            ->with('success', 'Sub admin updated successfully.');
    }

    public function destroy(User $subAdmin)
    {
        if ($subAdmin->role !== 'sub_admin') {
            abort(403, 'Cannot delete this user.');
        }

        $subAdmin->delete();

        return redirect()->route('admin.sub-admins.index')
            ->with('success', 'Sub admin deleted successfully.');
    }
}