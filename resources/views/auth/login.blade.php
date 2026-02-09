<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 px-4">
        <div class="w-full max-w-4xl bg-white shadow-xl rounded-2xl overflow-hidden">

            <div class="grid grid-cols-1 lg:grid-cols-2">

                <!-- KIRI : DESKRIPSI (DESKTOP ONLY) -->
                <div class="hidden lg:flex flex-col justify-center bg-gray-800 text-white p-10">
                    <h1 class="text-4xl font-extrabold leading-tight">
                        Sistem<br>
                        <span class="text-gray-300">Peminjaman Alat</span>
                    </h1>

                    <p class="mt-4 text-gray-300 text-sm leading-relaxed">
                        Kelola peminjaman alat secara terstruktur, cepat,
                        dan aman. Dirancang untuk memudahkan admin
                        dalam monitoring data dan laporan.
                    </p>

                    <ul class="mt-6 space-y-2 text-sm text-gray-300">
                        <li>✔ Manajemen alat & peminjaman</li>
                        <li>✔ Monitoring status real-time</li>
                        <li>✔ Akses berbasis role</li>
                    </ul>
                </div>

                <!-- KANAN : FORM LOGIN -->
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
                            Silakan login untuk melanjutkan
                        </p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" class="block mt-2 w-full rounded-lg py-3" type="email"
                                name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" value="Password" />
                            <x-text-input id="password" class="block mt-2 w-full rounded-lg py-3" type="password"
                                name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember + Forgot -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-gray-300 text-gray-800 focus:ring-gray-800" name="remember">
                                <span class="ms-2 text-sm text-gray-600">
                                    Ingat Saya
                                </span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-sm font-medium text-gray-600 hover:text-gray-900">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Button -->
                        <div class="pt-6">
                            <x-primary-button
                                class="w-full justify-center py-3 text-base bg-gray-800 hover:bg-gray-900 rounded-lg">
                                Log in
                            </x-primary-button>
                        </div>
                        <!-- Register Link -->
                        <div class="text-center mt-4">
                            <p class="text-sm text-gray-600">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="font-medium text-gray-800 hover:underline">
                                    Daftar di sini
                                </a>
                            </p>
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
