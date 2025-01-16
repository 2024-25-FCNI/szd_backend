<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
