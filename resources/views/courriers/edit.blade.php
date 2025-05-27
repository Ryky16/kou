<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-200">
        <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-green-700 mb-6">✏️ Modifier le courrier</h2>
            <p class="text-sm text-center text-gray-600 mb-6">Modifiez les informations du courrier ci-dessous</p>

            <!-- Affichage des erreurs -->
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Message de succès -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('courriers.update', $courrier->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Type de courrier -->
                <div class="mb-4">
                    <label for="type" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">🔄</span> Type de courrier
                    </label>
                    <div class="relative">
                        <select id="type" name="type" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                            <option value="entrant" {{ $courrier->type == 'entrant' ? 'selected' : '' }}>Entrant</option>
                            <option value="sortant" {{ $courrier->type == 'sortant' ? 'selected' : '' }}>Sortant</option>
                            <option value="interne" {{ $courrier->type == 'interne' ? 'selected' : '' }}>Interne</option>
                        </select>
                    </div>
                </div>

                <!-- Nature du courrier -->
                <div class="mb-4">
                    <label for="nature" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">🌿</span> Nature du courrier
                    </label>
                    <div class="relative">
                        <select id="nature" name="nature" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                            <option value="Lettre Officielle" {{ $courrier->nature == 'Lettre Officielle' ? 'selected' : '' }}>Lettre Officielle</option>
                            <option value="Note de service" {{ $courrier->nature == 'Note de service' ? 'selected' : '' }}>Note de service</option>
                            <option value="Rapport" {{ $courrier->nature == 'Rapport' ? 'selected' : '' }}>Rapport</option>
                            <option value="Autre" {{ $courrier->nature == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                    </div>
                </div>

                <!-- Référence expéditeur -->
                <div class="mb-4">
                    <label for="reference" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">🔖</span> Référence expéditeur
                    </label>
                    <div class="relative">
                        <input type="text" id="reference" name="reference" value="{{ $courrier->reference }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500" 
                            required>
                    </div>
                </div>

                <!-- Objet -->
                <div class="mb-4">
                    <label for="objet" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">📝</span> Objet
                    </label>
                    <div class="relative">
                        <input type="text" id="objet" name="objet" value="{{ $courrier->objet }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500" 
                            required>
                    </div>
                </div>

                <!-- Pièces jointes existantes -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">📎</span> Pièces jointes existantes
                    </label>
                    <div>
                        @forelse($courrier->piecesJointes as $piece)
                            <div class="flex items-center gap-2 mb-1">
                                <a href="{{ asset('storage/' . $piece->chemin) }}" target="_blank" class="text-blue-500 hover:underline">
                                    📥 {{ $piece->nom_original }}
                                </a>
                                <!-- Remplacer la pièce jointe -->
                                <form action="{{ route('pieces_jointes.update', $piece->id) }}" method="POST" enctype="multipart/form-data" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <!--input type="file" name="nouvelle_piece" required style="display:inline-block; width:180px;"-->
                                    <!--button type="submit" class="text-green-600 hover:underline text-xs">Remplacer</button-->
                                </form>
                                <!-- Supprimer la pièce jointe -->
                                <form action="{{ route('pieces_jointes.destroy', $piece->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs" onclick="return confirm('Supprimer cette pièce jointe ?')">Supprimer</button>
                                </form>
                            </div>
                        @empty
                            <span class="text-gray-500 italic">Aucune pièce jointe</span>
                        @endforelse
                    </div>
                </div>

                <!-- Ajouter de nouvelles pièces jointes -->
                <div class="mb-4">
                    <label for="pieces_jointes" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">📎</span> Ajouter des pièces jointes
                    </label>
                    <div class="relative">
                        <input type="file" id="pieces_jointes" name="pieces_jointes[]" multiple>
                    </div>
                    <small class="text-gray-500">Formats acceptés : PDF, Word, Excel, Images</small>
                </div>

                <!-- Date réception -->
                <div class="mb-4">
                    <label for="date_reception" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">📅</span> Date de réception
                    </label>
                    <div class="relative">
                        <input type="date" id="date_reception" name="date_reception" value="{{ $courrier->date_reception }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <!-- Priorité -->
                <div class="mb-4">
                    <label for="priorite" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">⚡</span> Priorité
                    </label>
                    <div class="relative">
                        <select id="priorite" name="priorite" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                            <option value="normal" {{ $courrier->priorite == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="important" {{ $courrier->priorite == 'important' ? 'selected' : '' }}>Important</option>
                            <option value="urgent" {{ $courrier->priorite == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">✍️</span> Description du courrier
                    </label>
                    <div class="relative">
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500"
                            required>{{ $courrier->contenu }}</textarea>
                    </div>
                </div>

                <!-- Bouton Enregistrer -->
                <button type="submit" 
                    class="w-full bg-green-600 py-3 rounded-lg font-semibold text-lg hover:bg-green-700 hover:scale-105 transition-transform duration-300">
                    ✅ Enregistrer les modifications
                </button>
            </form>
            <script src="https://cdn.tailwindcss.com"></script>
        </div>
    </div>
</x-app-layout>