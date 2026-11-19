<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function signup(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function registerOrganizer()
    {
        $user = Auth::user();

        $organizerRole = Role::where('name', 'organizer')->firstOrFail();

        $user->roles()->syncWithoutDetaching([$organizerRole->id]);

        return redirect()->route('dashboard');
    }

    public function registerOrganizerView()
    {
        $user = Auth::user();
        if ($user->hasOrganizerRole()) {
            return redirect()->route('dashboard');
        }

        return view('organizer.register');
    }
}
