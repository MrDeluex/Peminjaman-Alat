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


    {{-- Operasional --}}
    <div>
        <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Operasional
        </p>

        <a href="{{ route('petugas.alat.index') }}"
            class="flex items-center gap-3 px-3 py-2 mb-1 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('petugas.alat.*')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('petugas.alat.*') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="alat" />
            Data Alat
        </a>

        <a href="{{ route('petugas.peminjaman.index') }}"
            class="flex items-center gap-3 px-3 py-2 mb-1 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('petugas.peminjaman.*')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('petugas.peminjaman.*') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="peminjaman" />
            Kelola Peminjaman
        </a>

        <a href="{{ route('petugas.pengembalian.index') }}"
            class="flex items-center gap-3 px-3 py-2 mb-1 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('petugas.pengembalian.*')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('petugas.pengembalian.*') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="pengembalian" />
            Kelola Pengembalian
        </a>
    </div>


    {{-- Laporan --}}
    <div>
        <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Laporan
        </p>

        <a href="{{ route('petugas.pengembalian.history') }}"
            class="flex items-center gap-3 px-3 py-2 mb-1 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('petugas.pengembalian.history')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('petugas.pengembalian.history') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="history" />
            History Pengembalian
        </a>

        <a href="{{ route('petugas.laporan.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('petugas.laporan.*')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('petugas.laporan.*') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="report" />
            Laporan
        </a>
    </div>

</nav>
