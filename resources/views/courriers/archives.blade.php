<x-app-layout>
    <div class="max-w-6xl mx-auto py-12 px-4">

        {{-- Bouton de retour en haut à gauche --}}
        <div class="mb-4">
            @php
                 $role = Auth::user()->role->name ?? '';

    $dashboardRoute = match($role) {
        'Agent' => route('agent.dashboard'),
        'Secretaire_Municipal' => route('secretaire.dashboard'),
        'Administrateur' => route('admin.dashboard'),
        default => route('dashboard'),
    };
            @endphp
            <a href="{{ $dashboardRoute }}"
   class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-800 rounded-xl shadow hover:bg-green-100 hover:text-green-700 transition font-semibold text-base">
    <span class="text-xl">⬅</span> Retour
</a>

        </div>

        {{-- Titre de la page --}}
        <h1 class="text-3xl font-extrabold text-center text-green-700 mb-8 flex items-center justify-center gap-2">
            <span class="text-4xl">📂</span>
            <span>Archives des courriers</span>
        </h1>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            @if($courriers->isEmpty())
                <div class="text-gray-400 italic text-center text-lg py-12">Aucun courrier archivé pour le moment.</div>
            @else
                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full table-fixed border border-gray-300 shadow-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-green-100 to-green-200 text-green-900 uppercase text-sm tracking-wider">
                                <th class="p-4 text-left border-r border-gray-300 w-1/4">Référence</th>
                                <th class="p-4 text-left border-r border-gray-300 w-1/4">Objet</th>
                                <th class="p-4 text-left border-r border-gray-300 w-1/4">Expéditeur</th>
                                <th class="p-4 text-left border-r border-gray-300 w-1/4">Destinataire</th>
                                <th class="p-4 text-left border-r border-gray-300 w-1/5">Pièces jointes</th>
                                <th class="p-4 text-left border-r border-gray-300 w-1/5">Date</th>
                                
                                <th class="p-4 text-left w-1/6">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courriers as $courrier)
                                <tr class="border-b hover:bg-green-50 transition duration-150 text-sm">
                                    <td class="p-4 border-r border-gray-200 font-mono font-bold text-green-700 break-words">{{ $courrier->reference }}</td>
                                    <td class="p-4 border-r border-gray-200 break-words">{{ $courrier->objet }}</td>
                                    <td class="p-4 border-r border-gray-200 break-words">{{ $courrier->expediteur->name ?? 'N/A' }}</td>
                                    <td class="p-4 border-r border-gray-200 break-words">
                                        @if($courrier->destinataire)
                                            {{ $courrier->destinataire->name }}
                                        @elseif($courrier->service)
                                            {{ $courrier->service->nom }}
                                        @elseif($courrier->email_destinataire)
                                            <span class="text-blue-700">{{ $courrier->email_destinataire }}</span>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>

                                 <!-- Pièces jointes -->
                              <td class="border px-4 py-2">
                                    @forelse($courrier->piecesJointes as $piece)
                                        <div class="flex items-center gap-2 mb-1">
                                            <a href="{{ asset('storage/' . $piece->chemin) }}" 
                                               target="_blank" 
                                               class="text-blue-500 hover:underline">
                                                📥 {{ $piece->nom_original }}
                                            </a>
                                            @php
                                                $url = asset('storage/' . $piece->chemin);
                                                $officePreview = 'https://view.officeapps.live.com/op/view.aspx?src=' . urlencode($url);
                                                $isOffice = in_array(strtolower(pathinfo($piece->nom_original, PATHINFO_EXTENSION)), ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']);
                                            @endphp
                                            @if($isOffice && app()->environment('production'))
                                                <a href="{{ $officePreview }}" target="_blank" class="text-green-600 hover:underline text-xs font-semibold">
                                                    👁️ Aperçu
                                                </a>
                                            @elseif(in_array(strtolower(pathinfo($piece->nom_original, PATHINFO_EXTENSION)), ['pdf']))
                                                <a href="{{ $url }}" target="_blank" class="text-green-600 hover:underline text-xs font-semibold">
                                                    👁️ Aperçu PDF
                                                </a>
                                            @endif
                                            @if($isOffice && !app()->environment('production'))
                                                <span class="text-yellow-600 text-xs">Aperçu Office Online disponible uniquement en ligne</span>
                                            @endif
                                        </div>
                                    @empty
                                        <span class="text-gray-500 italic">Aucun document</span>
                                    @endforelse
                                </td>

                                    <td class="p-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($courrier->date_reception)->format('d/m/Y') }}</td>
                                    <td class="p-4">
                                        <a href="{{ route('courriers.show', $courrier->id) }}"
                                           class="inline-block px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 hover:scale-105 transition font-semibold">
                                            👁️ Voir
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>
</x-app-layout>
