<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Termek;

class TermekController extends Controller
{
    /**
     * GET: Az összes termék lekérése.
     */
    public function index()
    {
        $termekek = Termek::all();
        return response()->json($termekek);
    }

    /**
     * GET: Egy adott termék lekérése azonosító alapján.
     */
    public function show($id)
    {
        $termek = Termek::find($id);

        if (!$termek) {
            return response()->json(['message' => 'Termék nem található'], 404);
        }

        return response()->json($termek);
    }

    /**
     * POST: Új termék létrehozása.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cim' => 'required|string|max:255',
            'leiras' => 'required|string',
            'url' => 'required|url',
            'hozzaferesi_ido' => 'required|integer|min:0',
            'ar' => 'required|integer|min:0',
            'jelzes' => 'required|string|max:255',
            'cimke_id' => 'required|exists:cimkes,cimke_id',
            'kep' => 'required|string',
        ]);

        $termek = Termek::create($validatedData);

        return response()->json(['message' => 'Termék sikeresen létrehozva', 'termek' => $termek], 201);
    }

    /**
     * PUT: Egy meglévő termék adatainak frissítése.
     */
    public function update(Request $request, $id)
    {
        $termek = Termek::find($id);

        if (!$termek) {
            return response()->json(['message' => 'Termék nem található'], 404);
        }

        $validatedData = $request->validate([
            'cim' => 'string|max:255',
            'leiras' => 'string',
            'url' => 'url',
            'hozzaferesi_ido' => 'integer|min:0',
            'ar' => 'integer|min:0',
            'jelzes' => 'string|max:255',
            'cimke_id' => 'exists:cimkes,cimke_id',
            'kep' => 'string',
        ]);

        $termek->update($validatedData);

        return response()->json(['message' => 'Termék sikeresen frissítve', 'termek' => $termek]);
    }

    /**
     * DELETE: Egy termék törlése.
     */
    public function destroy($id)
    {
        $termek = Termek::find($id);

        if (!$termek) {
            return response()->json(['message' => 'Termék nem található'], 404);
        }

        $termek->delete();

        return response()->json(['message' => 'Termék sikeresen törölve']);
    }
}
