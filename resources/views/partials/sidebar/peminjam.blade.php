<nav class="space-y-1">
    <a href="{{ route('dashboard') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        🏠 Dashboard
    </a>

    <a href="{{ route('peminjam.alat.index') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        📦 Daftar Alat
    </a>

    <a href="{{ route('peminjam.peminjaman.index') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        📝 Peminjaman Saya
    </a>

    <a href="{{ route('peminjam.pengembalian.index') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        🔄 Pengembalian
    </a>
</nav>
