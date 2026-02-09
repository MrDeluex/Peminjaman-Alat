<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 px-4">
        <div class="w-full max-w-4xl bg-white shadow-xl rounded-2xl overflow-hidden">

            <div class="grid grid-cols-1 lg:grid-cols-2">

                <!-- KIRI : DESKRIPSI (DESKTOP ONLY) -->
                <div class="hidden lg:flex flex-col justify-center bg-gray-800 text-white p-10">
                    <h1 class="text-4xl font-extrabold leading-tight">
                        Reset<br>
                        <span class="text-gray-300">Password</span>
                    </h1>

                    <p class="mt-4 text-gray-300 text-sm leading-relaxed">
                        Lupa password bukan masalah.
                        Masukkan email terdaftar, kami akan mengirimkan
                        link untuk mengatur ulang password akun Anda.
                    </p>

                    <ul class="mt-6 space-y-2 text-sm text-gray-300">
                        <li>✔ Link reset aman & sekali pakai</li>
                        <li>✔ Berlaku dalam waktu terbatas</li>
                        <li>✔ Akun tetap terlindungi</li>
                    </ul>
                </div>

                <!-- KANAN : FORM -->
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
                            Reset password akun Anda
                        </p>
                    </div>

                    <!-- Info -->
                    <div class="mb-6 text-sm text-gray-600">
                        Lupa password? Masukkan email kamu, kami akan
                        mengirimkan link reset password.
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                        @csrf

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input
                                id="email"
                                class="block mt-2 w-full rounded-lg py-3"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Button -->
                        <div class="pt-4">
                            <x-primary-button class="w-full justify-center py-3 text-base bg-gray-800 hover:bg-gray-900 rounded-lg">
                                Kirim Link Reset Password
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- FOOTER CARD -->
                    <div class="mt-10 pt-4 border-t text-center text-xs text-gray-400">
                        © 2026 Sistem Peminjaman Alat
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
