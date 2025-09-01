<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoControl - Sistema de Asistencia</title>
    @vite('resources/css/app.css')
    <style>
        /* Fondo degradado animado estilo oscuro */
        body {
            background: linear-gradient(135deg, #0f0f0f, #1a1a1a, #2c3e50, #2b2d42);
            background-size: 400% 400%;
            animation: gradientBG 20s ease infinite;
            position: relative;
            overflow: hidden;
            color: #f5f5f5; /* Texto claro */
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Patrón ligero en el fondo */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill='none' stroke='%23ffffff' stroke-opacity='0.03'%3E%3Cpath d='M0 50h100M50 0v100'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 50px 50px;
            opacity: 0.1;
            z-index: 0;
        }

        /* Animación del icono */
        .icon-anim {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.9; }
        }

        /* Transición de entrada */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 1s ease forwards;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="text-white font-sans antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center px-4 relative z-10 fade-in">

        {{-- Logo + Nombre --}}
        <div class="flex items-center space-x-3 mb-6">
            <h1 class="text-5xl font-extrabold tracking-tight text-white drop-shadow-md">AutoControl</h1>
        </div>

        {{-- Descripción --}}
        <p class="text-white/80 text-center max-w-2xl mb-8 text-lg leading-relaxed">
            Controla y gestiona la asistencia de tu equipo con precisión y reportes profesionales.<br>
            Diseñado para empresas que buscan eficiencia, claridad y presentación corporativa.
        </p>

        {{-- Botones --}}
        <div class="flex space-x-4">
            @if (Route::has('login'))
                <a href="{{ route('login') }}"
                   class="bg-white text-gray-900 hover:bg-gray-200 px-6 py-3 rounded-xl font-semibold transition shadow-lg">
                    Iniciar Sesión
                </a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-xl font-semibold transition shadow-lg">
                    Registrarse
                </a>
            @endif
        </div>

        {{-- Footer --}}
        <footer class="mt-12 text-white/60 text-sm">
            © {{ date('Y') }} AutoControl — Todos los derechos reservados
        </footer>
    </div>

</body>
</html>
