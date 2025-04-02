<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">📌 Affecter un Courrier</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
            <thead class="bg-gray-100">
                <tr class="border border-gray-200">
                    <th class="p-4">Référence</th>
                    <th class="p-4">Expéditeur</th>
                    <th class="p-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courriers as $courrier)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="p-4">{{ $courrier->reference }}</td>
                        <td class="p-4">{{ $courrier->expediteur }}</td>
                        <td class="p-4">
                            <form action="{{ route('affectation.affecter') }}" method="POST">
                                @csrf
                                <input type="hidden" name="courrier_id" value="{{ $courrier->id }}">
                                <select name="agent_id" class="border p-2 rounded">
                                    <option value="">Sélectionner un agent</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded">
                                    Affecter
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
