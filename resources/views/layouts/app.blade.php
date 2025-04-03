<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Restaurante</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('style')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>

    </style>
</head>

<body @stack('bodyOnLoad') class="d-flex flex-column min-vh-100">
    @include('header')

    <div class="container-fluid flex-grow-1 p-0">
        @auth
        <div class="d-flex">
            <nav class="sidebar d-none d-lg-block">
                <div class="pt-3">
                    <a href="#" class="d-block sidebar-item active">
                        <i class="fas fa-chart-line me-2"></i>Dashboard
                    </a>
                    <a href="#" class="d-block sidebar-item">
                        <i class="fas fa-calendar-check me-2"></i>Reservas
                    </a>
                    <a href="#" class="d-block sidebar-item">
                        <i class="fas fa-table me-2"></i>Mesas
                    </a>
                    <a href="#" class="d-block sidebar-item">
                        <i class="fas fa-users me-2"></i>Clientes
                    </a>
                    <a href="#" class="d-block sidebar-item">
                        <i class="fas fa-chart-pie me-2"></i>Relatórios
                    </a>
                </div>
            </nav>

            <main role="main" class="flex-grow-1 p-4">
                <div class="main-content p-4 hover-effect">
                    @hasSection('body')
                        @yield('body')
                    @endif
                </div>
            </main>
        </div>
        @endauth

        @guest
        <main role="main" class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
            <div class="col-md-8 col-lg-6">
                @hasSection('register')
                    <div class="main-content p-4 hover-effect">
                        @yield('register')
                    </div>
                @endif

                @hasSection('login')
                    <div class="main-content p-4 hover-effect">
                        @yield('login')
                    </div>
                @endif
            </div>
        </main>
        @endguest
    </div>

    @include('footer')

    @stack('scripts')
</body>
</html>
