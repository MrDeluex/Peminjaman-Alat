<nav class="space-y-1">
    <a href="{{ route('dashboard') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        🏠 Dashboard
    </a>

    <a href="{{ route('admin.users.index') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        👥 Kelola User
    </a>

    <a href="{{ route('admin.alat.index') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        📦 Kelola Alat
    </a>
    
    <a href="{{ route('admin.kategori.index') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        📦 Kelola Kategori
    </a>
    
    <a href="{{ route('admin.peminjaman.index') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        📦 Data Peminjaman
    </a>
    
    <a href="{{ route('admin.pengembalian.index') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        📦 Data Pengambilan
    </a>

    <a href="{{ route('admin.log.index') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        📊 Log Aktivitas
    </a>
</nav>
