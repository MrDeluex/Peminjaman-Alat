<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 px-4">
        <div class="w-full max-w-4xl bg-white shadow-xl rounded-2xl overflow-hidden">

            <div class="grid grid-cols-1 lg:grid-cols-2">

                <!-- KIRI : INFO (DESKTOP ONLY) -->
                <div class="hidden lg:flex flex-col justify-center bg-gray-800 text-white p-10">
                    <h1 class="text-4xl font-extrabold leading-tight">
                        Verifikasi<br>
                        <span class="text-gray-300">Email</span>
                    </h1>

                    <p class="mt-4 text-gray-300 text-sm leading-relaxed">
                        Kami telah mengirimkan email verifikasi
                        ke alamat email Anda. Silakan periksa
                        inbox atau folder spam.
                    </p>

                    <ul class="mt-6 space-y-2 text-sm text-gray-300">
                        <li>✔ Satu akun, satu email</li>
                        <li>✔ Link verifikasi aman</li>
                        <li>✔ Akses penuh setelah verifikasi</li>
                    </ul>
                </div>

                <!-- KANAN : AKSI -->
                <div class="p-10">

                    <!-- Judul Mobile -->
                    <div class="text-center mb-8 lg:hidden">
                        <h1 class="text-3xl font-extrabold text-gray-800">
                            <span class="bg-gray-800 text-white px-4 py-1.5 rounded-lg">
                                Peminjaman
                            </span>
                            <span class="ml-2">Alat</span>
                        </h1>
                        <p class="text-sm text-gray-500 mt-3">
                            Verifikasi email Anda
                        </p>
                    </div>

                    <!-- Info -->
                    <div class="mb-6 text-sm text-gray-600">
                        Terima kasih telah mendaftar!
                        Sebelum memulai, mohon verifikasi
                        alamat email Anda terlebih dahulu.
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-6 text-sm font-medium text-green-600">
                            Tautan verifikasi baru telah dikirim ke email Anda.
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <!-- Resend -->
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <x-primary-button class="w-full sm:w-auto bg-gray-800 hover:bg-gray-900">
                                Kirim Ulang Email Verifikasi
                            </x-primary-button>
                        </form>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="text-sm text-gray-600 hover:text-gray-900 underline"
                            >
                                Log Out
                            </button>
                        </form>
                    </div>

                    <!-- FOOTER CARD -->
                    <div class="mt-10 pt-4 border-t text-center text-xs text-gray-400">
                        © 2026 Sistem Peminjaman Alat
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
