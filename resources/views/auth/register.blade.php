<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 px-4">
        <div class="w-full max-w-4xl bg-white shadow-xl rounded-2xl overflow-hidden">

            <div class="grid grid-cols-1 lg:grid-cols-2">

                <!-- KIRI : DESKRIPSI (DESKTOP ONLY) -->
                <div class="hidden lg:flex flex-col justify-center bg-gray-800 text-white p-10">
                    <h1 class="text-4xl font-extrabold leading-tight">
                        Buat<br>
                        <span class="text-gray-300">Akun Baru</span>
                    </h1>

                    <p class="mt-4 text-gray-300 text-sm leading-relaxed">
                        Daftarkan akun untuk mengakses sistem
                        peminjaman alat secara penuh dan terstruktur.
                    </p>

                    <ul class="mt-6 space-y-2 text-sm text-gray-300">
                        <li>✔ Akses cepat & aman</li>
                        <li>✔ Manajemen peminjaman terpusat</li>
                        <li>✔ Role & hak akses terkontrol</li>
                    </ul>
                </div>

                <!-- KANAN : FORM REGISTER -->
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
                            Buat akun baru untuk melanjutkan
                        </p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Username -->
                        <div>
                            <x-input-label for="username" value="Username" />
                            <x-text-input
                                id="username"
                                class="block mt-2 w-full rounded-lg py-3"
                                type="text"
                                name="username"
                                :value="old('username')"
                                required
                                autofocus
                                autocomplete="username"
                            />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

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
                                autocomplete="username"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" value="Password" />
                            <x-text-input
                                id="password"
                                class="block mt-2 w-full rounded-lg py-3"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                            <x-text-input
                                id="password_confirmation"
                                class="block mt-2 w-full rounded-lg py-3"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                            />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Action -->
                        <div class="flex items-center justify-between pt-4">
                            <a
                                href="{{ route('login') }}"
                                class="text-sm text-gray-600 hover:text-gray-900"
                            >
                                Sudah punya akun?
                            </a>

                            <x-primary-button class="px-6 py-3 bg-gray-800 hover:bg-gray-900 rounded-lg">
                                Register
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
