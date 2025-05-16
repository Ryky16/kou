<?php

namespace App\Http\Controllers;

use App\Models\PieceJointe;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PieceJointeController extends Controller
{
    public function destroy(PieceJointe $pieceJointe)
    {
        // Supprimer le fichier physique
        if ($pieceJointe->chemin && Storage::disk('public')->exists($pieceJointe->chemin)) {
            Storage::disk('public')->delete($pieceJointe->chemin);
        }

        // Supprimer l'entrée en base
        $pieceJointe->delete();

        return back()->with('success', 'Pièce jointe supprimée avec succès.');
    }
}
