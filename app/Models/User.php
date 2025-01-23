<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->role === 0;
    }

    public function isRegularUser()
    {
        return $this->role === 1;
    }

    public static function felhasznalokVasarlasOsszeggel()
    {
        return self::withSum('vasarlasFej', 'osszeg')->get();
    }

    public static function felhasznalokSzerepSzerint($szerep)
    {
        return self::where('szerep', '=', $szerep)->get();
    }

    // Ez a metódus manuálisan meghívható a felhasználó összköltésének frissítésére.
    // Használata például akkor lehet szükséges, ha a vásárlásokhoz kapcsolódó adatokat módosítjuk.
    public function frissitOsszesKoltest()
    {
        $this->osszes_koltese = $this->vasarlasFej->sum('osszeg');
        $this->save();
    }
}
