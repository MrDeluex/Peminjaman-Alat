<nav class="space-y-6">

    {{-- Main --}}
    <div>
        <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Main
        </p>

        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('dashboard')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('dashboard') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="dashboard" />
            Dashboard
        </a>
    </div>


    {{-- Peminjaman --}}
    <div>
        <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Peminjaman
        </p>

        <a href="{{ route('peminjam.alat.index') }}"
            class="flex items-center gap-3 px-3 py-2 mb-1 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('peminjam.alat.*')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('peminjam.alat.*') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="alat" />
            Daftar Alat
        </a>

        <a href="{{ route('peminjam.peminjaman.index') }}"
            class="flex items-center gap-3 px-3 py-2 mb-1 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('peminjam.peminjaman.*')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('peminjam.peminjaman.*') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="peminjaman" />
            Peminjaman Saya
        </a>

        <a href="{{ route('peminjam.pengembalian.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('peminjam.pengembalian.*')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('peminjam.pengembalian.*') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="pengembalian" />
            Pengembalian
        </a>
    </div>

</nav>
