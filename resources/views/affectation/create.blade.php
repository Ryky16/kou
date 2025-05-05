<x-app-layout>
    <div class="container mx-auto max-w-2xl px-4 py-8 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Affecter un courrier</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('affectation.store') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="courrier_id" value="{{ $courrier->id }}">

            <div>
                <label class="block text-sm font-medium text-gray-700">Référence du courrier :</label>
                <div class="mt-1 text-gray-900 font-semibold">{{ $courrier->reference }}</div>
            </div>

            <!-- Type de destinataire -->
            <div>
                <label for="destinataire_type" class="block text-sm font-medium text-gray-700">Type de destinataire</label>
                <select id="destinataire_type" name="destinataire_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-300">
                    <option value="">-- Sélectionnez un type --</option>
                    <option value="agent">Agent</option>
                    <option value="service">Service</option>
                    <option value="email">Adresse e-mail</option>
                </select>
            </div>

            <!-- Agents -->
            <div id="agent_field" style="display: none;">
                <label for="destinataire_id_agent" class="block text-sm font-medium text-gray-700">Agent</label>
                <select id="destinataire_id_agent" name="destinataire_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-300">
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}">{{ $agent->name }} ({{ $agent->email }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Services -->
            <div id="service_field" style="display: none;">
                <label for="destinataire_id_service" class="block text-sm font-medium text-gray-700">Service</label>
                <select id="destinataire_id_service" name="destinataire_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-300">
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Adresse e-mail -->
            <div id="email_field" style="display: none;">
                <label for="email_destinataire" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                <input type="email" id="email_destinataire" name="email_destinataire" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-300">
            </div>

            <!-- Observation -->
            <div>
                <label for="observation" class="block text-sm font-medium text-gray-700">Observation (facultatif)</label>
                <textarea id="observation" name="observation" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-green-300">{{ old('observation') }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Affecter
                </button>
            </div>
        </form>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="{{ asset('js/script.js') }}"></script>
    </div>

    <!--script>
        // Gestion dynamique des champs en fonction du type de destinataire
        document.getElementById('destinataire_type').addEventListener('change', function () {
            const type = this.value;
            document.getElementById('agent_field').style.display = type === 'agent' ? 'block' : 'none';
            document.getElementById('service_field').style.display = type === 'service' ? 'block' : 'none';
            document.getElementById('email_field').style.display = type === 'email' ? 'block' : 'none';
        });
    </script-->
</x-app-layout>
