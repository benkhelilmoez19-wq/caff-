<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin | Caffée Rajel Kbir')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        coffee: {
                            50: '#F8F5F0', 
                            100: '#E6DFD3',
                            600: '#5C4033', 
                            800: '#4A3525',
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
<body x-data="{ sidebarOpen: true }" class="bg-coffee-50 font-sans text-coffee-900 antialiased flex h-screen overflow-hidden">

    <aside 
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="w-64 bg-coffee-900 text-white flex flex-col shadow-xl z-20 h-full fixed md:relative"
    >
        <div class="p-5 border-b border-white/10 flex items-center justify-between gap-2">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 rounded-full border border-white/20 object-cover">
                <div>
                    <h1 class="font-serif font-bold text-lg tracking-wide">Rajel Kbir</h1>
                    <p class="text-xs text-coffee-100/60">Espace Admin</p>
                </div>
            </div>
            
            <div @click="sidebarOpen = false" class="text-stone-400 hover:text-white transition duration-200 cursor-pointer p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </div>
        </div>

        <nav class="flex-grow p-4 space-y-2 mt-4">
            
            <a href="{{ route('admin.dashboard') }}" class="group relative overflow-hidden flex items-center gap-3 px-4 py-3 rounded-xl transition hover:bg-white/10 {{ Request::is('admin/dashboard') ? 'bg-brick-600 font-medium' : '' }}">
                <span class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-brick-600 rounded-r-lg transform -translate-x-full group-hover:translate-x-0 transition-transform duration-200 {{ Request::is('admin/dashboard') ? 'hidden' : '' }}"></span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('categories.index') }}" class="group relative overflow-hidden flex items-center gap-3 px-4 py-3 rounded-xl transition hover:bg-white/10 {{ Request::is('admin/categories*') ? 'bg-brick-600 font-medium' : '' }}">
                <span class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-brick-600 rounded-r-lg transform -translate-x-full group-hover:translate-x-0 transition-transform duration-200 {{ Request::is('admin/categories*') ? 'hidden' : '' }}"></span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>Catégories</span>
            </a>

            <a href="{{ route('products.index') }}" class="group relative overflow-hidden flex items-center gap-3 px-4 py-3 rounded-xl transition hover:bg-white/10 {{ Request::is('admin/products*') ? 'bg-brick-600 font-medium' : '' }}">
                <span class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-brick-600 rounded-r-lg transform -translate-x-full group-hover:translate-x-0 transition-transform duration-200 {{ Request::is('admin/products*') ? 'hidden' : '' }}"></span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>Produits</span>
            </a>

            <a href="{{ route('users.index') }}" class="group relative overflow-hidden flex items-center gap-3 px-4 py-3 rounded-xl transition hover:bg-white/10 {{ Request::is('admin/users*') ? 'bg-brick-600 font-medium' : '' }}">
                <span class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-brick-600 rounded-r-lg transform -translate-x-full group-hover:translate-x-0 transition-transform duration-200 {{ Request::is('admin/users*') ? 'hidden' : '' }}"></span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292MM15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span>Utilisateurs</span>
            </a>

            <a href="{{ route('reservations.index') }}" class="group relative overflow-hidden flex items-center gap-3 px-4 py-3 rounded-xl transition hover:bg-white/10 {{ Request::is('admin/reservations*') ? 'bg-brick-600 font-medium' : '' }}">
                <span class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-brick-600 rounded-r-lg transform -translate-x-full group-hover:translate-x-0 transition-transform duration-200 {{ Request::is('admin/reservations*') ? 'hidden' : '' }}"></span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Réservations</span>
            </a>

            <!-- NOUVEAU BOUTON TABLES -->
            <a href="{{ route('tables.index') }}" class="group relative overflow-hidden flex items-center gap-3 px-4 py-3 rounded-xl transition hover:bg-white/10 {{ Request::is('admin/tables*') ? 'bg-brick-600 font-medium' : '' }}">
                <span class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-brick-600 rounded-r-lg transform -translate-x-full group-hover:translate-x-0 transition-transform duration-200 {{ Request::is('admin/tables*') ? 'hidden' : '' }}"></span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2v2H3V3zm4 0h14v2H7V3zm-4 4h2v2H3V7zm4 0h14v2H7V7zm-4 4h2v2H3v-2zm4 0h14v2H7v-2zm-4 4h2v2H3v-2zm4 0h14v2H7v-2zm-4 4h2v2H3v-2zm4 0h14v2H7v-2z"/>
                </svg>
                <span>Tables</span>
            </a>
            
        </nav>

        <div class="p-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-stone-300 hover:text-white hover:bg-brick-600/20 transition duration-200 cursor-pointer border-0 bg-transparent text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span class="text-sm font-medium">Déconnexion</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-grow flex flex-col h-full overflow-hidden transition-all duration-300" :class="{ 'md:pl-0': sidebarOpen, 'pl-0': !sidebarOpen }">
        
        <header class="h-16 bg-white border-b border-coffee-100 flex items-center justify-between px-8 shadow-sm z-10">
            <div class="flex items-center gap-4 text-sm">
                <button 
                    @click="sidebarOpen = true" 
                    x-show="!sidebarOpen"
                    class="text-coffee-900 hover:text-brick-600 transition duration-200 cursor-pointer border-0 bg-transparent p-1 -ml-4"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <div class="flex items-center gap-2">
                    <span class="text-stone-400">Admin</span>
                    <span class="text-stone-300">/</span>
                    <span class="font-medium text-coffee-900">@yield('page_title', 'Tableau de bord')</span>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-coffee-600">{{ Auth::user()->name ?? 'Administrateur' }}</span>
                <div class="w-10 h-10 rounded-full bg-coffee-100 text-coffee-900 font-bold flex items-center justify-center border border-coffee-600/20 shadow-sm">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        <main class="flex-grow p-8 overflow-y-auto">
            @yield('content')
        </main>
    </div>

</body>
</html>