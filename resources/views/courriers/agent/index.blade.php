<x-app-layout>
    <div class="max-w-7xl mx-auto my-10 px-4 sm:px-6 lg:px-8">

        <!-- Message de succès -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Bloc principal centré avec fond blanc -->
        <div class="bg-white p-6 rounded-xl shadow-md">

            <!-- Bloc en-tête principal du tableau -->
            <div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-4">

                <!-- Bouton Retour à gauche -->
                <a href="javascript:history.back()" 
                   class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                    ⬅️ Retour
                </a>

                <!-- Titre centré -->
                <h2 class="text-2xl md:text-3xl font-bold text-green-700 text-center flex-1">
                    📄 Liste des courriers
                </h2>

                <!-- Bouton Ajouter à droite -->
                <a href="{{ route('courriers.create') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition duration-300 text-sm whitespace-nowrap">
                    ➕ Ajouter un courrier
                </a>
            </div>

            <!-- Tableau des courriers -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="border px-4 py-2 text-left">Référence</th>
                            <th class="border px-4 py-2 text-left">Objet</th>
                            <th class="border px-4 py-2 text-left">Expéditeur</th>
                            <th class="border px-4 py-2 text-left">Destinataire</th>
                            <th class="border px-4 py-2 text-left">Statut</th>
                            <th class="border px-4 py-2 text-left">Pièces jointes</th>
                            <th class="border px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courriers as $courrier)
                            <tr class="hover:bg-gray-50">
                                <!-- Référence -->
                                <td class="border px-4 py-2">{{ $courrier->reference }}</td>

                                <!-- Objet -->
                                <td class="border px-4 py-2">{{ $courrier->objet }}</td>

                                <!-- Expéditeur -->
                                <td class="border px-4 py-2">{{ $courrier->expediteur->name ?? 'N/A' }}</td>

                                <!-- Destinataire -->
                                <td class="border px-4 py-2">
                                    {{ optional($courrier->destinataire)->name ?? 
                                       optional($courrier->service)->nom ?? 
                                       $courrier->email_destinataire ?? 
                                       'Non spécifié' }}
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
                                        <a href="{{ asset('storage/' . $piece->chemin) }}" 
                                           target="_blank" 
                                           class="text-blue-500 hover:underline block">
                                            📥 {{ $piece->nom_original }}
                                        </a>
                                    @empty
                                        <span class="text-gray-500 italic">Aucun document</span>
                                    @endforelse
                                </td>

                                <!-- Actions -->
                                <td class="border px-4 py-2">
                                    <!-- Bouton Envoyer -->
                                    <!--form action="{{ route('courriers.envoyer') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="courrier_id" value="{{ $courrier->id }}">
                                        <button type="submit" 
                                                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                                🔄 Envoyer
                                        </button>
                                    </form-->

                                    <!-- Bouton Modifier -->
                                    <a href="{{ route('courriers.edit', $courrier->id) }}" 
                                       class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                        ✏️ Modifier
                                    </a>

                                    <!-- Bouton Supprimer -->
                                    <form action="{{ route('courriers.destroy', $courrier->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce courrier ?')">
                                                🗑️ Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-500 italic py-4">
                                    📭 Aucun courrier trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <script src="https://cdn.tailwindcss.com"></script>
            </div>
        </div>
    </div>
</x-app-layout>
