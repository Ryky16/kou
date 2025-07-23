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
                            <a href="{{ route('courriers.create') }}" class="sidebar-link">📌 Ajouter un Courriers</a>
                        </li>
                        <li>
                            <a href="#" class="sidebar-link" @click.prevent="showTable = !showTable">
                                📁 Gérer les Courriers
                            </a>
                        </li>
                        <li><a href="{{ route('courriers.archives') }}" class="sidebar-link">📂 Consulter les Archives</a></li>
                        <li><a href="{{ route('statistiques.index') }} " class="sidebar-link">📊 Statistiques</a></li>
                        <li>
                            <a href="#" class="sidebar-link flex items-center justify-between">      
                                🔔 Notifications
                                <span class="bg-red-500 rounded-full px-2 py-1 text-white text-xs">
                        {{ $notifications->count() }}
                            </span>
                                <!--span class="bg-red-500 rounded-full px-2 py-1 text-white text-xs">3</span-->
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
                class="mb-4 px-4 py-2 bg-white text-blue-800 font-semibold rounded-md border-2 border-blue-700 hover:bg-blue-700 hover:text-white transition duration-200"
            >
                <span x-show="!sidebarOpen">📂 Ouvrir le Menu</span>
                <span x-show="sidebarOpen">❌ Fermer le Menu</span>
            </button>

            <h1 class="text-2xl font-bold text-center text-gray-700 mb-6">
                Tableau de Bord Agent Municipal
            </h1>

            <!-- Moteur de recherche -->
            <form method="GET" action="{{ route('agent.dashboard') }}" class="mb-6 flex">
                <input type="text" name="q" value="{{ request('q') }}"
                    class="w-full p-3 rounded-l-md shadow-sm border border-gray-300 focus:outline-none"
                    placeholder="🔍 Rechercher un courrier par référence, expéditeur, date, destinataire...">
                <button type="submit"
                    class="px-5 bg-blue-600 text-white font-semibold rounded-r-md hover:bg-blue-700 transition">
                    🔍
                </button>
            </form>

            <!-- Statistiques principales -->
            <div class="flex justify-between gap-6 mb-12">
                <div class="stat-card bg-blue-100 border-l-4 border-blue-500 p-4 rounded shadow w-full text-center">
                    <h2 class="font-semibold text-gray-700">📥 Courriers Ajoutés</h2>
                    <p class="text-xl font-bold text-blue-700">{{ $totalCourriers }}</p>
                    <!--p class="text-xl font-bold text-blue-700">120</p-->
                </div>
                <div class="stat-card bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded shadow w-full text-center">
                    <h2 class="font-semibold text-gray-700">📌 Courriers Affectés</h2>
                    <p class="text-xl font-bold text-yellow-700">{{ $totalAffectes }}</p>
                </div>
                <div class="stat-card bg-red-100 border-l-4 border-red-500 p-4 rounded shadow w-full text-center">
                    <h2 class="font-semibold text-gray-700">⏳ En Attente</h2>
                    <p class="text-xl font-bold text-red-700">{{ $totalEnAttente }}</p>
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
    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
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
                                @if((Auth::user()->hasRole('Agent') || Auth::user()->id === $courrier->expediteur_id) && $courrier->statut !== 'archivé')
                                    <!-- Bouton Modifier -->
                                    <a href="{{ route('courriers.edit', $courrier->id) }}" 
                                       class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                        ✏️ Modifier
                                    </a>
                                    <!-- Bouton Archiver -->
                                    <form action="{{ route('courriers.archiver', $courrier->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 transition"
                                                onclick="return confirm('Voulez-vous vraiment archiver ce courrier ?')">
                                            🗄️ Archiver
                                        </button>
                                    </form>
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
                                @elseif($courrier->statut == 'archivé')
                                    <span class="px-3 py-1 bg-gray-300 text-gray-700 rounded cursor-not-allowed">Archivé</span>
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
                    <div class="flex gap-2">
                        <!-- Ouvrir le courrier -->
                        <a href="{{ route('courriers.show', ['courrier' => $notification->data['id']]) }}" class="text-green-600 hover:underline text-xs px-2 py-1 border border-green-600 rounded">
                            Ouvrir le courrier
                        </a>
                        <!-- Supprimer la notification -->
                        <form action="{{ route('notifications.delete', $notification->id) }}" method="POST">
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
            <script src="https://cdn.tailwindcss.com"></script>
        </main>
    </div>
    
</x-app-layout>
