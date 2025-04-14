<x-app-layout>
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4">📄 Liste des courriers</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Référence</th>
                    <th class="border px-4 py-2">Objet</th>
                    <th class="border px-4 py-2">Expéditeur</th>
                    <th class="border px-4 py-2">Statut</th>
                    <th class="border px-4 py-2">Pièces jointes</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courriers as $courrier)
                    <tr>
                        <!-- Référence -->
                        <td class="border px-4 py-2">{{ $courrier->reference }}</td>

                        <!-- Objet -->
                        <td class="border px-4 py-2">{{ $courrier->objet }}</td>

                        <!-- Expéditeur -->
                        <td class="border px-4 py-2">
                            {{ $courrier->expediteur->name ?? 'N/A' }}
                        </td>

                        <!-- Statut -->
                        <td class="border px-4 py-2">
                            <span class="px-2 py-1 text-white rounded
                            {{ $courrier->statut == 'brouillon' ? 'bg-yellow-500' : ($courrier->statut == 'envoyé' ? 'bg-blue-500' : 'bg-green-500') }}">
                                {{ ucfirst($courrier->statut) }}
                            </span>
                        </td>

                        <!-- Pièces jointes -->
                        <td class="border px-4 py-2">
                            @forelse($courrier->piecesJointes as $piece)
                                <a href="{{ route('pieces-jointes.download', $piece) }}" class="text-blue-500 hover:underline">
                                    📥 {{ $piece->nom_original }}
                                </a><br>
                            @empty
                                <span class="text-gray-500 italic">Aucun document</span>
                            @endforelse
                        </td>

                        <!-- Actions -->
                        <td class="border px-4 py-2">
                            <a href="{{ route('affectation.create', $courrier->id) }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                🔄 Affecter
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 italic py-4">
                            📭 Aucun courrier trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
