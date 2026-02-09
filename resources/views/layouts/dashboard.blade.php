<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Peminjaman Alat</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r shadow-sm fixed inset-y-0 left-0 z-40 flex flex-col">
            <div class="h-16 flex items-center justify-center border-b font-bold text-lg shrink-0 gap-1">
                <span class="bg-gray-800 text-white px-3 py-1 mr-1 rounded">
                    Peminjaman
                </span>
                <span class="text-gray-800">
                    Alat
                </span>
            </div>


            {{-- Sidebar per role --}}
            <div class="p-4">
                @auth
                    @if (auth()->user()->role === 'admin')
                        @include('partials.sidebar.admin')
                    @elseif (auth()->user()->role === 'petugas')
                        @include('partials.sidebar.petugas')
                    @else
                        @include('partials.sidebar.peminjam')
                    @endif
                @endauth
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col ml-64">
            {{-- Header --}}
            <header x-data="{ open: false }"
                class="h-16 bg-white border-b flex items-center justify-between px-6 shadow-sm
               sticky top-0 z-30">

                {{-- Left: Page Title --}}
                <h1 class="text-lg font-semibold text-gray-800">
                    @yield('header', 'Dashboard')
                </h1>

                {{-- Right: Dropdown Profile --}}
                <div class="flex items-center gap-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition">
                                {{-- Avatar --}}
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm font-bold">
                                    {{ strtoupper(substr(auth()->user()->username ?? auth()->user()->email, 0, 1)) }}
                                </div>

                                {{-- Name --}}
                                <div class="hidden sm:block text-sm font-medium text-gray-700">
                                    {{ auth()->user()->username ?? auth()->user()->email }}
                                </div>

                                {{-- Chevron --}}
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Profile --}}
                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>

                            {{-- Role Info (opsional, read-only) --}}
                            <div class="px-4 py-2 text-xs text-gray-400">
                                Role: {{ auth()->user()->role }}
                            </div>

                            <div class="border-t"></div>

                            {{-- Logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Logout
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>



            {{-- Flash Message --}}
            <main class="flex-1 p-6 overflow-y-auto">
                @if (session('success'))
                    <div class="mb-4 rounded bg-green-100 border border-green-300 text-green-800 px-4 py-2">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded bg-red-100 border border-red-300 text-red-800 px-4 py-2">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <x-confirm-modal />
</body>
</html>
