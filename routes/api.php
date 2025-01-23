<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CimkeController;
use App\Http\Controllers\CsomagbanController;
use App\Http\Controllers\KapcsoloController;
use App\Http\Controllers\TermekController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VasarlasFejController;
use App\Http\Controllers\VasarlasTetelController;
use App\Http\Middleware\Admin;
use App\Models\Termek;
use App\Models\User;
use App\Models\VasarlasFej;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['csrf_token' => csrf_token()]);
});


Route::middleware(['web'])->group(function () {
    Route::post('/regisztracio', [RegisteredUserController::class, 'store']);
    Route::post('/bejelentkezes', [AuthenticatedSessionController::class, 'store']);
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/kijelentkezes', [AuthenticatedSessionController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', Admin::class])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index']);



});











// Felhasználók vásárlásaik összegével
Route::get('/admin/felhasznalok-vasarlasai', function () {
    return User::felhasznalokVasarlasOsszeggel();
});

// Vásárlások és azokhoz tartozó termékek
Route::get('/vasarlasok-termekekkel', function () {
    return VasarlasFej::vasarlasokEsTermekek();
});

// Termékek adott címkével
Route::get('/termekek-cimke-szerint/{cimke}', function ($cimke) {
    return Termek::adottCimkesTermekek($cimke);
});

// Egy adott felhasználó vásárlásainak listája
Route::get('/felhasznalo/{felhasznaloId}/vasarlasai', function ($felhasznaloId) {
    return VasarlasFej::felhasznaloVasarlasai($felhasznaloId);
});

//Adott csomagban lévő termékek
Route::get('/csomagok/{csomagId}/termekek', function ($csomagId) {
    return VasarlasFej::csomagTermekei($csomagId);
});

// Termékek hozzáférési idővel rendezve
Route::get('/termekek-hozzaferesi-ido-szerint', function () {
    return Termek::termekekHozzaferesiIdovel();
});

//Felhasználók szerep alapján
Route::get('/felhasznalok-szerep-szerint/{szerep}', function ($szerep) {
    return User::felhasznalokSzerepSzerint($szerep);
});

//Összes vásárlás adott dátumintervallumban
Route::get('/vasarlasok-datum-intervallumban', function (Illuminate\Http\Request $request) {
    $kezdoDatum = $request->query('kezdo');
    $vegeDatum = $request->query('vege');
    return VasarlasFej::vasarlasokDatumIntervallumban($kezdoDatum, $vegeDatum);
});

//Legdrágább termékek listája
Route::get('/termekek-legdragabbak', function () {
    return Termek::legdragabbTermekek();
});

//Termékek és azokhoz tartozó címkék
Route::get('/termekek-cimkekkel', function () {
    return Termek::termekekEsCimkek();
});








Route::get('/users', [UserController::class, 'index']); // Összes felhasználó lekérése
Route::get('/users/{id}', [UserController::class, 'show']); // Egy felhasználó megjelenítése
Route::post('/users', [UserController::class, 'store']); // Új felhasználó létrehozása
Route::put('/users/{id}', [UserController::class, 'update']); // Felhasználó frissítése
Route::delete('/users/{id}', [UserController::class, 'destroy']); // Felhasználó törlése
Route::get('/users/admins', [UserController::class, 'getAdmins']); // Admin felhasználók lekérése

Route::get('/vasarlasok', [VasarlasFejController::class, 'index']); // Összes vásárlás fejléc lekérése
Route::get('/vasarlasok/{id}', [VasarlasFejController::class, 'show']); // Egy vásárlás fejléc lekérése
Route::post('/vasarlasok', [VasarlasFejController::class, 'store']); // Új vásárlás fejléc létrehozása
Route::put('/vasarlasok/{id}', [VasarlasFejController::class, 'update']); // Vásárlás fejléc frissítése
Route::delete('/vasarlasok/{id}', [VasarlasFejController::class, 'destroy']); // Vásárlás fejléc törlése

Route::get('/cimkek', [CimkeController::class, 'index']); // Összes címke lekérése
Route::get('/cimkek/{id}', [CimkeController::class, 'show']); // Egy adott címke lekérése
Route::post('/cimkek', [CimkeController::class, 'store']); // Új címke létrehozása
Route::put('/cimkek/{id}', [CimkeController::class, 'update']); // Címke frissítése
Route::delete('/cimkek/{id}', [CimkeController::class, 'destroy']); // Címke törlése

Route::get('/termekek', [TermekController::class, 'index']); // Összes termék lekérése
Route::get('/termekek/{id}', [TermekController::class, 'show']); // Egy adott termék lekérése
Route::post('/termekek', [TermekController::class, 'store']); // Új termék létrehozása
Route::put('/termekek/{id}', [TermekController::class, 'update']); // Termék frissítése
Route::delete('/termekek/{id}', [TermekController::class, 'destroy']); // Termék törlése

Route::get('/vasarlas_tetels', [VasarlasTetelController::class, 'index']); // Összes vásárlás tétel lekérése
Route::post('/vasarlas_tetels', [VasarlasTetelController::class, 'store']); // Új vásárlás tétel létrehozása
Route::delete('/vasarlas_tetels/{vasarlasId}/{termekId}', [VasarlasTetelController::class, 'destroy']); // Vásárlás tétel törlése a vásárlás és termék ID alapján

Route::get('/csomagbans', [CsomagbanController::class, 'index']); // Összes csomagban található termék lekérése
Route::get('/csomagbans/{id}', [CsomagbanController::class, 'show']); // Egy adott csomagban található termék lekérése
Route::post('/csomagbans', [CsomagbanController::class, 'store']); // Új csomagban lévő termék hozzáadása
Route::delete('/csomagbans/{id}', [CsomagbanController::class, 'destroy']); // Csomagban lévő termék eltávolítása

Route::get('/kapcsolos', [KapcsoloController::class, 'index']); // Összes termék-címke kapcsolat lekérése
Route::get('/kapcsolos/{id}', [KapcsoloController::class, 'show']); // Egy adott termék-címke kapcsolat lekérése
Route::post('/kapcsolos', [KapcsoloController::class, 'store']); // Új termék-címke kapcsolat létrehozása
Route::delete('/kapcsolos/{id}', [KapcsoloController::class, 'destroy']); // Termék-címke kapcsolat törlése
