<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Courrier extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'nature', // Ajout de la colonne "nature"
        'reference',
        'objet',
        'contenu',
        'date_reception',
        'expediteur_id', // Clé étrangère
        'destinataire_id', // Clé étrangère
        'statut',
        'priorite',
        'service_id', // Clé étrangère
        'created_by', // Clé étrangère
    ];

    protected $dates = [
        'date_reception',
        'created_at',
        'updated_at'
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

    public function affectation()
    {
        return $this->hasOne(Affectation::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function createur()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relation avec les documents
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}