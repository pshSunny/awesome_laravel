<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the resource.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return view('auth.profile.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('auth.profile.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $data = $request->validated();

        if ($request->filled('password')) {
            $data = [
                ...$data,
                //'password' => Hash::make($request->password),
                'password' => $request->password,
            ];
        }

        $user->update($data);

        return to_route('profile.show');
    }
}
