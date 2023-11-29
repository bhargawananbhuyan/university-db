<header class="bg-[#577590]">
    <div class="flex flex-col items-center p-8">
        <a href="{{ route('home') }}">
            <img src="/logo.png" alt="School Management Logo" class="max-w-[150px] w-full h-auto">
        </a>

        <nav class="grid gap-y-3.5 text-center mt-8 text-white">
            <a href="{{ route('home') }}" @class(['text-yellow-500' => Route::is('home')])>Home</a>

            @guest
                <a href="{{ route('contact') }}" @class(['text-yellow-500' => Route::is('contact')])>Contact</a>
                <a href="{{ route('login') }}" @class(['text-yellow-500' => Route::is('login')])>Login</a>
                <a href="{{ route('register') }}" @class(['text-yellow-500' => Route::is('register')])>Register</a>
            @endguest

            @auth
                @include('inc.auth-nav')
                <a href="{{ route(Auth::user()->role . '.profile') }}" @class([
                    'text-yellow-500' => Route::is(Auth::user()->role . '.profile'),
                ])>
                    Profile
                </a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <input type="submit" value="Logout" class="bg-red-500 text-sm font-medium px-2.5 py-2 rounded">
                </form>
            @endauth
        </nav>
    </div>
</header>
