<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | Caffée Rajel Kbir</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,500&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        coffee: {
                            50: '#F8F5F0', 
                            100: '#E6DFD3',
                            600: '#5C4033', 
                            900: '#3B2F2F', 
                        },
                        brick: {
                            600: '#A33327', 
                            700: '#8B2920', 
                        }
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['"Poppins"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-coffee-50 font-sans min-h-screen flex items-center justify-center p-4 antialiased">

    <div class="bg-white p-8 rounded-3xl shadow-2xl border border-coffee-100 max-w-md w-full my-6 relative overflow-hidden">
        
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-16 h-16 rounded-full mx-auto mb-2 object-cover border border-coffee-100 shadow-sm">
            <h2 class="font-serif text-3xl font-bold text-coffee-900">Rejoindre le Club</h2>
            <p class="text-sm text-coffee-600 mt-1">Créez votre compte Caffée Rajel Kbir</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-brick-600/10 border border-brick-600 text-brick-700 text-sm p-3 rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-coffee-900 mb-1">Nom complet</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ex: Mohamed Ali"
                    class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:border-transparent text-coffee-900 transition-all shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-coffee-900 mb-1">Adresse Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="exemple@mail.com"
                    class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:border-transparent text-coffee-900 transition-all shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-coffee-900 mb-1">Téléphone</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="Ex: 22 123 456"
                    class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:border-transparent text-coffee-900 transition-all shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-coffee-900 mb-1">Adresse</label>
                <input type="text" name="address" value="{{ old('address') }}" required placeholder="Ex: 12 Rue de la République, Tunis"
                    class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:border-transparent text-coffee-900 transition-all shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-coffee-900 mb-1">Mot de passe</label>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:border-transparent text-coffee-900 transition-all shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-coffee-900 mb-1">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required placeholder="••••••••"
                    class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:border-transparent text-coffee-900 transition-all shadow-sm">
            </div>

            <button type="submit" class="w-full py-3 bg-gradient-to-r from-brick-600 to-brick-700 hover:from-brick-700 hover:to-brick-800 text-white font-medium rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 mt-4">
                Créer mon compte
            </button>
        </form>

        <div class="text-center mt-6 text-sm text-coffee-600">
            Déjà inscrit ? <a href="/login" class="text-brick-600 hover:underline font-medium">Se connecter</a>
        </div>
    </div>

</body>
</html>