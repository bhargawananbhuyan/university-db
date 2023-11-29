<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head_scripts')
</head>

<body class="min-h-screen flex flex-col">
    @if (session('success'))
        <div id="toast" class="fixed w-full top-5 left-0 grid place-items-center">
            <p class="max-w-sm w-full mx-auto text-sm font-medium p-2 rounded shadow bg-green-500 text-white">
                {{ session('success') }}
            </p>
        </div>
    @endif

    <main class="flex-grow flex">
        <div class="flex-grow grid grid-cols-[300px_auto]">
            @include('inc.header')
            @yield('main')
        </div>
    </main>
    @include('inc.footer')
    @stack('body_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('toast');
            toast.style.display = 'block';
            setTimeout(() => {
                toast.style.display = 'none'
            }, 2000);
        });
    </script>
</body>

</html>
