
<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">
        <h1 class="text-2xl font-bold text-center text-gray-700 mb-8">📂 Archives des courriers</h1>
        <div class="bg-white rounded-lg shadow p-6">
            @if($courriers->isEmpty())
                <div class="text-gray-500 italic text-center">Aucun courrier archivé pour le moment.</div>
            @else
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 text-left">Référence</th>
                            <th class="p-3 text-left">Objet</th>
                            <th class="p-3 text-left">Expéditeur</th>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courriers as $courrier)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $courrier->reference }}</td>
                            <td class="p-3">{{ $courrier->objet }}</td>
                            <td class="p-3">{{ $courrier->expediteur->name ?? 'N/A' }}</td>
                            <td class="p-3">{{ $courrier->date_reception }}</td>
                            <td class="p-3">
                                <a href="{{ route('courriers.show', $courrier->id) }}" class="text-blue-600 hover:underline font-semibold">Voir</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <a href="{{ url()->previous() }}" class="inline-block mt-8 px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">⬅ Retour</a>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>
</x-app-layout>