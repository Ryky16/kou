<x-app-layout>
    <div class="flex min-h-screen bg-white">
       
    <!-- Sidebar ajusté en hauteur -->
        
    <aside x-show="sidebarOpen" class="w-64 bg-white text-gray-800 shadow-md p-4 flex flex-col h-full min-h-screen border-r border-gray-200">
    <div class="flex flex-col">
        <h1 class="text-xl font-bold flex items-center justify-center mb-4">
            <span class="mr-2">⚙️</span> Menu
        </h1>

        <hr class="border-gray-200 mb-4">

        <nav class="flex-1 space-y-4">

            <ul class="space-y-2">

                <li><a href="#" class="sidebar-link">📁 Gestion des Courriers</a></li>

                <li><a href="#" class="sidebar-link">📌 Affectations</a></li>

                <li><a href="#" class="sidebar-link">📂 Archives</a></li>

                <!-- Dropdown Services de la Mairie -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="sidebar-link flex items-center justify-between w-full">
                        🏢 Services de la Mairie
                        <span :class="open ? 'rotate-180' : ''" class="transition-transform">▼</span>
                    </button>

                    <ul x-show="open" x-collapse class="pl-6 mt-2 space-y-2">
                        <li><a href="#" class="sidebar-link">📌 Urbanisme</a></li>
                        <li><a href="#" class="sidebar-link">📝 État Civil</a></li>
                        <li><a href="#" class="sidebar-link">💰 Finances</a></li>
                        <li><a href="#" class="sidebar-link">📋 Ressources Humaines</a></li>
                        <li><a href="#" class="sidebar-link">🚧 Travaux Publics</a></li>
                    </ul>
                </li>

                <!-- Dropdown pour Utilisateurs & Rôles -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="sidebar-link flex items-center justify-between w-full">
                        👤 Utilisateurs & Rôles
                        <span :class="open ? 'rotate-180' : ''" class="transition-transform">▼</span>
                    </button>

                    <ul x-show="open" x-collapse class="pl-6 mt-2 space-y-2">
                        <li><a href="#" class="sidebar-link">👥 Gérer les Utilisateurs</a></li>
                        <li><a href="#" class="sidebar-link">🔑 Gérer les Rôles</a></li>
                    </ul>
                </li>

                <li><a href="#" class="sidebar-link">📊 Statistiques & Rapports</a></li>

                <li>
    <a href="#" class="sidebar-link flex items-center justify-between">
        🔔 Notifications
        <span class="bg-red-500 rounded-full px-2 py-1">3</span>
    </a>
</li>

                <!--li><a href="#" class="sidebar-link">🔔 Notifications</a></li-->

                <li><a href="#" class="sidebar-link">⚙️ Paramètres</a></li>

            </ul>

        </nav>
    </div>

    <div class="text-center pb-5 sidebar-footer text-gray-600">
        <p class="text-sm">© 2025 Mairie Ziguinchor</p>
    </div>
</aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold text-gray-700 text-center mb-6">
                Tableau de Bord Administrateur
            </h1>

            <!-- Moteur de recherche avancé -->
            <div class="mb-6">
                <input type="text" class="w-full p-3 rounded-md shadow-sm border border-gray-200" 
                    placeholder="🔍 Rechercher un courrier par référence, expéditeur, date...">
            </div>

            <!-- Statistiques avec espace suffisant en dessous -->
            <div class="flex justify-between gap-6 mb-12">
                <div class="stat-card bg-white border border-gray-200">
                    <h2>📥 Courriers Reçus</h2>
                    <p>120</p>
                </div>
                <div class="stat-card bg-white border border-gray-200">
                    <h2>📤 Courriers Envoyés</h2>
                    <p>85</p>
                </div>
                <div class="stat-card bg-white border border-gray-200">
                    <h2>⏳ Courriers en Attente</h2>
                    <p>30</p>
                </div>
                <div class="stat-card bg-white border border-gray-200">
                    <h2>📑 Total Courriers</h2>
                    <p>235</p>
                </div>
            </div>

            <!-- Tableau de suivi des courriers -->
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 mt-12">
                <thead class="bg-gray-50 border border-gray-200">
                    <tr>
                        <th colspan="5" class="p-4 text-center text-lg font-bold text-gray-700 border border-gray-200">
                        📋 Suivi des Courriers
                        </th>
                    </tr>
                    <tr class="border border-gray-200">
                        <th class="p-4 text-left border-r border-gray-200 text-gray-700">Référence</th>
                        <th class="p-4 text-left border-r border-gray-200 text-gray-700">Expéditeur</th>
                        <th class="p-4 text-left border-r border-gray-200 text-gray-700">Destinataire</th>
                        <th class="p-4 text-left border-r border-gray-200 text-gray-700">Statut</th>
                        <th class="p-4 text-left border-gray-200 text-gray-700">Priorité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="p-4 border-r border-gray-200">#C001</td>
                        <td class="p-4 border-r border-gray-200">M. Diouf</td>
                        <td class="p-4 border-r border-gray-200">Service Urbanisme</td>
                        <td class="p-4 font-semibold text-green-600 border-r border-gray-200">✔ Traité</td>
                        <td class="p-4 text-green-500 font-bold">🟢 Normal</td>
                    </tr>
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="p-4 border-r border-gray-200">#C002</td>
                        <td class="p-4 border-r border-gray-200">Mme Ba</td>
                        <td class="p-4 border-r border-gray-200">Service État Civil</td>
                        <td class="p-4 font-semibold text-yellow-600 border-r border-gray-200">⏳ En cours</td>
                        <td class="p-4 text-yellow-500 font-bold">🟡 Moyenne</td>
                    </tr>
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="p-4 border-r border-gray-200">#C003</td>
                        <td class="p-4 border-r border-gray-200">M. Sarr</td>
                        <td class="p-4 border-r border-gray-200">Service Financier</td>
                        <td class="p-4 font-semibold text-red-600 border-r border-gray-200">❌ En attente</td>
                        <td class="p-4 text-red-500 font-bold">🔴 Urgent</td>
                    </tr>
                </tbody>
            </table>

        </main>          
    </div>
</x-app-layout>
