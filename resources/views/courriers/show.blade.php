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
               title="Télécharger ({{ round($piece->taille/1024) }} Ko) - {{ strtoupper(pathinfo($piece->nom_original, PATHINFO_EXTENSION)) }}">
               {{ $piece->nom_original }}
            </a>
        </li>
        @endforeach
    </ul>
</div>
@endif

{{-- ... le reste de votre vue ... --}}