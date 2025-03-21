<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside class="w-64 bg-green-700 text-white shadow-md p-4 flex flex-col justify-between">
            <div>
                <h2 class="text-lg font-semibold mb-4 text-center">Menu</h2>
                <nav>
                    <ul class="space-y-2">
                        <li><a href="#" class="sidebar-link">📁 Gestion des Courriers</a></li>
                        <li><a href="#" class="sidebar-link">📌 Affectations</a></li>
                        <li><a href="#" class="sidebar-link">👤 Utilisateurs & Rôles</a></li>
                        <li><a href="#" class="sidebar-link">📊 Statistiques & Rapports</a></li>
                        <li><a href="#" class="sidebar-link">🔔 Notifications</a></li>
                    </ul>
                </nav>
            </div>
            <div class="text-center pb-4">
                <p class="text-sm opacity-80">© 2025 Mairie Ziguinchor</p>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Tableau de Bord Administrateur</h1>
            
            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                <div class="stat-card bg-green-100 dark:bg-green-900">
                    <h2>📥 Courriers Reçus</h2>
                    <p>120</p>
                </div>
                <div class="stat-card bg-blue-100 dark:bg-blue-900">
                    <h2>📤 Courriers Envoyés</h2>
                    <p>85</p>
                </div>
                <div class="stat-card bg-yellow-100 dark:bg-yellow-900">
                    <h2>⏳ Courriers en Attente</h2>
                    <p>30</p>
                </div>
                <div class="stat-card bg-gray-100 dark:bg-gray-800">
                    <h2>📑 Total Courriers</h2>
                    <p>235</p>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
