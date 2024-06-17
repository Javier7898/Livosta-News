<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.passwords.email');
    }

    public function confirmFavoriteWord(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'favorite_word' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->where('favorite_word', $request->favorite_word)->first();

        if (!$user) {
            return back()->withErrors(['favorite_word' => 'Favorite word does not match.']);
        }

        // Pass email and favorite word to the reset view
        return view('auth.passwords.reset')->with([
            'email' => $request->email,
            'favorite_word' => $request->favorite_word,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('status', 'Password reset successfully.');
    }
}
