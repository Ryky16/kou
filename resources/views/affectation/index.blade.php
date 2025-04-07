<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-200">
        <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-green-700 mb-6">📌 Ajouter un Courrier</h2>
            <p class="text-sm text-center text-gray-600 mb-6">Remplissez les informations pour ajouter un courrier</p>


            {{-- Formulaire pour ajouter un courrier --}}

            <form action="{{ route('courriers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf


                 <!-- date du courrier-->
                 <div class="mb-4">
    <label for="date_courrier" class="block text-gray-700 font-bold flex items-center">
        <span class="mr-2">📅</span> Date du courrier
    </label>
    <div class="relative">
        <input type="date" id="date_courrier" name="date_courrier"
            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
    </div>
</div>

                    <!-- Type -->
                    <div class="mb-4">
                    <label for="type" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">🔄</span> Type
                    </label>
                    <div class="relative">
                        <select id="type" name="type" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                            <option value="entrant">Entrant</option>
                            <option value="sortant">Sortant</option>
                        </select>
                    </div>
                </div>

                <!-- Référence -->
                <div class="mb-4">
                    <label for="reference_expediteur" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">🔖</span> Référence
                    </label>
                    <div class="relative">
                        <input type="text" id="reference_expediteur" name="reference_expediteur" required 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500" 
                            placeholder="Entrez la référence du courrier">
                    </div>
                </div>

                <!-- Expéditeur -->
                <div class="mb-4">
                    <label for="expediteur_id" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">👤</span> Expéditeur
                    </label>
                    <div class="relative">
                        <select id="expediteur_id" name="expediteur_id" required 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                            <option value="">Sélectionner un expéditeur</option>
                            @foreach ($expediteurs as $expediteur)
                                <option value="{{ $expediteur->id }}">{{ $expediteur->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Destinataire -->
                <div class="mb-4">
                    <label for="destinataire_id" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">📬</span> Destinataire
                    </label>
                    <div class="relative">
                        <select id="destinataire_id" name="destinataire_id" required 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                            <option value="">Sélectionner un destinataire</option>
                            @foreach ($destinataires as $destinataire)
                                <option value="{{ $destinataire->id }}">{{ $destinataire->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Objet -->
                <div class="mb-4">
                    <label for="objet" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">📝</span> Objet
                    </label>
                    <div class="relative">
                        <input type="text" id="objet" name="objet" required 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500" 
                            placeholder="Entrez l'objet du courrier">
                    </div>
                </div>

                <!-- Contenu -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">✍️</span> Contenu
                    </label>
                    <div class="relative">
                        <textarea id="description" name="description" rows="4" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500" 
                            placeholder="Entrez le contenu du courrier"></textarea>
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

                <!-- Priorité -->
                <div class="mb-4">
                    <label for="priorite" class="block text-gray-700 font-bold flex items-center">
                        <span class="mr-2">⚡</span> Priorité
                    </label>
                    <div class="relative">
                        <select id="priorite" name="priorite" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                            <option value="basse">Basse</option>
                            <option value="moyenne" selected>Moyenne</option>
                            <option value="haute">Haute</option>
                        </select>
                    </div>
                </div>

               
                <!-- Bouton d'envoi -->
            <button type="submit" 
                 class="w-full bg-black text-white py-3 rounded-lg font-semibold text-lg border-2 border-gray-700 hover:bg-gray-800 hover:border-gray-600 hover:scale-105 transition-transform duration-300">
                  📩 Envoyer le courrier
            </button>
            <script src="https://cdn.tailwindcss.com"></script>
            </form>
        </div>
    </div>
   
</x-app-layout>
