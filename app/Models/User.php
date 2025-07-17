<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // ... properti lain

    /**
     * User memiliki satu profil Pelaksana.
     */
    public function pelaksana(): HasOne
    {
        return $this->hasOne(Pelaksana::class);
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // <-- Jangan lupa tambahkan 'role' juga
    ];
}
