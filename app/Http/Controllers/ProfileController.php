<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function edit() {
        return Inertia::render('Profile/Edit', [
            "user" => Auth::user(),
            "status" => session('message'),
        ]);
    }

    public function updateInfo(Request $request) {
        $user = $request->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:128'],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        
        $user->save();

        return back();
    }

    public function updatePassword(Request $request) {
        $user = $request->user();
        $validated = $request->validate([
            "currentPassword" => ['required', 'string', 'current_password'],
            "newPassword" => ['required', 'string', 'min:8', "confirmed"],
        ]);

        $user->update([
            "password" => Hash::make($validated['newPassword'])
        ]);

        return back();
    }

    public function deleteAccount(Request $request) {
        $request->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout($user);

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
