<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Nom du rôle
    ];

    // Définition des constantes pour les rôles
    public const Administrateur = 'Administrateur';
    public const Secretaire_Municipal = 'Secretaire_Municipal';
    public const Agent = 'Agent';

   // Relation avec les utilisateurs
   public function users()
   {
       return $this->hasMany(User::class);
   }
}