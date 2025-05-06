<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8">
            <!-- Titre principal -->
            <h2 class="text-3xl font-bold text-center text-green-700 mb-6">
              <!-- Bouton Retour à gauche -->
              <a href="javascript:history.back()" 
                   class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                    ⬅️ Retour
                </a>
                    📤 Affecter un Courrier
            </h2>
            <p class="text-sm text-center text-gray-600 mb-6">
                Remplissez les informations ci-dessous pour affecter ce courrier à un destinataire.
            </p>

            <!-- Message de confirmation ou d'erreur -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Formulaire -->
            <form method="POST" action="{{ route('affectation.store') }}" class="space-y-6">
                @csrf

                <!-- Référence du courrier -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Référence du courrier :</label>
                    <div class="mt-1 text-gray-900 font-semibold bg-gray-100 px-4 py-2 rounded">
                        {{ $courrier->reference }}
                    </div>
                </div>

                <!-- Type de destinataire -->
                <div>
                    <label for="destinataire_type" class="block text-sm font-medium text-gray-700">Type de destinataire</label>
                    <select id="destinataire_type" name="destinataire_type" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                        <option value="">-- Sélectionnez un type --</option>
                        <option value="agent">Agent</option>
                        <option value="service">Service</option>
                        <option value="email">Adresse e-mail</option>
                    </select>
                </div>

                <!-- Liste des agents -->
                <div id="agent_field" style="display: none;">
                    <label for="destinataire_id_agent" class="block text-sm font-medium text-gray-700">Agent</label>
                    <select id="destinataire_id_agent" name="destinataire_id" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }} ({{ $agent->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Liste des services -->
                <div id="service_field" style="display: none;">
                    <label for="destinataire_id_service" class="block text-sm font-medium text-gray-700">Service</label>
                    <select id="destinataire_id_service" name="destinataire_id" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Adresse e-mail -->
                <div>
                    <label for="email_destinataire" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                    <input type="email" id="email_destinataire" name="email_destinataire" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500" 
                           placeholder="Ex : destinataire@gmail.com" required>
                </div>

                <!-- Observation -->
                <div>
                    <label for="observation" class="block text-sm font-medium text-gray-700">Observation (facultatif)</label>
                    <textarea id="observation" name="observation" rows="3" 
                              class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500" 
                              placeholder="Ajoutez une observation si nécessaire...">{{ old('observation') }}</textarea>
                </div>

                <!-- Bouton de soumission -->
                <div class="flex justify-center">
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                        ✅ Affecter
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/script.js') }}"></script>       
</x-app-layout>
