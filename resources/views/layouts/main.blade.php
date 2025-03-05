<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CineMagic</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=alexandria:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts AND CSS Fileds -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-neutral-100 dark:bg-neutral-900 overflow-hidden">

        <!-- Navigation Menu -->
        <nav class="bg-neutral-100 dark:bg-neutral-900 px-20 border-t-4 z-50 border-neutral-100 dark:border-neutral-900">
            <!-- Navigation Menu Full Container -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Logo + Menu Items + Hamburger -->
                <div class="relative flex flex-col sm:flex-row px-6 sm:px-0 grow justify-between">
                    <!-- Logo -->
                    <div class="shrink-0 -ms-4 mt-1 mr-10">
                        <a href="{{ route('home')}}" class="flex items-center gap-1">
                            <div class="h-14 w-14 bg-cover bg-[url('../img/logo.png')]"></div>
                            <span class="font-bold dark:text-white text-2xl">Cine<span class="text-2xl font-extrabold uppercase bg-clip-text text-transparent bg-gradient-to-r from-red-500 to-yellow-300">Magic</span></span>
                        </a>
                    </div>

                    <!-- Menu Items -->
                    <div id="menu-container" class="grow flex flex-col w-full justify-between sm:flex-row items-stretch invisible h-0 sm:visible sm:h-auto">
                        <div class="flex gap-2">
                            <x-menus.menu-item content="Cartaz" selectable="1" href="{{ route('cartaz') }}" selected="{{ Route::currentRouteName() == 'cartaz'}}" />
                            @if (Auth::check() && Auth::user()->type == 'A')
                                <x-menus.menu-item content="Filmes" selectable="1" href="{{ route('filmes') }}" selected="{{ Route::currentRouteName() == 'filmes'}}" />
                                <x-menus.menu-item content="Dashboard" selectable="1" href="{{ route('dashboard') }}" selected="{{ Route::currentRouteName() == 'dashboard'}}" />
                            @endif
                            @if (Auth::check() && Auth::user()->type == 'C')
                                <x-menus.menu-item content="Bilhetes" selectable="1" href="{{ route('bilhetes') }}" selected="{{ Route::currentRouteName() == 'bilhetes'}}" />
                            @endif

                        </div>

                        <div class="grow"></div>

                        <div class="flex flex-grow justify-end">
                            <form action="{{ route('movies.search') }}" method="GET" class="flex justify-center items-center w-full h-full">
                                <div class="relative">
                                    <input type="text" name="q" placeholder="Procure por um filme..." class="border-t-transparent border-l-transparent border-r-transparent border-b-2 text-neutral-900 dark:text-neutral-200 border-neutral-300 focus:border-neutral-500 dark:border-neutral-500 dark:focus:border-neutral-300 bg-neutral-100 dark:bg-neutral-900 placeholder-neutral-400 focus:placeholder-neutral-500 focus:outline-none focus:ring-0 focus:border-t-transparent focus:border-l-transparent focus:border-r-transparent text-lg px-2 py-1" value="{{ request()->get('q') }}" >
                                </div>
                                <button type="submit" class="ml-3 text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 hover:dark:text-neutral-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                    <span class="sr-only">Pesquisar</span>
                                </button>
                            </form>
                            @php
                                $cart = session('cart');
                            @endphp

                            @if ($cart && is_array($cart))
                                <x-menus.cart
                                    :href="route('cart.show')"
                                    selectable="1"
                                    selected="{{ Route::currentRouteName() == 'cart.show'}}"
                                    :total="count($cart)"/>
                            @endif

                            @auth
                            <x-menus.submenu selectable="0" uniqueName="submenu_user">
                                <x-slot:content>
                                    <div class="pe-1">
                                        <img src="{{ Auth::user()->photoFullUrl}}" class="w-11 h-11 min-w-11 min-h-11 rounded-full">
                                    </div>
                                </x-slot>
                                <x-menus.sub-menu-item content="Estatísticas" selectable="0" href="{{ route('statistics.average_sales_per_movie') }}" />


                                {{-- <x-menus.sub-menu-item content="My Teachers" selectable="0" href="#"/>
                                <x-menus.sub-menu-item content="My Students" selectable="0" href="#"/>
                                <hr> --}}
                                <x-menus.sub-menu-item content="Profile" selectable="0" href="{{ route('profile.edit') }}"/>
                                @if (Auth::check() && Auth::user()->type == 'A')
                                    <x-menus.sub-menu-item content="Dashboard" selectable="0" href="{{ route('dashboard') }}"/>
                                @endif
                                <hr>
                                <form id="form_to_logout_from_menu" method="POST" action="{{ route('logout') }}"
                                    class="hidden">
                                        @csrf
                                </form>
                                <a class="px-3 py-4 border-b-2 border-transparent
                                        text-sm font-medium leading-5 inline-flex h-auto
                                        text-neutral-500 dark:text-neutral-400
                                        hover:text-neutral-700 dark:hover:text-neutral-300
                                        hover:bg-neutral-100 dark:hover:bg-neutral-800
                                        focus:outline-none
                                        focus:text-neutral-700 dark:focus:text-neutral-300
                                        focus:bg-neutral-100 dark:focus:bg-neutral-800"
                                    href="#"
                                    onclick="event.preventDefault();
                                    document.getElementById('form_to_logout_from_menu').submit();">
                                    Log Out
                                </a>
                            </x-menus.submenu>
                            @else
                            <!-- Menu Item: Login -->
                            {{-- <x-menus.menu-item
                                content="Login"
                                selectable="1"
                                href="{{ route('login') }}"
                                selected="{{ Route::currentRouteName() == 'login'}}"
                            /> --}}
                            <div class="flex justify-end items-center w-full h-full gap-4">
                                <x-button element="a" type="warning" text="Login" href="{{ route('login') }}"/>
                                <x-button element="a" type="dark" text="Register" href="{{ route('register') }}"/>
                            </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="absolute right-0 top-0 flex sm:hidden pt-3 pe-3 text-black dark:text-gray-50">
                        <button id="hamburger_btn">
                            <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path id="hamburger_btn_open" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                <path class="invisible" id="hamburger_btn_close" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                @if (session('alert-msg'))
                    <x-alert type="{{ session('alert-type') ?? 'info' }}">
                        {!! session('alert-msg') !!}
                    </x-alert>
                @endif
                @if (!$errors->isEmpty())
                        <x-alert type="warning" message="Operation failed because there are validation errors!"/>
                @endif
                @yield('main')
            </div>
        </main>
    </div>
</body>

</html>
