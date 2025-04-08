<x-app-layout>
    <div class="flex min-h-screen bg-white" x-data="{ sidebarOpen: true, showTable: true }">
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'block' : 'hidden'" class="w-64 text-white shadow-md p-4 flex flex-col h-full min-h-screen bg-green-800">
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
                        
                        <li><a href="#" class="sidebar-link">📂 Consulter les Archives</a></li>
                        <li><a href="#" class="sidebar-link">📊 Statistiques</a></li>
                        <li>
                            <a href="#" class="sidebar-link flex items-center justify-between">
                                🔔 Notifications
                                <span class="bg-red-500 rounded-full px-2 py-1 text-white text-xs">2</span>
                            </a>
                        </li>
                        <li><a href="#" class="sidebar-link">⚙️ Paramètres</a></li>
                    </ul>
                </nav>
            </div>

            <div class="text-center pb-5 sidebar-footer mt-auto">
                <p class="text-sm text-gray-200">© 2025 Mairie Ziguinchor</p>
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

            <!-- Moteur de recherche (à connecter avec un controller plus tard) -->
            <div class="mb-6">
                <input type="text" class="w-full p-3 rounded-md shadow-sm border border-gray-300" 
                    placeholder="🔍 Rechercher un courrier par référence, expéditeur, date...">
            </div>

            <!-- Statistiques principales -->
            <div class="flex justify-between gap-6 mb-12">
                <div class="stat-card bg-green-100 border-l-4 border-green-500 p-4 rounded shadow w-full text-center">
                    <h2 class="font-semibold text-gray-700">📥 Courriers Reçus</h2>
                    <p class="text-xl font-bold text-green-700">95</p>
                </div>
                <div class="stat-card bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded shadow w-full text-center">
                    <h2 class="font-semibold text-gray-700">📌 Courriers Affectés</h2>
                    <p class="text-xl font-bold text-yellow-700">70</p>
                </div>
                <div class="stat-card bg-red-100 border-l-4 border-red-500 p-4 rounded shadow w-full text-center">
                    <h2 class="font-semibold text-gray-700">⏳ En Attente</h2>
                    <p class="text-xl font-bold text-red-700">25</p>
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
                        <th class="p-4 text-left">Référence</th>
                        <th class="p-4 text-left">Expéditeur</th>
                        <th class="p-4 text-left">Destinataire</th>
                        <th class="p-4 text-left">Statut</th>
                        <th class="p-4 text-left">Priorité</th>
                        <th class="p-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courriers as $courrier)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="p-4">{{ $courrier->reference }}</td>
                            <td class="p-4">{{ $courrier->expediteur }}</td>
                            <td class="p-4">{{ $courrier->destinataire }}</td>
                            <td class="p-4 font-semibold {{ $courrier->statut == 'En attente' ? 'text-yellow-600' : 'text-green-600' }}">
                                {{ $courrier->statut == 'En attente' ? '⏳ En attente' : '✔ Affecté' }}
                            </td>
                            <td class="p-4 font-bold {{ 
                                $courrier->priorite == 'Haute' ? 'text-red-500' : 
                                ($courrier->priorite == 'Moyenne' ? 'text-yellow-500' : 'text-green-500') }}">
                                {{ 
                                    $courrier->priorite == 'Haute' ? '🔴 Haute' : 
                                    ($courrier->priorite == 'Moyenne' ? '🟡 Moyenne' : '🟢 Normal') 
                                }}
                            </td>
                            <td class="p-4  border-r border-gray-200">
                                @if($courrier->statut == 'En attente')
                                    <a href="{{ route('affectation.create', ['courrier_id' => $courrier->id]) }}" 
                                       class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200">
                                       ➕ Affecter
                                    </a>
                                @else
                                    <button class="px-3 py-1 bg-gray-300 text-gray-700 rounded cursor-not-allowed">
                                        Affectation terminée
                                    </button>
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

            <!-- Message de succès -->
            @if(session('success'))
                <div class="mt-4 bg-green-100 border border-green-500 text-green-700 p-3 rounded text-center">
                    {{ session('success') }}
                </div>
            @endif
        </main>
    </div>
</x-app-layout>
