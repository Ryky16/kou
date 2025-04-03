<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-4xl font-bold text-green-700 text-center mb-8">
                📌 Affecter un Courrier
            </h2>

            {{-- Formulaire pour affecter un courrier --}}
            <form action="{{ route('courriers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Référence du courrier --}}
                <div class="flex flex-col">
                    <label for="reference_expediteur" class="text-green-700 font-medium mb-2">
                        <i class="fas fa-hashtag"></i> Référence :
                    </label>
                    <input type="text" name="reference_expediteur" id="reference_expediteur" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                        placeholder="Entrez la référence du courrier" required>
                </div>

                {{-- Expéditeur --}}
                <div class="flex flex-col">
                    <label for="expediteur_id" class="text-green-700 font-medium mb-2">
                        <i class="fas fa-user"></i> Expéditeur :
                    </label>
                    <select name="expediteur_id" id="expediteur_id" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
                        <option value="">Sélectionner un expéditeur</option>
                        @foreach ($expediteurs as $expediteur)
                            <option value="{{ $expediteur->id }}">{{ $expediteur->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Destinataire --}}
                <div class="flex flex-col">
                    <label for="destinataire_id" class="text-green-700 font-medium mb-2">
                        <i class="fas fa-user-check"></i> Destinataire :
                    </label>
                    <select name="destinataire_id" id="destinataire_id" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
                        <option value="">Sélectionner un destinataire</option>
                        @foreach ($destinataires as $destinataire)
                            <option value="{{ $destinataire->id }}">{{ $destinataire->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Objet du courrier --}}
                <div class="flex flex-col">
                    <label for="objet" class="text-green-700 font-medium mb-2">
                        <i class="fas fa-file-alt"></i> Objet :
                    </label>
                    <input type="text" name="objet" id="objet" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                        placeholder="Entrez l'objet du courrier" required>
                </div>

                {{-- Type de courrier --}}
                <div class="flex flex-col">
                    <label for="type" class="text-green-700 font-medium mb-2">
                        <i class="fas fa-exchange-alt"></i> Type :
                    </label>
                    <select name="type" id="type" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        <option value="entrant">Entrant</option>
                        <option value="sortant">Sortant</option>
                    </select>
                </div>

                {{-- Contenu --}}
                <div class="flex flex-col">
                    <label for="description" class="text-green-700 font-medium mb-2">
                        <i class="fas fa-align-left"></i> Contenu :
                    </label>
                    <textarea name="description" id="description" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                        rows="4" placeholder="Entrez le contenu du courrier"></textarea>
                </div>

                {{-- Pièces jointes --}}
                <div class="flex flex-col">
                    <label for="pieces_jointes" class="text-green-700 font-medium mb-2">
                        <i class="fas fa-paperclip"></i> Ajouter des pièces jointes :
                    </label>
                    <input type="file" name="pieces_jointes[]" id="pieces_jointes" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                        multiple>
                    <small class="text-gray-500">Formats acceptés : PDF, Word, Excel, Images</small>
                </div>

                {{-- Priorité --}}
                <div class="flex flex-col">
                    <label for="priorite" class="text-green-700 font-medium mb-2">
                        <i class="fas fa-exclamation-circle"></i> Priorité :
                    </label>
                    <select name="priorite" id="priorite" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        <option value="basse">Basse</option>
                        <option value="normale" selected>Normale</option>
                        <option value="élevée">Élevée</option>
                    </select>
                </div>

                {{-- Bouton d'envoi --}}
                <button type="submit" 
                    class="w-full bg-green-600 font-semibold rounded-lg px-4 py-2 hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    📩 Envoyer le courrier
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
