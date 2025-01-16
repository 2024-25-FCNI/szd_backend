<?php

namespace App\Http\Controllers;

use App\Models\Kapcsolo;
use Illuminate\Http\Request;

class KapcsoloController extends Controller
{
    /**
     * GET: Az összes kapcsoló lekérése.
     */
    public function index()
    {
        $kapcsolos = Kapcsolo::with(['termek', 'cimke'])->get();
        return response()->json($kapcsolos);
    }

    /**
     * GET: Egy adott kapcsoló lekérése.
     */
    public function show($id)
    {
        $kapcsolo = Kapcsolo::with(['termek', 'cimke'])->find($id);

        if (!$kapcsolo) {
            return response()->json(['message' => 'Kapcsoló nem található'], 404);
        }

        return response()->json($kapcsolo);
    }

    /**
     * POST: Új kapcsoló létrehozása.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'termek_id' => 'required|exists:termeks,termek_id',
            'cimke_id' => 'required|exists:cimkes,cimke_id',
        ]);

        $kapcsolo = Kapcsolo::create($validatedData);

        return response()->json(['message' => 'Kapcsoló sikeresen létrehozva', 'kapcsolo' => $kapcsolo], 201);
    }

    /**
     * DELETE: Egy kapcsoló törlése.
     */
    public function destroy($id)
    {
        $kapcsolo = Kapcsolo::find($id);

        if (!$kapcsolo) {
            return response()->json(['message' => 'Kapcsoló nem található'], 404);
        }

        $kapcsolo->delete();

        return response()->json(['message' => 'Kapcsoló sikeresen törölve']);
    }
}
