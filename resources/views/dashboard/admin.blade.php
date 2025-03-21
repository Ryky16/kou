<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 flex">
        <!-- Sidebar ajusté en hauteur -->
        <aside class="w-64 bg-green-700 text-white shadow-md p-4 flex flex-col h-full min-h-screen">
            <div class="flex flex-col">
                <h1 class="text-xl font-bold flex items-center justify-center mb-4">
                    <span class="mr-2">⚙️</span> Menu
                </h1>

                <!-- Ligne de séparation ajustée en hauteur -->
                <hr class="border-gray-300 dark:border-gray-600 mb-4 flex-grow">

                <nav class="flex-1">
                    <ul class="space-y-4">
                        <li><a href="#" class="sidebar-link">📁 Gestion des Courriers</a></li>
                        <li><a href="#" class="sidebar-link">📌 Affectations</a></li>
                        <li><a href="#" class="sidebar-link">📂 Archives</a></li>
                        <li><a href="#" class="sidebar-link">🏛️ Services de la Mairie</a></li>
                        <li><a href="#" class="sidebar-link">👤 Utilisateurs & Rôles</a></li>
                        <li><a href="#" class="sidebar-link">📊 Statistiques & Rapports</a></li>
                        <li><a href="#" class="sidebar-link">🔔 Notifications</a></li>
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
                Tableau de Bord Administrateur
            </h1>

            <!-- Moteur de recherche avancé -->
            <div class="mb-6">
                <input type="text" class="w-full p-3 rounded-md shadow-sm border border-gray-300" 
                    placeholder="🔍 Rechercher un courrier par référence, expéditeur, date...">
            </div>

            <!-- Statistiques en ligne avec animation hover -->
            <div class="flex justify-between gap-6">
                <div class="stat-card">
                    <h2>📥 Courriers Reçus</h2>
                    <p>120</p>
                </div>
                <div class="stat-card">
                    <h2>📤 Courriers Envoyés</h2>
                    <p>85</p>
                </div>
                <div class="stat-card">
                    <h2>⏳ Courriers en Attente</h2>
                    <p>30</p>
                </div>
                <div class="stat-card">
                    <h2>📑 Total Courriers</h2>
                    <p>235</p>
                </div>
            </div>

 <!-- Tableau de suivi des courriers -->
<table class="w-full bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-300 dark:border-gray-700">
    <!-- Titre bien placé à l'intérieur du tableau -->
    <thead class="bg-green-700 border border-gray-300 dark:border-gray-700">
        <tr>
            <th colspan="8" class="bg-green-100 text-lg font-bold text-center py-2">
                📌 Suivi des Courriers
            </th>
        </tr>
        <tr class="border border-gray-300 dark:border-gray-700">
            <th class="p-4 text-left border-r border-gray-300 dark:border-gray-700">Référence</th>
            <th class="p-4 text-left border-r border-gray-300 dark:border-gray-700">Expéditeur</th>
            <th class="p-4 text-left border-r border-gray-300 dark:border-gray-700">Destinataire</th>
            <th class="p-4 text-left border-r border-gray-300 dark:border-gray-700">Statut</th>
            <th class="p-4 text-left">Priorité</th>
        </tr>
    </thead>
    <tbody>
        <tr class="border-b border-gray-300 dark:border-gray-700">
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">#C001</td>
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">M. Diouf</td>
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">Service Urbanisme</td>
            <td class="p-4 font-semibold text-green-600 dark:text-green-400 border-r border-gray-300 dark:border-gray-700">✔ Traité</td>
            <td class="p-4"><span class="text-green-500 dark:text-green-300 font-bold">🟢 Normal</span></td>
        </tr>
        <tr class="border-b border-gray-300 dark:border-gray-700">
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">#C002</td>
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">Mme Ba</td>
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">Service État Civil</td>
            <td class="p-4 font-semibold text-yellow-600 dark:text-yellow-400 border-r border-gray-300 dark:border-gray-700">⏳ En cours</td>
            <td class="p-4"><span class="text-yellow-500 dark:text-yellow-300 font-bold">🟡 Moyenne</span></td>
        </tr>
        <tr class="border-b border-gray-300 dark:border-gray-700">
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">#C003</td>
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">M. Sarr</td>
            <td class="p-4 border-r border-gray-300 dark:border-gray-700">Service Financier</td>
            <td class="p-4 font-semibold text-red-600 dark:text-red-400 border-r border-gray-300 dark:border-gray-700">❌ En attente</td>
            <td class="p-4"><span class="text-red-500 dark:text-red-300 font-bold">🔴 Urgent</span></td>
        </tr>
    </tbody>
</table>


          
        </main>
    </div>

</x-app-layout>
