<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Mairie de Ziguinchor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-center">
            <a href="/" class="mb-4">
                <img src="/images/logo.png" alt="Logo Mairie" class="w-20 h-20">
            </a>
        </div>
        <h2 class="text-2xl font-bold text-center text-green-700 mb-4">Connexion</h2>
        <p class="text-sm text-center text-gray-600 mb-6">Connectez-vous à votre espace de gestion des courriers</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <div class="relative">
                    <input type="email" id="email" name="email" required 
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                    <span class="absolute right-3 top-2.5 text-gray-400">
                        ✉️
                    </span>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Mot de passe -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Mot de passe</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required 
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                    <span class="absolute right-3 top-2.5 text-gray-400">
                        🔒
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Se souvenir de moi -->
            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="mr-2"> 🔄 Se souvenir de moi
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:underline">
                    ❓ Mot de passe oublié ?
                </a>
            </div>

            <!-- Bouton de connexion -->
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                🚀 Se connecter
            </button>

            <!-- Lien vers inscription -->
            <p class="mt-4 text-center text-sm text-gray-600">
               <!-- Pas encore inscrit ? -->
                <a href="{{ route('register') }}" class="text-green-600 hover:underline">
                 <!--   ➕ Créer un compte -->
                </a>
            </p>
        </form>
    </div>
</body>
</html>
