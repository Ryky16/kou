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
                        <li><a href="#" class="sidebar-link">👤 Utilisateurs & Rôles</a></li>
                        <li><a href="#" class="sidebar-link">📊 Statistiques & Rapports</a></li>
                        <li><a href="#" class="sidebar-link">🔔 Notifications</a></li>
                        <li><a href="#" class="sidebar-link">⚙️ Paramètres</a></li>
                    </ul>
                </nav>
            </div>

            <div class="text-center pb-4">
                <p class="text-sm opacity-80">© 2025 Mairie Ziguinchor</p>
            </div>
        </aside>

       <!-- Main Content -->
       <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 text-center mb-6">
                Tableau de Bord Administrateur
            </h1>

            <!-- Statistiques en ligne (Alignées Verticalement sur une même ligne) -->
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
        </main>
    </div>
</x-app-layout>
