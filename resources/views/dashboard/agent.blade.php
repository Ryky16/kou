<x-app-layout>
    <div class="flex min-h-screen bg-white" x-data="{ sidebarOpen: true, showTable: true }">
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'block' : 'hidden'" class="w-64 text-white shadow-md p-4 flex flex-col h-full min-h-screen">
            <div class="flex flex-col">
                <h1 class="text-xl font-bold flex items-center justify-center mb-4">
                    <span class="mr-2">📂</span> Menu Agent
                </h1>

                <hr class="border-gray-300 dark:border-gray-600 mb-4">

                <nav class="flex-1 space-y-4">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('courriers.index') }}" class="sidebar-link">📌 Ajouter un Courriers</a>
                        </li>
                        <li>
                            <a href="#" class="sidebar-link" @click.prevent="showTable = !showTable">
                                📁 Gérer les Courriers
                            </a>
                        </li>
                        <li><a href="#" class="sidebar-link">📂 Consulter les Archives</a></li>
                        <li><a href="#" class="sidebar-link">📊 Statistiques</a></li>
                        <li>
                            <a href="#" class="sidebar-link flex items-center justify-between">      
                                🔔 Notifications
                                <span class="bg-red-500 rounded-full px-2 py-1 text-white text-xs">
    {{ $notifications->count() }}
</span>
                                <!--span class="bg-red-500 rounded-full px-2 py-1 text-white text-xs">3</span-->
                            </a>
                        </li>
                        <li><a href="#" class="sidebar-link">⚙️ Paramètres</a></li>
                    </ul>
                </nav>
            </div>

            <div class="text-center pb-5 sidebar-footer mt-auto">
                <p class="text-sm text-gray-300">© 2025 Mairie Ziguinchor</p>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Bouton ouvrir/fermer menu -->
            <button 
                @click="sidebarOpen = !sidebarOpen" 
                class="mb-4 px-4 py-2 bg-white text-blue-800 font-semibold rounded-md border-2 border-blue-700 hover:bg-blue-700 hover:text-white transition duration-200"
            >
                <span x-show="!sidebarOpen">📂 Ouvrir le Menu</span>
                <span x-show="sidebarOpen">❌ Fermer le Menu</span>
            </button>

            <h1 class="text-2xl font-bold text-center text-gray-700 mb-6">
                Tableau de Bord Agent Municipal
            </h1>

            <!-- Moteur de recherche -->
            <div class="mb-6">
                <input type="text" class="w-full p-3 rounded-md shadow-sm border border-gray-300" 
                    placeholder="🔍 Rechercher un courrier par référence, expéditeur, date...">
            </div>

            <!-- Statistiques principales -->
            <div class="flex justify-between gap-6 mb-12">
                <div class="stat-card bg-blue-100 border-l-4 border-blue-500 p-4 rounded shadow w-full text-center">
                    <h2 class="font-semibold text-gray-700">📥 Courriers Reçus</h2>
                    <p class="text-xl font-bold text-blue-700">120</p>
                </div>
                <div class="stat-card bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded shadow w-full text-center">
                    <h2 class="font-semibold text-gray-700">📌 Courriers Affectés</h2>
                    <p class="text-xl font-bold text-yellow-700">85</p>
                </div>
                <div class="stat-card bg-red-100 border-l-4 border-red-500 p-4 rounded shadow w-full text-center">
                    <h2 class="font-semibold text-gray-700">⏳ En Attente</h2>
                    <p class="text-xl font-bold text-red-700">35</p>
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
             @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
                <thead class="bg-gray-100">
                    <tr class="border border-gray-200">
                        <th class="p-4 text-left">Référence</th>
                        <th class="p-4 text-left">Expéditeur</th>
                        <th class="p-4 text-left">Destinataire</th>
                        <th class="p-4 text-left">Statut</th>
                        <th class="p-4 text-left">Priorité</th>
                        <th class="p-4 text-left">Pièces jointes</th>
                        <th class="p-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courriers as $courrier)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <!-- Référence -->
                            <td class="p-4">{{ $courrier->reference }}</td>

                            <!-- Expéditeur -->
                            <td class="p-4">{{ $courrier->expediteur->name ?? 'N/A' }}</td>

                            <!-- Destinataire -->
                            <td class="p-4">
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
                            <td class="p-4 font-semibold {{ $courrier->statut == 'En attente' ? 'text-yellow-600' : 'text-green-600' }}">
                                {{ $courrier->statut == 'En attente' ? '⏳ En attente' : '✔ Affecté' }}
                            </td>

                            <!-- Priorité -->
                            <td class="p-4 font-bold {{ 
                                $courrier->priorite == 'haute' ? 'text-red-500' : 
                                ($courrier->priorite == 'moyenne' ? 'text-yellow-500' : 'text-green-500') }}">
                                {{ 
                                    $courrier->priorite == 'haute' ? '🔴 Haute' : 
                                    ($courrier->priorite == 'moyenne' ? '🟡 Moyenne' : '🟢 Basse') 
                                }}
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
                                @if(Auth::user()->hasRole('Agent') || Auth::user()->id === $courrier->expediteur_id)
                                    <!-- Bouton Modifier -->
                                    <a href="{{ route('courriers.edit', $courrier->id) }}" 
                                       class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                        ✏️ Modifier
                                    </a>

                                    <!-- Bouton Supprimer -->
                                    <form action="{{ route('courriers.destroy', $courrier->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce courrier ?')">
                                                🗑️ Supprimer
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 p-4 italic">
                                📭 Aucun courrier trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $courriers->links('pagination::bootstrap-4') }}
            </div>

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
                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="text-green-600 hover:underline text-xs" type="submit">Marquer comme lu</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-gray-500 italic">Aucune notification.</div>
    @endif
</div>
            <script src="https://cdn.tailwindcss.com"></script>
        </main>
    </div>
    
</x-app-layout>