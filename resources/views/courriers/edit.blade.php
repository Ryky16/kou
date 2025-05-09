<x-app-layout>
    <div class="max-w-7xl mx-auto my-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold text-green-700 mb-6">✏️ Modifier le courrier</h2>

            <!-- Formulaire de modification -->
            <form action="{{ route('courriers.update', $courrier->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Type -->
                <div class="mb-4">
                    <label for="type" class="block text-gray-700 font-bold">Type</label>
                    <select id="type" name="type" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                        <option value="entrant" {{ $courrier->type == 'entrant' ? 'selected' : '' }}>Entrant</option>
                        <option value="sortant" {{ $courrier->type == 'sortant' ? 'selected' : '' }}>Sortant</option>
                        <option value="interne" {{ $courrier->type == 'interne' ? 'selected' : '' }}>Interne</option>
                    </select>
                </div>

                <!-- Objet -->
                <div class="mb-4">
                    <label for="objet" class="block text-gray-700 font-bold">Objet</label>
                    <input type="text" id="objet" name="objet" value="{{ $courrier->objet }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500" required>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold">Description</label>
                    <textarea id="description" name="description" rows="4" 
                              class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">{{ $courrier->contenu }}</textarea>
                </div>

                <!-- Date de réception -->
                <div class="mb-4">
                    <label for="date_reception" class="block text-gray-700 font-bold">Date de réception</label>
                    <input type="date" id="date_reception" name="date_reception" value="{{ $courrier->date_reception }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Priorité -->
                <div class="mb-4">
                    <label for="priorite" class="block text-gray-700 font-bold">Priorité</label>
                    <select id="priorite" name="priorite" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                        <option value="basse" {{ $courrier->priorite == 'basse' ? 'selected' : '' }}>Basse</option>
                        <option value="moyenne" {{ $courrier->priorite == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="haute" {{ $courrier->priorite == 'haute' ? 'selected' : '' }}>Haute</option>
                    </select>
                </div>

                <!-- Bouton Enregistrer -->
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    ✅ Enregistrer les modifications
                </button>
            </form>
            <script src="https://cdn.tailwindcss.com"></script>
        </div>
    </div>
</x-app-layout>