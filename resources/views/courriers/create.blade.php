<x-app-layout>

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="flex items-center justify-center min-h-screen bg-gray-200">
        <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-green-700 mb-6">📌 Créer un Nouveau Courrier</h2>
            <p class="text-sm text-center text-gray-600 mb-6">Remplissez les informations pour créer un nouveau courrier</p>

            {{-- Formulaire pour créer un courrier --}}
            <form action="{{ route('courriers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Type de courrier -->
                <div class="mb-4">
                    <label for="type" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">🔄</span> Type de courrier
                    </label>
                    <div class="relative">
                        <select id="type" name="type" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                            <option value="entrant">Entrant</option>
                            <option value="sortant">Sortant</option>
                            <option value="interne">Interne</option>
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
                            <option value="Lettre Officielle">Lettre Officielle</option>
                            <option value="Note de service">Note de service</option>
                            <option value="Rapport">Rapport</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>

                <!-- Référence expéditeur -->
                <div class="mb-4">
                    <label for="reference" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">🔖</span> Référence expéditeur
                    </label>
                    <div class="relative">
                        <input type="text" id="reference" name="reference" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500" 
                            placeholder="Ex : REF-2025-001" required>
                    </div>
                </div>

                <!-- Objet -->
                <div class="mb-4">
                    <label for="objet" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">📝</span> Objet
                    </label>
                    <div class="relative">
                        <input type="text" id="objet" name="objet" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500" 
                            placeholder="Ex : Demande de documents" required>
                    </div>
                </div>

                <!-- Pièces jointes -->
                <div class="mb-4">
                    <label for="pieces_jointes" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">📎</span> Ajouter des pièces jointes
                    </label>
                    <div class="relative">
                        <input type="file" id="pieces_jointes" name="pieces_jointes[]" multiple 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                    </div>
                    <small class="text-gray-500">Formats acceptés : PDF, Word, Excel, Images</small>
                </div>

                <!-- Date réception -->
                <div class="mb-4">
                    <label for="date_reception" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">📅</span> Reçu le
                    </label>
                    <div class="relative">
                        <input type="date" id="date_reception" name="date_reception" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <!-- Expéditeur -->
                <div class="mb-4">
                    <label for="expediteur_id" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">👤</span> Expéditeur
                    </label>
                    <div class="relative">
                        <select id="expediteur_id" name="expediteur_id" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500" required>
                            <option value="">-- Sélectionnez un expéditeur --</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
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
                            placeholder="Décrivez brièvement le courrier..."></textarea>
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <button type="submit" 
                    class="w-full bg-green-600 py-3 rounded-lg font-semibold text-lg hover:bg-green-700 hover:scale-105 transition-transform duration-300">
                    ✅ Ajouter le courrier
                </button>
            </form>
            <script src="https://cdn.tailwindcss.com"></script>
        </div>
    </div>
</x-app-layout>
