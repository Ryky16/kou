<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chargement...</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div id="loader">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Mairie" class="logo">
        <p class="detail">Bienvenue sur l'application de gestion de courriers</p>
        <div class="spinner"></div>
    </div>

    <script>
        setTimeout(function () {
            window.location.href = "{{ route('bienvenue') }}";
        }, 2000); // Après 2 secondes, redirige vers la page d'accueil
    </script>

<script src="script.js"></script> <!-- Fichier JS séparé -->
</body>
</html>
