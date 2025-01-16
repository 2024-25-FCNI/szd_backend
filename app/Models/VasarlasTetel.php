<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VasarlasTetel extends Model
{
    /** @use HasFactory<\Database\Factories\VasarlasTetelFactory> */
    use HasFactory;

    protected $fillable = [
        'vasarlas_id',
        'termek_id',
        
    ];

    /**
     * Kapcsolat a VasarlasFej modellel.
     */
    public function vasarlasFej()
    {
        return $this->belongsTo(VasarlasFej::class, 'vasarlas_id');
    }

    /**
     * Kapcsolat a Termek modellel.
     */
    public function termek()
    {
        return $this->belongsTo(Termek::class, 'termek_id');
    }
}
