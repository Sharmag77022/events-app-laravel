<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){
        $user = Auth::user();
        if ($user->active_role === 'organizer') {
            return view('organizer.dashboard');
        }
        return view('dashboard');
    }

    public function switchDashboard()
    {
        $user = Auth::user();

        if ($user->active_role === 'attendee') {
            if (!$user->roles()->where('name', 'organizer')->exists()) {
                abort(403);
            }
            $user->update([
                'active_role' => 'organizer'
            ]);
        } else {
            $user->update([
                'active_role' => 'attendee'
            ]);
        }
        return redirect()->route('dashboard');
    }
}
