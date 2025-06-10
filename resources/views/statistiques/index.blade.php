<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- Bouton Retour à gauche -->
            <a href="javascript:history.back()" class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                ⬅️ Retour
            </a>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-8">
                <!-- Titre principal -->
                <h1 class="text-4xl font-bold text-center text-green-600 mb-10">
                    📊 Statistiques des courriers
                </h1>

                <!-- 📊 Bloc double aligné horizontalement -->
<div class="flex flex-col lg:flex-row gap-10 mb-16">
    <!-- 📅 Courriers par semaine -->
    <div class="w-full lg:w-1/2">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-2">
            📅 Courriers par semaine
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @foreach($weeklyStats as $week)
                <div class="bg-blue-100 border-l-4 border-blue-500 p-4 rounded shadow text-center">
                    <h3 class="font-semibold text-gray-700 text-lg">{{ $week['label'] }}</h3>
                    <p class="text-xl font-bold text-blue-700 mt-2">{{ $week['total'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 📆 Courriers par mois -->
    <div class="w-full lg:w-1/2">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-2">
            📆 Courriers de ce mois
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @foreach($monthlyStats as $month)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded shadow text-center">
                    <h3 class="font-semibold text-gray-700 text-lg">
                        {{ \Carbon\Carbon::parse($month['label'])->translatedFormat('F Y') }}
                    </h3>
                    <p class="text-xl font-bold text-yellow-700 mt-2">{{ $month['total'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

        </div>
        <script src="https://cdn.tailwindcss.com"></script>
    </div>
</x-app-layout>






   