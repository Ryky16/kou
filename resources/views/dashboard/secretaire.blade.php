<x-app-layout>
    <div class="flex min-h-screen bg-white" x-data="{ sidebarOpen: true, showTable: true }">
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'block' : 'hidden'" class="w-64 text-white shadow-md p-4 flex flex-col h-full min-h-screen">
            <div class="flex flex-col">
                <h1 class="text-xl font-bold flex items-center justify-center mb-4">
                    <span class="mr-2">📂</span> Menu Secrétaire
                </h1>

                <hr class="border-gray-300 dark:border-gray-600 mb-4">

                <nav class="flex-1 space-y-4">
                    <ul class="space-y-2">
                    <li>
                            <a href="{{ route('courriers.create') }}" class="sidebar-link">📌 Ajouter un Courrier</a>
                        </li>

                        <li>
                            <a href="#" class="sidebar-link" @click.prevent="showTable = !showTable">
                                📁 Gérer les Courriers
                            </a>
                        </li>
                        
                        <li><a href="{{ route('courriers.archives') }}" class="sidebar-link">📂 Consulter les Archives</a></li>
                        <li><a href="{{ route('statistiques.index') }}" class="sidebar-link">📊 Statistiques</a></li>
                        <li>
                            <a href="#" class="sidebar-link flex items-center justify-between">
                                🔔 Notifications
                                <span class="bg-red-500 rounded-full px-2 py-1 text-white text-xs">
                                    {{ $notifications->count() }}
                                </span>
                            </a>
                        </li>
                        <!--li><a href="#" class="sidebar-link">⚙️ Paramètres</a></li-->
                    </ul>
                </nav>
            </div>

            <div class="text-center pb-5 sidebar-footer mt-auto">
                <p class="text-sm">Mairie Ziguinchor<br> © 2025</p>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Bouton ouvrir/fermer menu -->
            <button 
                @click="sidebarOpen = !sidebarOpen" 
                class="mb-4 px-4 py-2 bg-white text-green-800 font-semibold rounded-md border-2 border-green-700 hover:bg-green-700 hover:text-white transition duration-200"
            >
                <span x-show="!sidebarOpen">📂 Ouvrir le Menu</span>
                <span x-show="sidebarOpen">❌ Fermer le Menu</span>
            </button>

            <h1 class="text-2xl font-bold text-center text-gray-700 mb-6">
                Tableau de Bord Secrétaire Municipal
            </h1>

            <!-- Moteur de recherche -->
            <div class="mb-6">
                <form method="GET" action="{{ route('secretaire.dashboard') }}" class="mb-6 flex">
                    <input type="text" name="q" value="{{ request('q') }}"
                        class="w-full p-3 rounded-l-md shadow-sm border border-gray-300 focus:outline-none"
                        placeholder="🔍 Rechercher un courrier par référence, expéditeur, date, destinataire...">
                    <button type="submit"
                        class="px-5 bg-blue-600 text-white font-semibold rounded-r-md hover:bg-blue-700 transition flex items-center">
                        🔍
                    </button>
                </form>
            </div>

            <!-- Statistiques principales -->
            <div class="flex justify-between gap-6 mb-12">
                <div class="stat-card bg-green-100 border-l-4 border-green-500 p-4 rounded shadow w-full text-center">
                    <h2 class="font-semibold text-gray-700">📥 Courriers Ajoutés</h2>
                    <p class="text-xl font-bold text-blue-700">{{ $totalCourriers }}</p>
                </div>
                <div class="stat-card bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded shadow w-full text-center">
                    <h2 class="font-semibold text-gray-700">📌 Courriers Affectés</h2>
                     <p class="text-xl font-bold text-yellow-700">{{ $courriersAffectes }}</p>
                </div>
                <div class="stat-card bg-red-100 border-l-4 border-red-500 p-4 rounded shadow w-full text-center">
                    <h2 class="font-semibold text-gray-700">⏳ En Attente</h2>
                    <p class="text-xl font-bold text-red-700">{{ $courriersEnAttente }}</p>
                </div>
            </div>

            <!-- Titre du tableau -->
            <h2 class="text-xl text-center font-semibold text-gray-700 mb-4">📋 Suivi des Courriers</h2>

            <!-- Tableau -->
            <table 
                class="w-full bg-white shadow-md rounded-lg overflow-hidden border border-gray-200"
                x-show="showTable"
                x-transition
            >
                <thead class="bg-gray-100">
                    <tr class="border border-gray-200">
                        <th class="p-4 text-left border border-gray-200">Référence</th>
                        <th class="p-4 text-left border border-gray-200">Expéditeur</th>
                        <th class="p-4 text-left border border-gray-200">Destinataire</th>
                        <th class="p-4 text-left border border-gray-200">Statut</th>
                        <th class="p-4 text-left border border-gray-200">Priorité</th>
                        <th class="p-4 text-left border border-gray-200">Pièces jointes</th>
                        <th class="p-4 text-left border border-gray-200">Actions</th>
                    </tr>
                </thead>
                @php
    $statutLabels = [
        'brouillon' => ['label' => "📝 En attente d'affectation", 'class' => 'text-yellow-600'],
        'envoyé'    => ['label' => '✔ Affecté', 'class' => 'text-green-600'],
        'archivé'   => ['label' => '🗄️ Archivé', 'class' => 'text-gray-500'],
    ];
    $prioriteLabels = [
        'normal'  => ['label' => '🟢 Normal', 'class' => 'text-green-500 font-bold'],
        'important'=> ['label' => '🟡 Important', 'class' => 'text-yellow-500 font-bold'],
        'urgent'   => ['label' => '🔴 Urgent', 'class' => 'text-red-500 font-bold'],
    ];
@endphp

<tbody>
@forelse ($courriers as $courrier)
    <tr class="border-b border-gray-200 hover:bg-gray-50">
        <td class="p-4 border border-gray-200">{{ $courrier->reference }}</td>
        <td class="p-4 border border-gray-200">{{ $courrier->expediteur->name ?? 'N/A' }}</td>
        <td class="p-4 border border-gray-200">
            @if($courrier->destinataire)
                {{ $courrier->destinataire->name }}
            @elseif($courrier->service)
                {{ $courrier->service->nom }}
            @elseif($courrier->email_destinataire)
                {{ $courrier->email_destinataire }}
            @else
                N/A
            @endif
        </td>
        <!-- Statut -->
        <td class="p-4 font-semibold {{ $statutLabels[$courrier->statut]['class'] ?? '' }}">
            {{ $statutLabels[$courrier->statut]['label'] ?? ucfirst($courrier->statut) }}
        </td>
        <!-- Priorité -->
        <td class="p-4 {{ $prioriteLabels[$courrier->priorite]['class'] ?? '' }}">
            {{ $prioriteLabels[$courrier->priorite]['label'] ?? ucfirst($courrier->priorite) }}
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
            
        <!-- Actions -->

        <td class="border px-4 py-2">
                @if(Auth::user()->hasRole('Secretaire_Municipal') && $courrier->statut == 'brouillon')
        <button
    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
    onclick="openAffectationModal('{{ $courrier->id }}', '{{ addslashes($courrier->reference) }}')">
    📤 Affecter
</button>
                @else
                    <button class="px-3 py-1 bg-gray-300 text-gray-700 rounded cursor-not-allowed">
                        Affectation terminée
                    </button>
                @endif
            </td>

        <!--td class="p-4 border-r border-gray-200">
            @if($courrier->statut == 'En attente')
                <a href="{{ route('affectation.create', $courrier->id) }}" 
                   class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200">
                   ➕ Affecter
                </a>
            @else
                <button class="px-3 py-1 bg-gray-300 text-gray-700 rounded cursor-not-allowed">
                    Affectation terminée
                </button>
            @endif
        </td-->
    </tr>
@empty
    <!--tr>
        <td colspan="6" class="text-center text-gray-500 p-4 italic">
            📭 Aucun courrier trouvé.
        </td>
    </tr-->
@endforelse

       <!-- Modal global à la fin de la vue -->
<div id="affectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h3 class="text-2xl font-bold text-green-600 mb-4">📤 Affecter un courrier</h3>
        <form id="affectForm" method="POST" action="{{ route('affectation.store') }}">
    @csrf
    <input type="hidden" name="courrier_id" id="courrier_id">

            <div class="mb-4">
                <label class="block font-semibold mb-1">Référence</label>
                <div id="courrier_reference" class="bg-gray-100 p-2 rounded"></div>
            </div>

            <!-- Destinataire -->
            <div class="mb-4">
                <label for="destinataire_id" class="block text-gray-700 font-bold flex items-center">
                    <span class="mr-2">📤</span> Destinataire
                </label>
                <div class="relative">
                    <select id="destinataire_id" name="destinataire_id"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500" required>
                        <option value="">-- Sélectionnez un destinataire --</option>
                        <optgroup label="Agents">
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" data-email="{{ $agent->email }}">{{ $agent->name }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Services">
                            @foreach($services as $service)
                                <option value="service_{{ $service->id }}" data-email="{{ $service->email }}">{{ $service->nom }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Externe">
                            <option value="autre">Partenaires</option>
                        </optgroup>
                    </select>
                </div>
            </div>

            <!-- Email du destinataire -->
            <div class="mb-4 hidden" id="email-destinataire">
                <label for="email_destinataire" class="block text-gray-700 font-bold flex items-center">
                    <span class="mr-2">📧</span> Email du destinataire
                </label>
                <div class="relative">
                    <input type="email" id="email_destinataire" name="email_destinataire"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500"
                        placeholder="Ex : destinataire@gmail.com">
                </div>
            </div>

            <div class="mb-4">
                <label for="observation" class="block font-semibold mb-1">Observation</label>
                <textarea name="observation" id="observation" rows="3"
                          class="w-full border rounded p-2"
                          placeholder="Ajoutez une observation (facultatif)"></textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 bg-gray-300 rounded" onclick="closeAffectationModal()">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Envoyer 📩</button>
            </div>
        </form>
    </div>
</div>


            </table>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $courriers->links('pagination::bootstrap-4') }}
            </div>

            <!-- Message de succès -->
            @if(session('success'))
                <div class="mt-4 bg-green-100 border border-green-500 text-green-700 p-3 rounded text-center">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Notifications -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-700 mb-2 flex items-center">
                    <span class="mr-2">🔔</span> Notifications
                    @if($notifications->count())
                        <span class="ml-2 bg-red-500 text-white rounded-full px-2 py-1 text-xs">{{ $notifications->count() }}</span>
                    @endif
                </h2>
                @if($notifications->count())
                    <ul class="space-y-2">
                        @foreach($notifications as $notification)
                            <li class="bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded flex justify-between items-center">
                                <div>
                                    <span class="font-semibold">Nouveau courrier :</span>
                                    <span class="text-blue-700">{{ $notification->data['reference'] }}</span> - 
                                    <span>{{ $notification->data['objet'] }}</span>
                                    <span class="text-gray-500 text-xs ml-2">({{ $notification->data['created_at'] }})</span>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('courriers.show', ['courrier' => $notification->data['courrier_id'] ?? $notification->data['id']]) }}" class="text-green-600 hover:underline text-xs px-2 py-1 border border-green-600 rounded">
                                        Ouvrir le courrier
                                    </a>
                                    <form action="{{ route('secretaire.notifications.delete', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline text-xs px-2 py-1 border border-red-600 rounded" type="submit">
                                            Supprimer la notification
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-gray-500 italic">Aucune notification.</div>
                @endif
            </div>
        </main>
        <script src="{{ asset('js/script.js') }}"></script>
        <script src="https://cdn.tailwindcss.com"></script>
    </div>
</x-app-layout>
