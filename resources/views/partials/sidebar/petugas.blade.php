<nav class="space-y-1">
    <a href="{{ route('dashboard') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        🏠 Dashboard
    </a> 

    <a href="{{ route('petugas.peminjaman.index') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        📋 Kelola Peminjaman
    </a>

     <a href="{{ route('petugas.pengembalian.index') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        🛠️ Kelola Pengembalian
    </a>
     <a href="{{ route('petugas.pengembalian.history') }}"
       class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
        🛠️ History Pengembalian
    </a>


    
</nav>
