<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Pixel Fox')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
            background-image: url('{{ asset('images/background.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }
    </style>

    @stack('head')
</head>
<body class="text-gray-800 min-h-screen flex flex-col">

<!-- Main Content -->
<main class="flex-grow container mx-auto px-4 py-6 rounded-xl shadow-lg">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-white bg-opacity-80 shadow p-4 mt-8 text-center text-sm text-gray-500 rounded-xl">
    &copy; {{ date('Y') }} Pixel Fox by Tomasz Zymni (tomasz.zymni@gmail.com)
</footer>

<script>
    window.Laravel = {
        pusherKey: "{{ $pusherKey}}",
        pusherCluster: "{{ $pusherCluster }}"
    };
</script>

<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
