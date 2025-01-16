<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kapcsolo extends Model
{
    /** @use HasFactory<\Database\Factories\KapcsoloFactory> */
    use HasFactory;

    protected $fillable = [
        'termek_id',
        'cimke_id',
        
    ];

    /**
     * Kapcsolat a Termek modellel.
     */
    public function termek()
    {
        return $this->belongsTo(Termek::class, 'termek_id');
    }

    /**
     * Kapcsolat a Cimke modellel.
     */
    public function cimke()
    {
        return $this->belongsTo(Cimke::class, 'cimke_id');
    }
}
