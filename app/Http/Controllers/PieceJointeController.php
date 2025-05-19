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

    public function update(Request $request, \App\Models\PieceJointe $pieceJointe)
    {
        $request->validate([
            'nouvelle_piece' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
        ]);

        // Supprimer l'ancien fichier
        if ($pieceJointe->chemin && Storage::disk('public')->exists($pieceJointe->chemin)) {
            Storage::disk('public')->delete($pieceJointe->chemin);
        }

        // Stocker le nouveau fichier
        $file = $request->file('nouvelle_piece');
        $chemin = $file->store('pieces_jointes', 'public');

        // Mettre à jour la pièce jointe
        $pieceJointe->update([
            'nom_original' => $file->getClientOriginalName(),
            'chemin' => $chemin,
            'mime_type' => $file->getClientMimeType(),
            'taille' => $file->getSize(),
        ]);

        return back()->with('success', 'Pièce jointe remplacée avec succès.');
    }
}
