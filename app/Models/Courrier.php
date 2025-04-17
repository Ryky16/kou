<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

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
         'email_destinataire',
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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($courrier) {
            // Supprime les fichiers physiques avant de supprimer le courrier
            foreach ($courrier->piecesJointes as $piece) {
                Storage::disk('public')->delete($piece->chemin);
                $piece->delete();
            }
        });
    }


    // Relations
    public function expediteur()
    {
        return $this->belongsTo(User::class, 'expediteur_id');
    }

    public function destinataire()
    {
        return $this->belongsTo(User::class, 'destinataire_id');
    }

    // Relation avec les documents
    public function piecesJointes()
    {
        return $this->hasMany(PieceJointe::class, 'courrier_id');
    }

    public function affectation()
    {
        return $this->hasOne(Affectation::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function createur()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}