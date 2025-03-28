<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900" x-data="{ sidebarOpen: true, showTable: false }">
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'block' : 'hidden'" class="w-64 bg-blue-700 text-white shadow-md p-4 flex flex-col h-full min-h-screen">
            <div class="flex flex-col">
                <h1 class="text-xl font-bold flex items-center justify-center mb-4">
                    <span class="mr-2">📂</span> Menu Secrétaire
                </h1>

                <hr class="border-gray-300 dark:border-gray-600 mb-4">

                <nav class="flex-1 space-y-4">
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="sidebar-link" @click.prevent="showTable = !showTable">
                                📁 Gérer les Courriers
                            </a>
                        </li>
                        <li><a href="#" class="sidebar-link">📌 Affecter un Courrier</a></li>
                        <li><a href="#" class="sidebar-link">📂 Consulter les Archives</a></li>
                        <li><a href="#" class="sidebar-link">📊 Statistiques</a></li>
                        <li>
                            <a href="#" class="sidebar-link flex items-center justify-between">
                                🔔 Notifications
                                <span class="bg-red-500 rounded-full px-2 py-1">2</span>
                            </a>
                        </li>
                        <li><a href="#" class="sidebar-link">⚙️ Paramètres</a></li>
                    </ul>
                </nav>
            </div>

            <div class="text-center pb-5 sidebar-footer">
                <p class="text-sm">© 2025 Mairie Ziguinchor</p>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Bouton pour ouvrir/fermer le sidebar -->
            <button 
                @click="sidebarOpen = !sidebarOpen" 
                class="mb-4 px-4 py-2 bg-white text-green-800 font-semibold rounded-md border-2 border-green-700 hover:bg-green-700 hover:text-white transition duration-200"
            >
              <span x-show="!sidebarOpen">📂 Ouvrir le Menu</span>
                <span x-show="sidebarOpen">❌ Fermer le Menu</span>
            </button>

            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 text-center mb-6">
                Tableau de Bord Secrétaire Municipal
            </h1>

            <!-- Moteur de recherche -->
            <div class="mb-6">
                <input type="text" class="w-full p-3 rounded-md shadow-sm border border-gray-300" 
                    placeholder="🔍 Rechercher un courrier par référence, expéditeur, date...">
            </div>

            <!-- Statistiques principales -->
            <div class="flex justify-between gap-6 mb-12">
                <div class="stat-card">
                    <h2>📥 Courriers Reçus</h2>
                    <p>95</p>
                </div>
                <div class="stat-card">
                    <h2>📌 Courriers Affectés</h2>
                    <p>70</p>
                </div>
                <div class="stat-card">
                    <h2>⏳ Courriers en Attente</h2>
                    <p>25</p>
                </div>
            </div>

            <!-- Titre du tableau -->
            <h2 class="text-xl text-center font-semibold text-gray-800 dark:text-gray-200 mb-4">📋 Suivi des Courriers</h2>

            <!-- Tableau de suivi des courriers -->
            <table 
                class="w-full bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-300 dark:border-gray-700"
                x-show="showTable"
                x-transition
            >
                <thead class="bg-blue-700">
                    <tr class="border border-gray-300 dark:border-gray-700">
                        <th class="p-4 text-left border-r border-gray-300 dark:border-gray-700">Référence</th>
                        <th class="p-4 text-left border-r border-gray-300 dark:border-gray-700">Expéditeur</th>
                        <th class="p-4 text-left border-r border-gray-300 dark:border-gray-700">Destinataire</th>
                        <th class="p-4 text-left border-r border-gray-300 dark:border-gray-700">Statut</th>
                        <th class="p-4 text-left border-r border-gray-300 dark:border-gray-700">Priorité</th>
                        <th class="p-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courriers as $courrier)
                        <tr class="border-b border-gray-300 dark:border-gray-700">
                            <td class="p-4 border-r border-gray-300 dark:border-gray-700">{{ $courrier->reference }}</td>
                            <td class="p-4 border-r border-gray-300 dark:border-gray-700">{{ $courrier->expediteur }}</td>
                            <td class="p-4 border-r border-gray-300 dark:border-gray-700">{{ $courrier->destinataire }}</td>
                            <td class="p-4 border-r border-gray-300 dark:border-gray-700 font-semibold {{ $courrier->statut == 'En attente' ? 'text-yellow-600' : 'text-green-600' }}">
                                {{ $courrier->statut == 'En attente' ? '⏳ En attente' : '✔ Affecté' }}
                            </td>
                            <td class="p-4 border-r border-gray-300 dark:border-gray-700 font-bold {{ $courrier->priorite == 'Haute' ? 'text-red-500' : ($courrier->priorite == 'Moyenne' ? 'text-yellow-500' : 'text-green-500') }}">
                                {{ $courrier->priorite == 'Haute' ? '🔴 Haute' : ($courrier->priorite == 'Moyenne' ? '🟡 Moyenne' : '🟢 Normal') }}
                            </td>
                            <td class="p-4 border-r border-gray-300 dark:border-gray-700">
                                @if($courrier->statut == 'En attente')
                                    <form action="{{ route('courriers.affecter', ['id' => $courrier->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-green-500 rounded">
                                            Attribuer
                                        </button>
                                    </form>
                                @else
                                    <button class="px-3 py-1 bg-gray-400 rounded" disabled>
                                        Affectation terminée
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>



               
        </table>
           
       <!-- Pagination -->
       @if ($courriers->isNotEmpty())  
                <div class="d-flex justify-content-center mt-4">
                    {{ $courriers->links('pagination::bootstrap-4')}}
                </div>
            @else
                <div class="text-center text-gray-500 dark:text-gray-400 p-4 italic">
                    📭 Aucun courrier trouvé.
                </div>
            @endif

            <!-- Message de succès -->
            @if(session('success'))
                <div class="bg-green-500 text-center p-2 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif
                               
       
        </main>          
    </div>
</x-app-layout>
