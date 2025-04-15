<nav class="flex justify-between px-10 py-4">
    <ul class="flex gap-4">
        <li><a href={{route('home')}} class="text-3xl font-medium dark:text-white flex gap-2 items-center">
            <img src="dhani-pawan.jpg" alt="i'm rich mf" class="w-20 rounded-xl">
            Dhani Pawan</a></li>
    </ul>

    <ul class="flex gap-4">
        @auth
            <li><a href="/profile" class="text-xl font-medium dark:text-white">👤{{ Auth::user()->name }}</a></li>
        @else
            <li><a href="/login" class="text-lg font-medium dark:text-white">👤Login</a></li>
            <li><a href="/register" class="text-lg font-medium dark:text-white">👤Register</a></li>
        @endauth
        <li><a href="/cart" class="text-2xl font-medium dark:text-white">🛒Cart</a></li>
    </ul>
</nav>
