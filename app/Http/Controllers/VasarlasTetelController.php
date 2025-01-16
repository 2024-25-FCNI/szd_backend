<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VasarlasTetel;

class VasarlasTetelController extends Controller
{
    /**
     * GET: Az összes vásárlási tétel lekérése.
     */
    public function index()
    {
        $vasarlasTetel = VasarlasTetel::with(['vasarlasFej', 'termek'])->get();
        return response()->json($vasarlasTetel);
    }

    /**
     * POST: Új vásárlási tétel hozzáadása.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'vasarlas_id' => 'required|exists:vasarlas_fejs,vasarlas_id',
            'termek_id' => 'required|exists:termeks,termek_id',
        ]);

        $vasarlasTetel = VasarlasTetel::create($validatedData);

        return response()->json(['message' => 'Vásárlási tétel sikeresen létrehozva', 'vasarlasTetel' => $vasarlasTetel], 201);
    }

    /**
     * DELETE: Vásárlási tétel törlése.
     */
    public function destroy($vasarlasId, $termekId)
    {
        $vasarlasTetel = VasarlasTetel::where('vasarlas_id', $vasarlasId)
            ->where('termek_id', $termekId)
            ->first();

        if (!$vasarlasTetel) {
            return response()->json(['message' => 'A vásárlási tétel nem található'], 404);
        }

        $vasarlasTetel->delete();

        return response()->json(['message' => 'Vásárlási tétel sikeresen törölve']);
    }
}
