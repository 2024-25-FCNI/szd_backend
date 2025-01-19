<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VasarlasFej extends Model
{
    /** @use HasFactory<\Database\Factories\VasarlasFejFactory> */
    use HasFactory;
    protected $fillable = [
        'osszeg',
        'datum'
    ];

    /**
     * Kapcsolat a User modellel.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Kapcsolat a VasarlasTetel modellel.
     */
    public function vasarlasTetels()
    {
        return $this->hasMany(VasarlasTetel::class, 'vasarlas_id');
    }

    public static function vasarlasokEsTermekek()
    {
        return self::with('vasarlasTetel.termek')->get();
    }

    public static function felhasznaloVasarlasai($felhasznaloId)
    {
        return self::where('felhAzon', $felhasznaloId)->with('vasarlasTetel.termek')->get();
    }

    public static function vasarlasokDatumIntervallumban($kezdoDatum, $vegeDatum)
    {
        return self::whereBetween('datum', [$kezdoDatum, $vegeDatum])->get();
    }

    // Ez a metódus automatikusan meghívódik, amikor egy új vásárlás jön létre. 
    // Frissíti a kapcsolódó felhasználó összköltését a vásárlások alapján.
    protected static function boot()
    {
        parent::boot();

        static::created(function ($vasarlas) {
            $felhasznalo = $vasarlas->felhasznalo;
            $felhasznalo->osszes_koltese = $felhasznalo->vasarlasFej->sum('osszeg');
            $felhasznalo->save();
        });
    }
}

