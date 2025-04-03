<x-app-layout>
    <div class="container">
        <h2 class="text-2xl font-bold mb-4">📄 Liste des courriers</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Référence</th>
                    <th class="border px-4 py-2">Objet</th>
                    <th class="border px-4 py-2">Expéditeur</th>
                    <th class="border px-4 py-2">Statut</th>
                    <th class="border px-4 py-2">Pièces jointes</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courriers as $courrier)
                    <tr>
                        <td class="border px-4 py-2">{{ $courrier->reference_expediteur }}</td>
                        <td class="border px-4 py-2">{{ $courrier->objet }}</td>
                        <td class="border px-4 py-2">{{ $courrier->expediteur }}</td>
                        <td class="border px-4 py-2">
                            <span class="px-2 py-1 text-white rounded
                            {{ $courrier->statut == 'en_attente' ? 'bg-yellow-500' : 'bg-green-500' }}">
                                {{ ucfirst($courrier->statut) }}
                            </span>
                        </td>
                        <td class="border px-4 py-2">
                            @forelse($courrier->documents as $document)
                                <a href="{{ asset('storage/' . $document->file_path) }}" download class="text-blue-500 hover:underline">
                                    📥 {{ $document->file_name }}
                                </a><br>
                            @empty
                                <span class="text-gray-500 italic">Aucun document</span>
                            @endforelse
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('courriers.affecter', $courrier->id) }}" class="px-3 py-1 bg-blue-600 rounded">
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
</x-app-layout>
