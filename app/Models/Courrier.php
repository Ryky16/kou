<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Courrier extends Model
{
    use HasFactory; 

    // 🔹 Indiquer les champs qui peuvent être remplis en masse
    protected $fillable = [
        'reference', 
        'expediteur', 
        'destinataire', 
        'objet', 
        'contenu', 
        'type', 
        'statut', 
        'user_id'
    ];

    // 🔹 Définition des relations
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
