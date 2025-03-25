<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Créer un nouveau courrier</h2>

                <form action="{{ route('courriers.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
                    @csrf

                    <!-- Type de courrier -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Type de courrier :</label>
                        <select name="type" class="w-full p-2 border rounded">
                            <option value="Lettre Officielle">Lettre Officielle</option>
                            <option value="Note de service">Note de service</option>
                            <option value="Rapport">Rapport</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>

                    <!-- Référence expéditeur -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Référence expéditeur :</label>
                        <input type="text" name="reference_expediteur" class="w-full p-2 border rounded">
                    </div>

                    <!-- Objet -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Objet :</label>
                        <input type="text" name="objet" class="w-full p-2 border rounded">
                    </div>

                    <!-- Ajout des pièces jointes -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Ajouter des pièces jointes :</label>
                        <input type="file" name="pieces_jointes[]" multiple class="w-full p-2 border rounded">
                    </div>

                    <!-- Date réception -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Reçu le :</label>
                        <input type="date" name="date_reception" class="w-full p-2 border rounded">
                    </div>

                    <!-- Expéditeur/Destinataire -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Expéditeur/Destinataire :</label>
                        <input type="text" name="expediteur" class="w-full p-2 border rounded">
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Description du courrier :</label>
                        <textarea name="description" class="w-full p-2 border rounded" rows="5"></textarea>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="mt-6">
                        <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                            ✅ Ajouter le courrier
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
