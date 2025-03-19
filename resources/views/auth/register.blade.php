<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Mairie de Ziguinchor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-center">
            <a href="/" class="mb-4">
                <img src="/images/logo.png" alt="Logo Mairie" class="w-20 h-20">
            </a>
        </div>
        <h2 class="text-2xl font-bold text-center text-green-700 mb-4">Inscription</h2>
        <p class="text-sm text-center text-gray-600 mb-6">Créez votre compte pour accéder à la plateforme</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nom -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nom complet</label>
                <div class="relative">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                    <span class="absolute right-3 top-2.5 text-gray-400">
                        👤
                    </span>
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <div class="relative">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required 
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

            <!-- Confirmation du mot de passe -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Confirmez le mot de passe</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" required 
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                    <span class="absolute right-3 top-2.5 text-gray-400">
                        🔐
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Bouton d'inscription -->
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                ➕ S'inscrire
            </button>

            <!-- Lien vers connexion -->
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">Déjà inscrit ? 
                    <a href="{{ route('login') }}" class="text-green-600 hover:underline">
                        🔑 Se connecter
                    </a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>
