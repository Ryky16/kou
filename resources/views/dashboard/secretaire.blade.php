<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">

        <!-- Sidebar -->
        <aside x-show="sidebarOpen" class="w-64 bg-blue-700 text-white shadow-md p-4 flex flex-col h-full min-h-screen">
            <div class="flex flex-col">
                <h1 class="text-xl font-bold flex items-center justify-center mb-4">
                    <span class="mr-2">📂</span> Menu Secrétaire
                </h1>

                <hr class="border-gray-300 dark:border-gray-600 mb-4">

                <nav class="flex-1 space-y-4">
                    <ul class="space-y-2">
                        <li><a href="{{ route('courriers.index') }}" class="sidebar-link">📁 Gérer les Courriers</a></li>
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

    <!--tableau de suivi des courriers-->
    <table class="w-full bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-300 dark:border-gray-700">
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
                    <form action="{{ route('courriers.affecter', $courrier->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3 py-1 bg-green-500 rounded text-white">
                            Attribuer
                        </button>
                    </form>
                @else
                    <button class="px-3 py-1 bg-gray-400 rounded text-white" disabled>
                        Affectation terminée
                    </button>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>


    <!--tbody>
        <tr class="border-b border-gray-300 dark:border-gray-700">
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">#C010</td>
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">M. Faye</td>
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">Service Urbanisme</td>
            <td class="p-4 text-yellow-600 font-semibold  border-r border-gray-300 dark:border-gray-700">⏳ En attente</td>
            <td class="p-4 text-yellow-500 font-bold  border-r border-gray-300 dark:border-gray-700">🟡 Moyenne</td>
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">
             
                <button class="px-3 py-1 bg-green-500 rounded affecter-btn">
                    Attribuer
                </button>
               
            </td>
        </tr>
        <tr class="border-b border-gray-300 dark:border-gray-700">
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">#C011</td>
            <td class="p-4  border-r border-gray-300 dark:border-gray-700">Mme Sagna</td>
            <td class="p-4  border-r border-gray-300 dark:border-gray-700">Service Financier</td>
            <td class="p-4 text-green-600 font-semibold  border-r border-gray-300 dark:border-gray-700">✔ Affecté</td>
            <td class="p-4 text-green-500 font-bold  border-r border-gray-300 dark:border-gray-700">🟢 Normal</td>
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">
       
            <button class="px-3 py-1 bg-gray-400 rounded" disabled>
                Affectation terminée
            </button>
       
            </td>
        </tr>
    </tbody-->
</table>


        </main>          
    </div>
</x-app-layout>
