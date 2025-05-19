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
        'reference',
        'expediteur_id',
        'destinataire_id',
        'service_id',
        'objet',
        'contenu',
        'type',
        'statut',
        'priorite',
        'date_reception',
        'created_by',
        'email_destinataire',
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

    // Relation avec l'expéditeur
    public function expediteur()
    {
        return $this->belongsTo(User::class, 'expediteur_id');
    }

    // Relation avec le destinataire
    public function destinataire()
    {
        return $this->belongsTo(User::class, 'destinataire_id');
    }

    // Relation avec les documents
    public function piecesJointes()
    {
        return $this->hasMany(\App\Models\PieceJointe::class);
    }

    public function affectation()
    {
        return $this->hasOne(Affectation::class);
    }

    // Relation avec le service
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function createur()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}

