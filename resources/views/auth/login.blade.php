<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Caffée Rajel Kbir</title>
    
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

    <style>
        /* Animation du flux de café continu */
        @keyframes pour {
            0% { height: 0; opacity: 0; }
            15% { height: 100%; opacity: 1; }
            85% { height: 100%; opacity: 1; top: 0; }
            100% { height: 0; opacity: 0; top: 100%; }
        }
        
        .coffee-stream {
            animation: pour 1.8s ease-in forwards;
        }

        /* Animation de la vapeur améliorée */
        @keyframes steam-rise {
            0% { transform: translateY(0) scale(1) translateX(0); opacity: 0; }
            20% { opacity: 0.7; }
            50% { opacity: 0.5; transform: translateY(-25px) scale(1.5) translateX(-5px); }
            100% { transform: translateY(-60px) scale(3) translateX(-15px); opacity: 0; }
        }

        @keyframes steam-rise-right {
            0% { transform: translateY(0) scale(1) translateX(0); opacity: 0; }
            20% { opacity: 0.7; }
            50% { opacity: 0.5; transform: translateY(-25px) scale(1.5) translateX(5px); }
            100% { transform: translateY(-60px) scale(3) translateX(15px); opacity: 0; }
        }

        .steam-particle {
            animation: steam-rise 2.5s infinite ease-out;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0) 70%);
            filter: blur(6px);
            position: absolute;
        }

        .steam-particle-right {
            animation: steam-rise-right 2.5s infinite ease-out;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0) 70%);
            filter: blur(6px);
            position: absolute;
        }

        .steam-1 { animation-delay: 0s; width: 20px; height: 20px; left: 20px; bottom: 10px; }
        .steam-2 { animation-delay: 0.6s; width: 25px; height: 25px; left: 35px; bottom: 5px; }
        .steam-3 { animation-delay: 1.2s; width: 18px; height: 18px; left: 28px; bottom: 15px; }
        .steam-4 { animation-delay: 0.3s; width: 22px; height: 22px; right: 20px; bottom: 10px; }
        .steam-5 { animation-delay: 0.9s; width: 28px; height: 28px; right: 35px; bottom: 5px; }
        .steam-6 { animation-delay: 1.5s; width: 16px; height: 16px; right: 28px; bottom: 15px; }

        /* Animation de vibration pendant l'extraction */
        @keyframes brew-shake {
            0%, 100% { transform: translateX(0) translateY(0); }
            10% { transform: translateX(-0.8px) translateY(0.5px); }
            20% { transform: translateX(0.8px) translateY(-0.3px); }
            30% { transform: translateX(-0.5px) translateY(0.8px); }
            40% { transform: translateX(0.5px) translateY(-0.5px); }
            50% { transform: translateX(-0.3px) translateY(0.3px); }
            60% { transform: translateX(0.3px) translateY(-0.8px); }
            70% { transform: translateX(-0.7px) translateY(0.2px); }
            80% { transform: translateX(0.7px) translateY(-0.2px); }
            90% { transform: translateX(-0.2px) translateY(0.6px); }
        }

        .brewing {
            animation: brew-shake 0.12s infinite;
        }

        /* Animation de la goutte de café */
        @keyframes coffee-drip {
            0% { transform: translateY(0); opacity: 1; }
            100% { transform: translateY(60px); opacity: 0; }
        }

        .coffee-drip {
            position: absolute;
            width: 4px;
            height: 12px;
            background: linear-gradient(to bottom, #78350f, #451a03);
            border-radius: 50%;
            animation: coffee-drip 0.8s ease-in infinite;
        }

        /* Animation de la lumière LED */
        @keyframes led-pulse {
            0%, 100% { opacity: 1; box-shadow: 0 0 5px currentColor; }
            50% { opacity: 0.6; box-shadow: 0 0 12px currentColor; }
        }

        .led-pulse {
            animation: led-pulse 1.5s ease-in-out infinite;
        }

        /* Animation de la jauge de pression */
        @keyframes pressure-pulse {
            0%, 100% { background-color: #ef4444; }
            50% { background-color: #dc2626; box-shadow: 0 0 10px #ef4444; }
        }

        .pressure-active {
            animation: pressure-pulse 0.3s ease-in-out infinite;
        }

        /* Animation du bouton de levier */
        @keyframes lever-pull {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(50deg); }
        }

        .lever-pull {
            animation: lever-pull 0.4s ease-out forwards;
        }

        .lever-reset {
            animation: lever-pull 0.4s ease-out reverse forwards;
        }

        /* Effet de remplissage de la tasse */
        @keyframes fill-cup {
            0% { height: 0%; }
            100% { height: 85%; }
        }

        .cup-filling {
            animation: fill-cup 2s ease-out forwards;
        }

        /* Effet de mousse */
        @keyframes foam {
            0% { opacity: 0; transform: scaleY(0); }
            100% { opacity: 1; transform: scaleY(1); }
        }

        .foam-effect {
            animation: foam 0.5s ease-out 1.8s forwards;
            transform-origin: bottom;
        }

        /* Transition fluide entre écrans */
        .screen-transition {
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="bg-coffee-50 font-sans min-h-screen flex items-center justify-center p-4 antialiased">

    <div class="bg-white p-8 rounded-3xl shadow-2xl border border-coffee-100 max-w-md w-full min-h-[600px] flex flex-col justify-center relative overflow-hidden">
        
        <!-- Écran Machine à Café -->
        <div id="coffee-machine-screen" class="flex flex-col items-center transition-all duration-700 ease-in-out w-full">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Caffée Rajel Kbir" class="w-20 h-20 rounded-full mx-auto mb-3 shadow-md object-cover border-2 border-coffee-100">
                <h2 class="font-serif text-2xl font-bold text-coffee-900 mb-1">Caffée Rajel Kbir</h2>
                <p class="text-xs text-coffee-600 font-medium bg-coffee-50 inline-block px-3 py-1 rounded-full border border-coffee-100">
                    <i class="inline-block w-2 h-2 bg-green-500 rounded-full mr-1"></i> Prêt à servir
                </p>
            </div>

            <div id="machine-body" class="relative w-72 flex flex-col items-center mt-2">
                
                <!-- Panneau supérieur de la machine -->
                <div class="w-64 h-20 bg-gradient-to-b from-stone-700 to-stone-800 rounded-t-3xl shadow-lg border-2 border-stone-600 flex justify-between items-center px-6 z-10 relative">
                    <!-- Manomètre -->
                    <div class="relative">
                        <div class="w-12 h-12 rounded-full bg-white border-4 border-stone-400 shadow-inner relative flex items-center justify-center">
                            <div class="w-2 h-2 bg-black rounded-full z-10"></div>
                            <div id="pressure-needle" class="w-5 h-[2px] bg-red-600 absolute right-1/2 origin-right rotate-[210deg] transition-transform duration-1000" style="transform: rotate(210deg);"></div>
                        </div>
                        <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 text-[8px] text-stone-400 font-bold">BAR</div>
                    </div>
                    
                    <!-- LEDs de contrôle -->
                    <div class="flex flex-col space-y-1">
                        <div class="flex items-center space-x-2">
                            <div id="power-light" class="w-2.5 h-2.5 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.8)] led-pulse"></div>
                            <span class="text-[8px] text-stone-300">POWER</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div id="brew-light" class="w-2.5 h-2.5 rounded-full bg-stone-500 transition-all duration-300"></div>
                            <span class="text-[8px] text-stone-300">BREW</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div id="temp-light" class="w-2.5 h-2.5 rounded-full bg-stone-500 transition-all duration-300"></div>
                            <span class="text-[8px] text-stone-300">TEMP</span>
                        </div>
                    </div>
                </div>

                <!-- Corps central de la machine -->
                <div class="w-56 bg-gradient-to-b from-stone-800 to-stone-900 shadow-[inset_0_10px_20px_rgba(0,0,0,0.5)] flex flex-col items-center relative z-20 pb-4 rounded-b-xl border-x-2 border-b-2 border-stone-700">
                    
                    <!-- Groupe d'extraction -->
                    <div class="w-40 h-16 bg-gradient-to-b from-zinc-400 to-zinc-600 rounded-b-3xl mt-0 shadow-xl border-b-4 border-zinc-700 flex flex-col items-center relative z-30">
                        
                        <!-- Levier de commande -->
                        <div id="machine-lever" onclick="startCoffeeAnimation()" class="absolute -right-20 top-2 flex items-center origin-left cursor-pointer transition-all duration-500 hover:-rotate-3 group z-40">
                            <div class="w-20 h-3 bg-gradient-to-b from-zinc-200 to-zinc-500 rounded-full shadow-md group-hover:from-white border border-zinc-400"></div>
                            <div class="w-9 h-9 bg-gradient-to-br from-brick-500 to-brick-700 rounded-full -ml-2 shadow-[0_4px_8px_rgba(0,0,0,0.4)] border-2 border-brick-400 group-hover:scale-110 transition-transform flex items-center justify-center">
                                <div class="w-2 h-5 bg-brick-300 rounded-full opacity-50"></div>
                            </div>
                        </div>

                        <!-- Buses d'extraction -->
                        <div class="w-20 h-5 bg-zinc-800 mt-auto rounded-t-lg border-t border-zinc-600 relative flex justify-around px-3">
                            <div class="absolute -bottom-2 left-3 w-2.5 h-4 bg-gradient-to-b from-zinc-500 to-zinc-400 rounded-b-sm"></div>
                            <div class="absolute -bottom-2 right-3 w-2.5 h-4 bg-gradient-to-b from-zinc-500 to-zinc-400 rounded-b-sm"></div>
                        </div>
                    </div>

                    <!-- Zone de coulée du café -->
                    <div class="w-44 h-32 bg-stone-900 mt-3 rounded-lg shadow-inner relative flex justify-center border border-stone-800">
                        
                        <!-- Conteneur de vapeur -->
                        <div id="steam-container" class="absolute inset-0 w-full h-full hidden">
                            <div class="steam-particle steam-1"></div>
                            <div class="steam-particle steam-2"></div>
                            <div class="steam-particle steam-3"></div>
                            <div class="steam-particle-right steam-4"></div>
                            <div class="steam-particle-right steam-5"></div>
                            <div class="steam-particle-right steam-6"></div>
                        </div>

                        <!-- Flux de café -->
                        <div class="absolute top-0 w-full flex justify-center space-x-8 z-20">
                            <div class="relative w-3 h-28 overflow-hidden">
                                <div id="stream-left" class="absolute top-0 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-amber-800 via-amber-600 to-amber-800 rounded-full shadow-[0_0_5px_rgba(120,53,15,0.5)] w-[3px] opacity-0 h-0"></div>
                                <div id="drip-left" class="coffee-drip opacity-0" style="left: 50%; top: -10px;"></div>
                            </div>
                            <div class="relative w-3 h-28 overflow-hidden">
                                <div id="stream-right" class="absolute top-0 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-amber-800 via-amber-600 to-amber-800 rounded-full shadow-[0_0_5px_rgba(120,53,15,0.5)] w-[3px] opacity-0 h-0"></div>
                                <div id="drip-right" class="coffee-drip opacity-0" style="left: 50%; top: -10px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasse à café -->
                <div class="relative z-30 mt-[-50px] flex flex-col items-center cursor-pointer" onclick="startCoffeeAnimation()">
                    <div class="relative group">
                        <!-- Anse de la tasse -->
                        <div class="absolute -right-4 top-2 w-7 h-11 border-4 border-white rounded-r-2xl shadow-sm group-hover:border-coffee-100 transition"></div>
                        
                        <!-- Corps de la tasse -->
                        <div class="w-24 h-20 bg-gradient-to-b from-white to-gray-100 rounded-b-3xl shadow-[0_5px_15px_rgba(0,0,0,0.2)] relative overflow-hidden flex items-end justify-center border-t border-gray-200 z-10">
                            <div id="cup-fill" class="w-full h-0 bg-gradient-to-t from-amber-950 to-amber-800 transition-all duration-[1800ms] ease-out absolute bottom-0"></div>
                            <div id="foam-layer" class="absolute bottom-0 left-0 w-full h-0 bg-gradient-to-t from-amber-700 to-amber-600 rounded-t-full opacity-0 transition-all duration-300"></div>
                        </div>
                    </div>
                    
                    <!-- Soucoupe -->
                    <div class="w-32 h-4 bg-gradient-to-b from-gray-100 to-gray-300 rounded-full mt-2 shadow-md border-b border-gray-400 z-20"></div>
                </div>

                <!-- Pied de la machine -->
                <div class="w-64 h-10 bg-stone-800 rounded-t-xl mt-[-5px] border-t-4 border-zinc-500 shadow-[0_10px_20px_rgba(0,0,0,0.3)] flex flex-col items-center pt-2 z-10 relative">
                    <div class="w-56 h-3 bg-zinc-900 rounded flex justify-evenly px-1 items-center gap-[2px]">
                        <div class="w-full h-1.5 bg-gradient-to-b from-zinc-400 to-zinc-600 rounded-full"></div>
                        <div class="w-full h-1.5 bg-gradient-to-b from-zinc-400 to-zinc-600 rounded-full"></div>
                        <div class="w-full h-1.5 bg-gradient-to-b from-zinc-400 to-zinc-600 rounded-full"></div>
                        <div class="w-full h-1.5 bg-gradient-to-b from-zinc-400 to-zinc-600 rounded-full"></div>
                        <div class="w-full h-1.5 bg-gradient-to-b from-zinc-400 to-zinc-600 rounded-full"></div>
                        <div class="w-full h-1.5 bg-gradient-to-b from-zinc-400 to-zinc-600 rounded-full"></div>
                        <div class="w-full h-1.5 bg-gradient-to-b from-zinc-400 to-zinc-600 rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Texte d'instruction -->
            <div class="mt-6 text-center">
                <p class="text-xs text-coffee-500 animate-pulse">
                    <i class="fa-solid fa-hand-pointer inline-block mr-1"></i>
                    Cliquez sur la tasse ou tirez le levier rouge
                </p>
            </div>
        </div>

        <!-- Écran de connexion -->
        <div id="login-form-screen" class="hidden absolute inset-0 p-8 flex flex-col justify-center bg-white rounded-3xl opacity-0 scale-95 screen-transition">
            <div class="text-center mb-5 relative">
                <button onclick="resetToMachine()" type="button" class="absolute left-0 top-0 text-coffee-600 hover:text-brick-600 transition-colors p-1 group" title="Retourner à la machine">
                    <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </button>
                
                <div class="relative inline-block">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-16 h-16 rounded-full mx-auto mb-2 object-cover border-2 border-coffee-100 shadow-sm">
                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white"></div>
                </div>
                <h2 class="font-serif text-3xl font-bold text-coffee-900">Connexion</h2>
                <p class="text-sm text-coffee-600 mt-1">Bienvenue chez Rajel Kbir</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-brick-600/10 border-l-4 border-brick-600 text-brick-700 text-sm p-3 rounded-r-xl">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-coffee-900 mb-1">Adresse Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full px-4 py-3 bg-coffee-50 border border-coffee-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:border-transparent text-coffee-900 transition-all shadow-sm hover:shadow-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-coffee-900 mb-1">Mot de passe</label>
                    <input type="password" name="password" required 
                        class="w-full px-4 py-3 bg-coffee-50 border border-coffee-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:border-transparent text-coffee-900 transition-all shadow-sm hover:shadow-md">
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center text-coffee-600 cursor-pointer hover:text-coffee-800">
                        <input type="checkbox" name="remember" class="mr-1.5 rounded border-coffee-300 text-brick-600 focus:ring-brick-600">
                        Se souvenir de moi
                    </label>
                    <a href="#" class="text-brick-600 hover:underline font-medium">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-brick-600 to-brick-700 hover:from-brick-700 hover:to-brick-800 text-white font-medium rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 mt-2 flex items-center justify-center gap-2 group">
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Se connecter
                </button>
            </form>

            <div class="text-center mt-5 text-sm text-coffee-600">
                Pas encore de compte ? 
                <a href="/register" class="text-brick-600 hover:underline font-medium hover:text-brick-700 transition">S'inscrire</a>
            </div>
        </div>

    </div>

    <script>
        let isBrewing = false;
        let animationTimeout;

        function startCoffeeAnimation() {
            if(isBrewing) return; 
            isBrewing = true;

            const lever = document.getElementById('machine-lever');
            const streamLeft = document.getElementById('stream-left');
            const streamRight = document.getElementById('stream-right');
            const dripLeft = document.getElementById('drip-left');
            const dripRight = document.getElementById('drip-right');
            const cupFill = document.getElementById('cup-fill');
            const foamLayer = document.getElementById('foam-layer');
            const machineScreen = document.getElementById('coffee-machine-screen');
            const loginScreen = document.getElementById('login-form-screen');
            const machineBody = document.getElementById('machine-body');
            const brewLight = document.getElementById('brew-light');
            const tempLight = document.getElementById('temp-light');
            const pressureNeedle = document.getElementById('pressure-needle');
            const steamContainer = document.getElementById('steam-container');

            // 1. Animation du levier
            lever.classList.remove('lever-reset');
            lever.classList.add('lever-pull');

            // 2. Activation des LEDs
            setTimeout(() => {
                brewLight.classList.replace('bg-stone-500', 'bg-red-500');
                brewLight.classList.add('led-pulse');
                tempLight.classList.replace('bg-stone-500', 'bg-amber-500');
                tempLight.classList.add('led-pulse');
            }, 150);

            // 3. Montée en pression
            setTimeout(() => {
                pressureNeedle.style.transform = "rotate(90deg)";
                pressureNeedle.classList.add('pressure-active');
            }, 300);

            // 4. Vibrations de la machine
            setTimeout(() => machineBody.classList.add('brewing'), 400);

            // 5. Activation des gouttes et flux de café
            setTimeout(() => {
                streamLeft.classList.add('coffee-stream');
                streamRight.classList.add('coffee-stream');
                dripLeft.style.opacity = '1';
                dripRight.style.opacity = '1';
                
                // Animation intermittente des gouttes
                let dripInterval = setInterval(() => {
                    if (!isBrewing) {
                        clearInterval(dripInterval);
                        return;
                    }
                    dripLeft.style.animation = 'none';
                    dripRight.style.animation = 'none';
                    setTimeout(() => {
                        dripLeft.style.animation = 'coffee-drip 0.8s ease-in infinite';
                        dripRight.style.animation = 'coffee-drip 0.8s ease-in infinite 0.4s';
                    }, 10);
                }, 1000);
            }, 500);

            // 6. Vapeur visible
            setTimeout(() => {
                steamContainer.classList.remove('hidden');
                steamContainer.style.opacity = '1';
            }, 700);

            // 7. Remplissage de la tasse
            setTimeout(() => {
                cupFill.style.height = "85%";
            }, 800);

            // 8. Formation de la mousse
            setTimeout(() => {
                foamLayer.style.height = "15%";
                foamLayer.style.opacity = "1";
            }, 2000);

            // 9. Fin de l'extraction
            setTimeout(() => {
                machineBody.classList.remove('brewing');
                lever.classList.remove('lever-pull');
                lever.classList.add('lever-reset');
                brewLight.classList.replace('bg-red-500', 'bg-stone-500');
                brewLight.classList.remove('led-pulse');
                tempLight.classList.replace('bg-amber-500', 'bg-stone-500');
                tempLight.classList.remove('led-pulse');
                pressureNeedle.style.transform = "rotate(210deg)";
                pressureNeedle.classList.remove('pressure-active');
                streamLeft.classList.remove('coffee-stream');
                streamRight.classList.remove('coffee-stream');
                dripLeft.style.opacity = '0';
                dripRight.style.opacity = '0';
                
                setTimeout(() => {
                    steamContainer.style.opacity = '0';
                    setTimeout(() => steamContainer.classList.add('hidden'), 500);
                }, 300);
            }, 2600);

            // 10. Transition vers le formulaire de connexion
            setTimeout(() => {
                machineScreen.classList.add('opacity-0', 'scale-95');
                
                setTimeout(() => {
                    machineScreen.classList.add('hidden');
                    
                    loginScreen.classList.remove('hidden');
                    setTimeout(() => {
                        loginScreen.classList.remove('opacity-0', 'scale-95');
                        loginScreen.classList.add('opacity-100', 'scale-100');
                    }, 50);
                }, 700);
            }, 3200);
        }

        // Fonction pour réinitialiser et revenir à l'écran de la machine
        function resetToMachine() {
            if (animationTimeout) clearTimeout(animationTimeout);
            
            const machineScreen = document.getElementById('coffee-machine-screen');
            const loginScreen = document.getElementById('login-form-screen');
            const cupFill = document.getElementById('cup-fill');
            const foamLayer = document.getElementById('foam-layer');
            const streamLeft = document.getElementById('stream-left');
            const streamRight = document.getElementById('stream-right');
            const lever = document.getElementById('machine-lever');

            loginScreen.classList.add('opacity-0', 'scale-95');
            
            setTimeout(() => {
                loginScreen.classList.add('hidden');
                
                // Reset des animations
                cupFill.style.height = "0";
                foamLayer.style.height = "0";
                foamLayer.style.opacity = "0";
                streamLeft.classList.remove('coffee-stream');
                streamRight.classList.remove('coffee-stream');
                lever.classList.remove('lever-reset');
                isBrewing = false;

                machineScreen.classList.remove('hidden');
                setTimeout(() => {
                    machineScreen.classList.remove('opacity-0', 'scale-95');
                }, 50);
            }, 700);
        }

        // Éviter les clics multiples pendant l'animation
        document.getElementById('machine-lever')?.addEventListener('click', (e) => {
            if (isBrewing) e.stopPropagation();
        });
    </script>
    
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>