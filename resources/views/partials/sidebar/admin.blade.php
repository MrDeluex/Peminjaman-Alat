<nav class="space-y-6">

    {{-- Main Menu --}}
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


    {{-- Data Master --}}
    <div>
        <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Data Master
        </p>

        <a href="{{ route('admin.users.index') }}"
            class="flex items-center gap-3 px-3 py-2 mb-1 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('admin.users.*')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('admin.users.*') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="user" />
            Kelola User
        </a>

        <a href="{{ route('admin.alat.index') }}"
            class="flex items-center gap-3 px-3 py-2 mb-1 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('admin.alat.*')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('admin.alat.*') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="alat" />
            Kelola Alat
        </a>

        <a href="{{ route('admin.kategori.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200
        {{ request()->routeIs('admin.kategori.*')
            ? 'bg-gray-800 text-white font-semibold'
            : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('admin.kategori.*') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="kategori" />
            Kelola Kategori
        </a>
    </div>


    {{-- Transaksi --}}
    <div>
        <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Transaksi
        </p>

        <a href="{{ route('admin.peminjaman.index') }}"
            class="flex items-center gap-3 px-3 py-2 mb-1 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('admin.peminjaman.*')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('admin.peminjaman.*') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="peminjaman" />
            Data Peminjaman
        </a>

        <a href="{{ route('admin.pengembalian.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('admin.pengembalian.*')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('admin.pengembalian.*') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="pengembalian" />
            Data Pengembalian
        </a>
    </div>


    {{-- Laporan --}}
    <div>
        <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Lainnya
        </p>

        <a href="{{ route('admin.log.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200
           {{ request()->routeIs('admin.log.*')
               ? 'bg-gray-800 text-white font-semibold'
               : 'text-gray-500 hover:bg-gray-900 hover:text-white' }}">

            <span
                class="w-1 h-5 rounded-full {{ request()->routeIs('admin.log.*') ? 'bg-white' : 'bg-transparent' }}"></span>
            <x-icon name="activity" />
            Log Aktivitas
        </a>
    </div>

</nav>
