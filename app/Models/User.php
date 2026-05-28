<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'phone', 
        'address', // CORRIGÉ : 'address' avec deux 'd' et un 's' à la fin
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Gère automatiquement le hachage sécurisé si tu es sur Laravel 10/11
    ];

    /**
     * Relation : Un utilisateur peut avoir plusieurs réservations.
     */
    public function reservations()
    {
        return $this->hasMany(Table::class); 
    }
}