<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SettingsController extends Controller
{
    public function index() {
        $pendingUsers = User::where('status', 'pending')->get();
        return view('settings.index', compact('pendingUsers'));
    }

    public function setupProfile(Request $request) {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'avatar' => 'nullable|string'
        ]);

        $user = Auth::user();
        if ($user) {
            $user->company_name = $request->company_name;
            if ($request->avatar) {
                $user->avatar = $request->avatar;
            }
            $user->save();
        }

        return back();
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'avatar' => 'nullable|string',
            'avatar_file' => 'nullable|image|max:2048'
        ]);

        $user = Auth::user();
        if ($user) {
            $user->name = $request->name;
            $user->company_name = $request->company_name;
            
            if ($request->hasFile('avatar_file')) {
                if ($user->avatar && str_contains($user->avatar, 'avatars/')) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
                }
                $path = $request->file('avatar_file')->store('avatars', 'public');
                $user->avatar = $path;
            } elseif ($request->avatar) {
                $user->avatar = $request->avatar;
            }
            
            $user->save();
        }

        return back()->with('success', 'Perfil actualizado con éxito');
    }

    public function approve($id) {
        if(Auth::user()->role !== 'super_admin') abort(403);
        User::where('id', $id)->update(['status' => 'approved']);
        return back();
    }

    public function reject($id) {
        if(Auth::user()->role !== 'super_admin') abort(403);
        User::where('id', $id)->delete();
        return back();
    }
}
