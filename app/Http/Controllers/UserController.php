<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function updatePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(["message" => "Password updated successfully", "user" => $user]);
    }

    /**
     * GET: Az összes felhasználó lekérése.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * GET: Egy adott felhasználó lekérése azonosító alapján.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    /**
     * POST: Új felhasználó létrehozása.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'integer|in:0,1',
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']); // Jelszó titkosítása
        $user->role = $validatedData['role'] ?? 1; // Alapértelmezett szerep: felhasználó
        $user->save();

        return response()->json(['message' => 'Felhasználó sikeresen létrehozva', 'user' => $user], 201);
    }

    /**
     * PUT: Felhasználó adatainak frissítése.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'string|min:6',
            'role' => 'integer|in:0,1',
        ]);

        if (isset($validatedData['name'])) {
            $user->name = $validatedData['name'];
        }

        if (isset($validatedData['email'])) {
            $user->email = $validatedData['email'];
        }

        if (isset($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        if (isset($validatedData['role'])) {
            $user->role = $validatedData['role'];
        }

        $user->save();

        return response()->json(['message' => 'Felhasználó adatai sikeresen frissítve', 'user' => $user]);
    }

    /**
     * DELETE: Felhasználó törlése.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully', 'user' => $user]);
    }

    /**
     * GET: Admin felhasználók lekérése.
     */
    public function getAdmins()
    {
        $admins = User::where('role', 0)->get();
        return response()->json($admins);
    }
}
