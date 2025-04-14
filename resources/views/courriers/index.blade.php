<x-app-layout>
    <div class="container mx-auto mt-8">
        <!-- En-tête : Titre, Bouton de retour et Bouton "Ajouter un courrier" -->
        <div class="flex justify-between items-center mb-6">
            <!-- Bouton de retour -->
            <a href="javascript:history.back()" 
               class="text-blue-600 hover:underline flex items-center">
                ⬅️ Retour
            </a>

            <!-- Titre centré -->
            <h1 class="text-3xl font-bold text-green-700 text-center flex-1">
                📄 Liste des courriers
            </h1>

            <!-- Bouton "Ajouter un courrier" -->
            <a href="{{ route('courriers.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition duration-300">
                ➕ Ajouter un courrier
            </a>
        </div>

        <!-- Message de succès -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tableau des courriers -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 shadow-lg rounded-lg">
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
                        <tr class="hover:bg-gray-100 transition duration-300">
                            <!-- Référence -->
                            <td class="border px-4 py-2">{{ $courrier->reference }}</td>

                            <!-- Objet -->
                            <td class="border px-4 py-2">{{ $courrier->objet }}</td>

                            <!-- Expéditeur -->
                            <td class="border px-4 py-2">{{ $courrier->expediteur->name ?? 'N/A' }}</td>

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
                                    <a href="{{ route('pieces-jointes.download', $piece) }}" 
                                       class="text-blue-500 hover:underline">
                                        📥 {{ $piece->nom_original }}
                                    </a><br>
                                @empty
                                    <span class="text-gray-500 italic">Aucun document</span>
                                @endforelse
                            </td>

                            <!-- Actions -->
                            <td class="border px-4 py-2">
                                <a href="{{ route('affectation.create', $courrier->id) }}" 
                                   class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-300">
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
    </div>
    <script src="https://cdn.tailwindcss.com"></script>
</x-app-layout>
