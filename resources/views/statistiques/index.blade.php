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

                <!-- Cartes principales -->
                <div class="flex flex-col md:flex-row gap-6 mb-12">
                    <!-- Total courriers -->
                    <div class="stat-card bg-blue-100 border-l-4 border-blue-500 p-6 rounded shadow w-full text-center flex flex-col items-center">
                        <span class="text-4xl mb-2">📬</span>
                        <h2 class="font-semibold text-gray-700 mb-2">Total des courriers</h2>
                        <p class="text-3xl font-bold text-blue-700 mb-1">{{ $totalCourriers }}</p>
                        <span class="text-xs text-gray-500">Tous les courriers enregistrés</span>
                    </div>
                    <!-- Courriers par semaine (somme) -->
                    <div class="stat-card bg-yellow-100 border-l-4 border-yellow-500 p-6 rounded shadow w-full text-center flex flex-col items-center">
                        <span class="text-4xl mb-2">📅</span>
                        <h2 class="font-semibold text-gray-700 mb-2">Courriers cette semaine</h2>
                        <p class="text-3xl font-bold text-yellow-700 mb-1">
                            {{ collect($weeklyStats)->sum('total') }}
                        </p>
                        <span class="text-xs text-gray-500">Total sur la semaine en cours</span>
                    </div>
                    <!-- Courriers ce mois -->
                    <div class="stat-card bg-green-100 border-l-4 border-green-500 p-6 rounded shadow w-full text-center flex flex-col items-center">
                        <span class="text-4xl mb-2">📆</span>
                        <h2 class="font-semibold text-gray-700 mb-2">Courriers ce mois</h2>
                        <p class="text-3xl font-bold text-green-700 mb-1">
                            {{ collect($monthlyStats)->last()['total'] ?? 0 }}
                        </p>
                        <span class="text-xs text-gray-500">Total du mois en cours</span>
                    </div>
                </div>
            </div>
        </div>

    <!-- Filtrage par année -->
<div class="mb-6 flex justify-end">
    <form method="GET" action="{{ route('statistiques.index') }}" class="flex items-center gap-2">
        <label for="year" class="text-sm font-medium text-gray-700">Filtrer par année :</label>
        <select name="year" id="year" onchange="this.form.submit()" class="px-3 py-2 rounded border border-gray-300">
            @foreach ($availableYears as $availableYear)
                <option value="{{ $availableYear }}" {{ $year == $availableYear ? 'selected' : '' }}>
                    {{ $availableYear }}
                </option>
            @endforeach
        </select>
    </form>
</div>

<!-- Graphique des courriers par mois -->
<div class="bg-white p-6 rounded shadow mb-12">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4 text-center">
        📈 Évolution mensuelle des courriers - {{ $year }}
    </h2>
    <!-- Injecter les données dans une balise HTML -->
    <div 
        id="chart-wrapper" 
        class="relative" 
        style="height:350px;" 
        data-chart='@json($chartData)'
        data-year="{{ $year }}"
    >

    <div class="relative" style="height:350px;">
        <canvas id="courrierChart"></canvas>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/chart.js') }}"></script>
        <script src="https://cdn.tailwindcss.com"></script>
    </div>
</x-app-layout>
     