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
@include('layouts.loading-overlay')


<body>


    <header class="header">
        <div class="container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Mairie Ziguinchor" class="logo">
            <nav>
           

                <ul class="menu">
                    <li><a href="{{ route('bienvenue') }}" class="menu-item">Accueil</a></li>
                    <li><a href="{{ route('login') }}" class="menu-item">Se connecter</a></li>
                    <li><a href="{{ route('register') }}" class="menu-item">S'inscrire</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        <h1 class="title">Gestion des Courriers</h1>
        <p class="description">Une solution moderne et efficace pour gérer les courriers entrants et sortants de la Mairie de Ziguinchor</p>

        <div class="buttons">
            <a href="{{ route('login') }}" class="btn"> 🚀 Se connecter</a>
            <a href="{{ route('register') }}" class="btn"> ➕ S'inscrire</a>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2025 Mairie de Ziguinchor - Tous droits réservés</p>
    </footer>
</body>
</html>
