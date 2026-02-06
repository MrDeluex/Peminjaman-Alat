<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Peminjaman Alat</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r">
            <div class="h-16 flex items-center justify-center border-b font-bold text-lg">
                Peminjaman Alat
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
        <div class="flex-1 flex flex-col">
            {{-- Header --}}
            <header class="h-16 bg-white border-b flex items-center justify-between px-6">
                <div class="font-semibold text-gray-700">
                    @yield('header', 'Dashboard')
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600">
                        {{ auth()->user()->username ?? auth()->user()->email }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:underline">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
