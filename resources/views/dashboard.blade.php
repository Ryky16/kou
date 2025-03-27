<x-app-layout>
    <x-slot name="header">
        <!-- Suppression du titre "Dashboard" -->
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Titre professionnel et captivant (centré) -->
                <div class="text-gray-900 dark:text-gray-100 text-center text-8xl font-bold mb-12">
                    {{ "Gestion Municipale - Votre Espace de Travail" }}
                </div>
                
                <!-- Grille des rôles avec icônes agrandies et textes centrés -->
                <div class="flex flex-col md:flex-row justify-center items-center gap-10 mt-6 text-center">
                    <!-- Admin -->
                    <a href="{{ route('admin.dashboard') }}" class="m-8 block p-10 bg-green-100 dark:bg-green-900 rounded-lg shadow-md hover:shadow-lg transition transform hover:scale-105 max-w-sm w-full">
                        <div class="flex justify-center items-center mb-6">
                            <i class="fas fa-user-shield text-9xl text-green-600 dark:text-green-300"></i>
                        </div>
                        <p class="font-semibold text-gray-800 dark:text-gray-200 text-2xl mb-4">Administrateur</p>
                        <p class="text-lg text-gray-600 dark:text-gray-400">Gère les paramètres et les utilisateurs.</p>
                    </a>
                    
                    <!-- Secrétaire Municipal -->
                    <!--a href="{{ route('secretaire.dashboard') }}" class="m-8 block p-10 bg-green-100 dark:bg-green-900 rounded-lg shadow-md hover:shadow-lg transition transform hover:scale-105 max-w-sm w-full">
                        <div class="flex justify-center items-center mb-6">
                            <i class="fas fa-file-alt text-9xl text-green-600 dark:text-green-300"></i>
                        </div>
                        <p class="font-semibold text-gray-800 dark:text-gray-200 text-2xl mb-4">Secrétaire Municipal</p>
                        <p class="text-lg text-gray-600 dark:text-gray-400">Gère les documents et les communications.</p>
                    </a-->
                    
                    <!-- Agent -->
                    <a href="{{ route('agent.dashboard') }}" class="m-8 block p-10 bg-green-100 dark:bg-green-900 rounded-lg shadow-md hover:shadow-lg transition transform hover:scale-105 max-w-sm w-full">
                        <div class="flex justify-center items-center mb-6">
                            <i class="fas fa-user-tie text-9xl text-green-600 dark:text-green-300"></i>
                        </div>
                        <p class="font-semibold text-gray-800 dark:text-gray-200 text-2xl mb-4">Agent</p>
                        <p class="text-lg text-gray-600 dark:text-gray-400">Effectue les tâches opérationnelles.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>