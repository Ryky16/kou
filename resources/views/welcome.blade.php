<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Courriers - Mairie de Ziguinchor</title>

    <!-- Lien vers le fichier CSS externe -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Lien vers le fichier JavaScript externe -->
    <script src="{{ asset('js/script.js') }}" defer></script>

    <!-- Pour les polices -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-roboto">

    <!-- Header -->
    <header class="header bg-green-700 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Mairie Ziguinchor" class="logo w-16 h-16">
            <nav>
                <ul class="menu flex space-x-4">
                    <li><a href="{{ route('bienvenue') }}" class="menu-item hover:text-gray-300">Accueil</a></li>
                    <li><a href="{{ route('login') }}" class="menu-item hover:text-gray-300">Se connecter</a></li>
                    <li><a href="{{ route('register') }}" class="menu-item hover:text-gray-300">S'inscrire</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main -->
    <main class="main text-center py-16">
        <h1 class="title text-4xl font-bold text-green-700 mb-4">Gestion des Courriers</h1>
        <p class="description text-lg text-gray-600 mb-8">Une solution moderne et efficace pour gérer les courriers entrants et sortants de la Mairie de Ziguinchor</p>

        <div class="buttons flex justify-center space-x-4">
            <a href="{{ route('login') }}" class="btn bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition">🚀 Se connecter</a>
            <a href="{{ route('register') }}" class="btn bg-gray-200 text-green-700 py-2 px-4 rounded-lg hover:bg-gray-300 transition">➕ S'inscrire</a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer bg-gray-800 text-white py-4 text-center">
        <p>&copy; 2025 Mairie de Ziguinchor - Tous droits réservés</p>
    </footer>
</body>
</html>
