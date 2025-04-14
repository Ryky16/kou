<x-app-layout>
    <div class="container mx-auto mt-8 px-4">
        <!-- En-tête amélioré -->
        <div class="flex flex-col space-y-4 mb-8">
            <!-- Première ligne : Bouton de retour aligné à gauche -->
            <div class="w-full">
                <a href="javascript:history.back()" 
                   class="text-blue-600 hover:underline flex items-center">
                    ⬅️ Retour
                </a>
            </div>

            <!-- Deuxième ligne : Titre et bouton centrés -->
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <!-- Titre centré -->
                <h1 class="text-3xl font-bold text-green-700 md:text-center md:flex-1 order-1 md:order-2">
                    📄 Liste des courriers
                </h1>

                <!-- Bouton "Ajouter un courrier" aligné à droite -->
                <div class="md:ml-auto order-2 md:order-3">
                    <a href="{{ route('courriers.create') }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition duration-300 whitespace-nowrap">
                        ➕ Ajouter un courrier
                    </a>
                </div>
            </div>
        </div>

        <!-- Message de succès -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tableau des courriers -->
        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table class="w-full border-collapse">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2 text-left">Référence</th>
                        <th class="border px-4 py-2 text-left">Objet</th>
                        <th class="border px-4 py-2 text-left">Expéditeur</th>
                        <th class="border px-4 py-2 text-left">Statut</th>
                        <th class="border px-4 py-2 text-left">Pièces jointes</th>
                        <th class="border px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courriers as $courrier)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <!-- Référence -->
                            <td class="border px-4 py-2">{{ $courrier->reference }}</td>

                            <!-- Objet -->
                            <td class="border px-4 py-2">{{ $courrier->objet }}</td>

                            <!-- Expéditeur -->
                            <td class="border px-4 py-2">{{ $courrier->expediteur->name ?? 'N/A' }}</td>

                            <!-- Statut -->
                            <td class="border px-4 py-2">
                                <span class="px-2 py-1 text-white rounded text-sm
                                {{ $courrier->statut == 'brouillon' ? 'bg-yellow-500' : ($courrier->statut == 'envoyé' ? 'bg-blue-500' : 'bg-green-500') }}">
                                    {{ ucfirst($courrier->statut) }}
                                </span>
                            </td>

                            <!-- Pièces jointes -->
                            <td class="border px-4 py-2">
                                @forelse($courrier->piecesJointes as $piece)
                                    <a href="{{ route('pieces-jointes.download', $piece) }}" 
                                       class="text-blue-500 hover:underline flex items-center">
                                        <span class="mr-1">📥</span> {{ $piece->nom_original }}
                                    </a>
                                @empty
                                    <span class="text-gray-500 italic">Aucun document</span>
                                @endforelse
                            </td>

                            <!-- Actions -->
                            <td class="border px-4 py-2">
                                <a href="{{ route('affectation.create', $courrier->id) }}" 
                                   class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-300 inline-flex items-center">
                                    <span class="mr-1">🔄</span> Affecter
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
            <script src="https://cdn.tailwindcss.com"></script>
        </div>
    </div>
</x-app-layout>