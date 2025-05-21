<x-app-layout>
{{-- ... le reste de votre vue ... --}}

@if($courrier->piecesJointes->isNotEmpty())
<div class="mt-6">
    <h3 class="font-bold text-lg mb-2">📎 Pièces jointes</h3>
    <ul class="space-y-2">
        @foreach($courrier->piecesJointes as $piece)
        <li class="flex items-center">
            <span class="mr-2">{{ $piece->icone() }}</span>
            <a href="{{ route('pieces-jointes.download', $piece) }}" 
               class="text-blue-600 hover:underline"
               title="Télécharger ({{ round($piece->taille / 1024, 2) }} Ko) - {{ strtoupper(pathinfo($piece->nom_original, PATHINFO_EXTENSION)) }}">
               {{ $piece->nom_original }}
            </a>
        </li>
        @endforeach
    </ul>
</div>
@endif

{{-- ... le reste de votre vue ... --}}

<div class="max-w-3xl mx-auto bg-white rounded shadow p-8 mt-8">
        <h2 class="text-2xl font-bold mb-4 text-green-700">Détail du courrier</h2>
        <ul class="mb-4">
            <li><strong>Référence :</strong> {{ $courrier->reference }}</li>
            <li><strong>Objet :</strong> {{ $courrier->objet }}</li>
            <li><strong>Expéditeur :</strong> {{ $courrier->expediteur->name ?? 'N/A' }}</li>
            <li><strong>Destinataire :</strong> {{ $courrier->destinataire->name ?? $courrier->email_destinataire ?? 'N/A' }}</li>
            <li><strong>Date de réception :</strong> {{ $courrier->date_reception }}</li>
            <li><strong>Priorité :</strong> {{ ucfirst($courrier->priorite) }}</li>
            <li><strong>Statut :</strong> {{ ucfirst($courrier->statut) }}</li>
            <li><strong>Description :</strong> {{ $courrier->contenu }}</li>
        </ul>
        <div>
            <strong>Pièces jointes :</strong>
            @forelse($courrier->piecesJointes as $piece)
                <div>
                    <a href="{{ asset('storage/' . $piece->chemin) }}" target="_blank" class="text-blue-600 underline">
                        📎 {{ $piece->nom_original }}
                    </a>
                </div>
            @empty
                <span class="text-gray-500 italic">Aucune pièce jointe</span>
            @endforelse
        </div>
        <a href="{{ url()->previous() }}" class="inline-block mt-6 px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">⬅ Retour</a>
    </div>
<script src="https://cdn.tailwindcss.com"></script>
</x-app-layout>