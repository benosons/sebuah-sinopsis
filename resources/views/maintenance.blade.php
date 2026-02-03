<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Under Construction - Sebuah Sinopsis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#0d59f2",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-pulse-slow {
            animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 font-display min-h-screen flex items-center justify-center">
    <!-- Background Pattern -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 text-center px-6 max-w-2xl mx-auto">
        <!-- Construction Icon -->
        <div class="mb-8 animate-float">
            <div class="w-32 h-32 mx-auto bg-gradient-to-br from-orange-400 to-amber-500 rounded-3xl flex items-center justify-center shadow-2xl shadow-orange-500/20 rotate-12">
                <span class="material-symbols-outlined text-white text-6xl -rotate-12">construction</span>
            </div>
        </div>

        <!-- Main Text -->
        <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tight">
            Under Construction
        </h1>
        <p class="text-lg md:text-xl text-gray-400 mb-8 leading-relaxed">
            Kami sedang mempersiapkan sesuatu yang luar biasa untuk Anda. 
            <br class="hidden sm:block"/>Silakan kembali lagi nanti!
        </p>

        <!-- Brand -->
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 mb-8 inline-block">
            <div class="flex items-center gap-3 justify-center">
                <div class="w-12 h-12 bg-primary/20 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-2xl">local_library</span>
                </div>
                <div class="text-left">
                    <h2 class="text-white font-bold text-lg">Sebuah Sinopsis</h2>
                    <p class="text-gray-400 text-sm">Book Reviews & Synopses</p>
                </div>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="flex items-center justify-center gap-2 mb-8">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-orange-500"></span>
            </span>
            <span class="text-orange-400 font-medium text-sm animate-pulse-slow">Maintenance in progress...</span>
        </div>

        <!-- Contact -->
        <div class="text-gray-500 text-sm">
            <p>Ada pertanyaan? Hubungi kami:</p>
            <a href="mailto:admin@sebuahsinopsis.com" class="text-primary hover:underline font-medium">
                admin@sebuahsinopsis.com
            </a>
        </div>

        <!-- Login Link for Admin -->
        <div class="mt-12 pt-8 border-t border-white/10">
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-300 text-sm transition-colors inline-flex items-center gap-1">
                <span class="material-symbols-outlined text-base">login</span>
                Admin Login
            </a>
        </div>
    </div>
</body>
</html>
