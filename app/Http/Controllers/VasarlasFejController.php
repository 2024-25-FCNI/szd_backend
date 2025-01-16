<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VasarlasFej;

class VasarlasFejController extends Controller
{
    /**
     * GET: Az összes vásárlás fejléc lekérése.
     */
    public function index()
    {
        $vasarlasok = VasarlasFej::all();
        return response()->json($vasarlasok);
    }

    /**
     * GET: Egy adott vásárlás fejléc lekérése azonosító alapján.
     */
    public function show($id)
    {
        $vasarlas = VasarlasFej::find($id);

        if (!$vasarlas) {
            return response()->json(['message' => 'Vasárlás nem található'], 404);
        }

        return response()->json($vasarlas);
    }

    /**
     * POST: Új vásárlás fejléc létrehozása.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'osszeg' => 'required|integer|min:0',
            'datum' => 'required|date',
        ]);

        $vasarlas = VasarlasFej::create($validatedData);

        return response()->json(['message' => 'Vásárlás sikeresen létrehozva', 'vasarlas' => $vasarlas], 201);
    }

    /**
     * PUT: Vásárlás fejléc adatainak frissítése.
     */
    public function update(Request $request, $id)
    {
        $vasarlas = VasarlasFej::find($id);

        if (!$vasarlas) {
            return response()->json(['message' => 'Vasárlás nem található'], 404);
        }

        $validatedData = $request->validate([
            'user_id' => 'exists:users,user_id',
            'osszeg' => 'integer|min:0',
            'datum' => 'date',
        ]);

        $vasarlas->update($validatedData);

        return response()->json(['message' => 'Vásárlás sikeresen frissítve', 'vasarlas' => $vasarlas]);
    }

    /**
     * DELETE: Vásárlás fejléc törlése.
     */
    public function destroy($id)
    {
        $vasarlas = VasarlasFej::find($id);

        if (!$vasarlas) {
            return response()->json(['message' => 'Vasárlás nem található'], 404);
        }

        $vasarlas->delete();

        return response()->json(['message' => 'Vásárlás sikeresen törölve']);
    }
}
