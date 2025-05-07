<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('admin.user.profile', compact('user'));
    }

    public function edit(User $user)
    {
        $user = Auth::user();
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_telepon' => 'required|string|max:255',
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'no_telepon' => $request->no_telepon
            ]);
    
            notify()->success('Data User berhasil diperbarui!');
            return redirect()->route('admin.profile.index');
        } catch (\Exception $e) {
            notify()->error('Data User gagal diperbarui: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function passwordForm()
    {
        return view('admin.user.password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        try {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama salah.']);
            }
    
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
    
            notify()->success('Password berhasil diperbarui!');
            return redirect()->route('admin.profile.index');
        } catch (\Exception $e) {
            notify()->error('Password gagal diperbarui: ' . $e->getMessage());
            return back()->withInput();
        }
    }
}
