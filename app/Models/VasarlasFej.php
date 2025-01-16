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
}
