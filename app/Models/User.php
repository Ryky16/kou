<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Assurez-vous que cette colonne existe dans la table `users`
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relation avec le rôle
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

     // Méthode pour vérifier le rôle de l'utilisateur
     public function hasRole($role)
     {
         return $this->role->name === $role;
     }
}