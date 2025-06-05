<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
           <!-- Bouton Retour à gauche -->
                <a href="javascript:history.back()" 
                   class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                    ⬅️ Retour
                </a> 
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-4xl font-bold text-center text-green-600 dark:text-green-300 mb-10">
                    📊 Statistiques des courriers
                </h1>

                <!-- Section Courriers par semaine -->
                <div class="mb-16">
                    <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-100 mb-4">
                        📅 Courriers par semaine
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($weeklyStats as $week)
                            <div class="bg-green-100 dark:bg-green-800 text-center p-6 rounded-lg shadow hover:shadow-md transition">
                                <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ $week['label'] }}</p>
                                <p class="text-4xl font-bold text-green-700 dark:text-green-300 mt-2">{{ $week['total'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Section Courriers par mois -->
                <div>
                    <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-100 mb-4">
                        📆 Courriers par mois
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($monthlyStats as $month)
                            <div class="bg-blue-100 dark:bg-blue-800 text-center p-6 rounded-lg shadow hover:shadow-md transition">
                                <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ \Carbon\Carbon::parse($month['label'])->translatedFormat('F Y') }}</p>
                                <p class="text-4xl font-bold text-blue-700 dark:text-blue-300 mt-2">{{ $month['total'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>
</x-app-layout>
