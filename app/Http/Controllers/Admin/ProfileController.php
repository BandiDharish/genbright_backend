<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class ProfileController extends Controller
{
    /**
     * Update the logged-in admin's profile and settings.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],
            'current_password' => [
                'required',
                'string',
            ],
            'new_password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'current_password' => ['The provided current password does not match our records.']
                    ]
                ], 422);
            }

            return back()
                ->withErrors([
                    'current_password' => 'The provided current password does not match our records.'
                ])
                ->withInput();
        }

        $user->email = $request->email;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

       $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully.',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }
}
