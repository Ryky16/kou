<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Courrier extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'expediteur_id', // Clé étrangère
        'destinataire_id', // Clé étrangère
        'service_id', // Clé étrangère
        'created_by', // Clé étrangère
        'objet',
        'contenu',
        'type',
        'statut',
        'priorite',
        'date_reception'
    ];

    // Relations
    public function expediteur()
    {
        return $this->belongsTo(User::class, 'expediteur_id');
    }

    public function destinataire()
    {
        return $this->belongsTo(User::class, 'destinataire_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function createur()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}