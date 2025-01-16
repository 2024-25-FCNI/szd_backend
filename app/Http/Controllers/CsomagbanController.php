<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Csomagban;

class CsomagbanController extends Controller
{
    /**
     * GET: Az összes csomagban rekord lekérése.
     */
    public function index()
    {
        $csomagok = Csomagban::with('termek')->get();
        return response()->json($csomagok);
    }

    /**
     * GET: Egy csomagban rekord lekérése azonosító alapján.
     */
    public function show($id)
    {
        $csomag = Csomagban::with('termek')->find($id);

        if (!$csomag) {
            return response()->json(['message' => 'Csomag nem található'], 404);
        }

        return response()->json($csomag);
    }

    /**
     * POST: Új csomagban rekord létrehozása.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'termek_id' => 'required|exists:termeks,termek_id',
        ]);

        $csomag = Csomagban::create($validatedData);

        return response()->json(['message' => 'Csomag sikeresen létrehozva', 'csomag' => $csomag], 201);
    }

    /**
     * DELETE: Egy csomagban rekord törlése azonosító alapján.
     */
    public function destroy($id)
    {
        $csomag = Csomagban::find($id);

        if (!$csomag) {
            return response()->json(['message' => 'Csomag nem található'], 404);
        }

        $csomag->delete();

        return response()->json(['message' => 'Csomag sikeresen törölve']);
    }
}
