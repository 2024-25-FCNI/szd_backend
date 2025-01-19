<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Termek extends Model
{
    /** @use HasFactory<\Database\Factories\TermekFactory> */
    use HasFactory;
    protected $fillable = [
        'cim',
        'leiras',
        'url',
        'hozzaferesi_ido',
        'ar',
        'jelzes',
        'kep'
    ];

    public function kapcsolos()
    {
        return $this->hasMany(Kapcsolo::class, 'termek_id');
    }

    /**
     * Kapcsolat a Csomagban modellel.
     */
    public function csomagok()
    {
        return $this->hasMany(Csomagban::class, 'termek_id');
    }

    public static function adottCimkesTermekek($cimkeNev)
    {
        return self::whereHas('cimke', function ($query) use ($cimkeNev) {
            $query->where('elnevezes', 'LIKE', "%$cimkeNev%");
        })->get();
    }

    public static function termekekHozzaferesiIdovel()
    {
        return self::orderBy('hozzaferesIdo', 'desc')->get();
    }

    public static function termekekEsCimkek()
    {
        return self::with('cimke')->get();
    }

    public static function csomagbanLevoTermekek($csomagId)
    {
        return DB::table('csomagban')
            ->join('termek', 'csomagban.termekAzon', '=', 'termek.termekAzon')
            ->where('csomagban.csomagAzon', $csomagId)
            ->select('termek.*')
            ->get();
    }

    public static function legdragabbTermekek($limit = 5)
    {
        return self::orderBy('ar', 'desc')->take($limit)->get();
    }

    // Ez a metódus minden termék mentése előtt ellenőrzi, hogy az ár nem lehet negatív.
    // Ha negatív érték kerülne mentésre, kivételt dob.
    public static function boot()
    {
        parent::boot();

        static::saving(function ($termek) {
            if ($termek->ar < 0) {
                throw new \Exception('A termék ára nem lehet negatív!');
            }
        });
    }
}
