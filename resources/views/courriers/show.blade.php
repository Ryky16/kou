<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-10">
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8 relative">
            <!-- Badge Statut -->
            <span class="absolute top-6 right-6 px-3 py-1 rounded-full text-xs font-semibold
                {{ $courrier->statut === 'archivé' ? 'bg-gray-300 text-gray-700' : 'bg-green-100 text-green-700' }}">
                {{ ucfirst($courrier->statut) }}
            </span>

            <h2 class="text-3xl font-bold mb-2 text-green-700 flex items-center gap-2">
                <span>📄</span> Détail du courrier
            </h2>
            <p class="text-gray-500 mb-6">Consultez toutes les informations et pièces jointes de ce courrier.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <div class="mb-2">
                        <span class="font-semibold text-gray-700">Référence :</span>
                        <span class="ml-2 text-gray-900">{{ $courrier->reference }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="font-semibold text-gray-700">Objet :</span>
                        <span class="ml-2 text-gray-900">{{ $courrier->objet }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="font-semibold text-gray-700">Expéditeur :</span>
                        <span class="ml-2 text-gray-900">{{ $courrier->expediteur->name ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="font-semibold text-gray-700">Destinataire :</span>
                        <span class="ml-2 text-gray-900">
                            {{ $courrier->destinataire->name ?? $courrier->email_destinataire ?? 'N/A' }}
                        </span>
                    </div>
                </div>
                <div>
                    <div class="mb-2">
                        <span class="font-semibold text-gray-700">Date de réception :</span>
                        <span class="ml-2 text-gray-900">{{ $courrier->date_reception }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="font-semibold text-gray-700">Priorité :</span>
                        <span class="ml-2 font-bold
                            {{ $courrier->priorite === 'haute' ? 'text-red-600' : ($courrier->priorite === 'moyenne' ? 'text-yellow-600' : 'text-green-600') }}">
                            {{ ucfirst($courrier->priorite) }}
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="font-semibold text-gray-700">Statut :</span>
                        <span class="ml-2 text-gray-900">{{ ucfirst($courrier->statut) }}</span>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="font-semibold text-gray-700 mb-1 flex items-center gap-2">
                    <span>✍️</span> Description
                </h3>
                <div class="bg-gray-50 rounded p-4 text-gray-800 min-h-[60px]">
                    {{ $courrier->contenu ?? 'Aucune description.' }}
                </div>
            </div>

            <div class="mb-8">
                <h3 class="font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <span>📎</span> Pièces jointes
                </h3>
                @if($courrier->piecesJointes->isNotEmpty())
                    <ul class="space-y-2">
                        @foreach($courrier->piecesJointes as $piece)
                            <li class="flex items-center gap-3">
                                <span class="text-xl">{{ $piece->icone() }}</span>
                                <a href="{{ route('pieces-jointes.download', $piece) }}"
                                   class="text-blue-600 hover:underline font-medium"
                                   title="Télécharger ({{ round($piece->taille / 1024, 2) }} Ko)">
                                    {{ $piece->nom_original }}
                                </a>
                                <span class="text-xs text-gray-400">
                                    ({{ strtoupper(pathinfo($piece->nom_original, PATHINFO_EXTENSION)) }})
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-gray-500 italic">Aucune pièce jointe</span>
                @endif
            </div>

            <div class="flex flex-col md:flex-row gap-4 mt-8">
                <a href="{{ url()->previous() }}"
                   class="flex-1 inline-block px-5 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold text-center hover:bg-gray-300 transition">
                    ⬅ Retour
                </a>
                @if($courrier->statut !== 'archivé')
                <form action="{{ route('courriers.archive', $courrier->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="w-full px-5 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-2">
                        🗄️ Archiver ce courrier
                    </button>
                </form>
                @else
                <span class="flex-1 inline-block px-5 py-3 bg-gray-300 text-gray-600 rounded-lg font-semibold text-center cursor-not-allowed">
                    🗄️ Courrier déjà archivé
                </span>
                @endif
            </div>
        </div>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>
</x-app-layout>