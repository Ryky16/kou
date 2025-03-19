<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - Mairie de Ziguinchor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-center">
            <a href="/" class="mb-4">
                <img src="/images/logo.png" alt="Logo Mairie" class="w-20 h-20">
            </a>
        </div>
        <h2 class="text-2xl font-bold text-center text-green-700 mb-4">Mot de passe oublié</h2>
        <p class="text-sm text-center text-gray-600 mb-6">
            Entrez votre adresse email et nous vous enverrons un lien de réinitialisation de mot de passe.
        </p>

        <!-- Message de statut -->
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600 text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <div class="relative">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-500 focus:border-green-500">
                    <span class="absolute right-3 top-2.5 text-gray-400">
                        📧
                    </span>
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                Envoyer le lien de réinitialisation
            </button>

            <!-- Lien retour à la connexion -->
            <p class="mt-4 text-center text-sm text-gray-600">
                <a href="{{ route('login') }}" class="text-green-600 hover:underline">Retour à la connexion</a>
            </p>
        </form>
    </div>

</body>
</html>
