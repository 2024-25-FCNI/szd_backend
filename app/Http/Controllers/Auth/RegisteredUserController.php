<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'nev' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'jelszo' => ['required', 'confirmed', Rules\password::defaults()],
            'role' => ['integer']
        ]);

        $user = User::create([
            'nev' => $request->nev,
            'email' => $request->email,
            'jelszo' => Hash::make($request->string('jelszo')),
            'role' => 1
        ]);

        event(new Registered($user));
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);

        $validatedData = $request->validate([
            'nev' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'jelszo' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'nev' => $validatedData['nev'],
            'email' => $validatedData['email'],
            'jelszo' => Hash::make($validatedData['jelszo']),
        ]);

        return response()->json(['message' => 'User successfully registered', 'user' => $user], 201);
    }
}
