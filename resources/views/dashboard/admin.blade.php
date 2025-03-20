<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-md p-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Menu</h2>
            <nav>
                <ul class="space-y-2">
                    <li><a href="#" class="block px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">📁 Gestion des Courriers</a></li>
                    <li><a href="#" class="block px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">📌 Affectations</a></li>
                    <li><a href="#" class="block px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">👤 Utilisateurs & Rôles</a></li>
                    <li><a href="#" class="block px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">📊 Statistiques & Rapports</a></li>
                    <li><a href="#" class="block px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">🔔 Notifications</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Tableau de Bord Administrateur</h1>
            
            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-100">📥 Courriers Reçus</h2>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">0</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-100">📤 Courriers Envoyés</h2>
                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">0</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-100">⏳ Courriers en Attente</h2>
                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">0</p>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
