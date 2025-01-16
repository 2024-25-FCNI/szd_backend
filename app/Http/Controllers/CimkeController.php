<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cimke;

class CimkeController extends Controller
{
    /**
     * GET: Az összes címke lekérése.
     */
    public function index()
    {
        $cimkek = Cimke::all();
        return response()->json($cimkek);
    }

    /**
     * GET: Egy adott címke lekérése azonosító alapján.
     */
    public function show($id)
    {
        $cimke = Cimke::find($id);

        if (!$cimke) {
            return response()->json(['message' => 'Címke nem található'], 404);
        }

        return response()->json($cimke);
    }

    /**
     * POST: Új címke létrehozása.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'elnevezes' => 'required|string|max:255',
        ]);

        $cimke = Cimke::create($validatedData);

        return response()->json(['message' => 'Címke sikeresen létrehozva', 'cimke' => $cimke], 201);
    }

    /**
     * PUT: Címke adatainak frissítése.
     */
    public function update(Request $request, $id)
    {
        $cimke = Cimke::find($id);

        if (!$cimke) {
            return response()->json(['message' => 'Címke nem található'], 404);
        }

        $validatedData = $request->validate([
            'elnevezes' => 'required|string|max:255',
        ]);

        $cimke->update($validatedData);

        return response()->json(['message' => 'Címke sikeresen frissítve', 'cimke' => $cimke]);
    }

    /**
     * DELETE: Címke törlése.
     */
    public function destroy($id)
    {
        $cimke = Cimke::find($id);

        if (!$cimke) {
            return response()->json(['message' => 'Címke nem található'], 404);
        }

        $cimke->delete();

        return response()->json(['message' => 'Címke sikeresen törölve']);
    }
}
