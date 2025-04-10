<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PieceJointe extends Model
{
    protected $table = 'pieces_jointes'; // Spécifiez le nom de la table si différent
    
    protected $fillable = [
        'chemin',
        'nom_original',
        'mime_type',
        'taille',
        'courrier_id'
    ];

    protected $casts = [
        'taille' => 'integer'
    ];

    public function courrier(): BelongsTo
    {
        return $this->belongsTo(Courrier::class);
    }

    // Méthode utilitaire pour l'URL publique
    public function url()
    {
        return asset('storage/'.$this->chemin);
    }

    // Méthode pour l'icône selon le type
    public function icone()
    {
        return match($this->mime_type) {
            'application/pdf' => '📄',
            'image/' => '🖼️',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '📝',
            default => '📎'
        };
    }
}