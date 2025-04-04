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
