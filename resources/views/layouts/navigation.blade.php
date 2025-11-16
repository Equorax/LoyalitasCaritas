<nav x-data="{ open: false }">
    <!-- Primary Navigation Menu -->
    <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8 bg-sky-700">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Link Dashboard dan Input Nomor Transaksi untuk Pelanggan -->
                    @if(Auth::check() && Auth::user()->isPelanggan())
                        <x-nav-link :href="route('dashboard.pelanggan')" :active="request()->routeIs('dashboard.pelanggan')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('input.nomor.transaksi')" :active="request()->routeIs('input.nomor.transaksi')">
                            {{ __('Input Nomor Transaksi') }}
                        </x-nav-link>
                        <!-- Link Upload Transaksi untuk Karyawan -->
                        @auth
                           
                        @endauth
                    @endif

                    <!-- Link Daftar Pelanggan untuk Karyawan -->
                    @if(Auth::check() && Auth::user()->isKaryawan())
                        <x-nav-link :href="route('dashboard.karyawan')" :active="request()->routeIs('dashboard.karyawan')">
                            {{ __('Daftar Pelanggan') }}
                        </x-nav-link>
                    @endif

                     @if(Auth::check() && Auth::user()->isKaryawan())
                            <!-- Tambahkan link Responsive Tabel Validitas Transaksi -->
                            <x-nav-link :href="route('validitas.transaksi')" :active="request()->routeIs('validitas.transaksi')">
                                {{ __('Tabel Validitas Transaksi') }}
                            </x-nav-link>
                        @endif

                     @if(Auth::user()->isKaryawan())
                                <x-nav-link :href="route('upload.transaksi.form')" :active="request()->routeIs('upload.transaksi.form')">
                                    {{ __('Upload Transaksi') }}
                                </x-nav-link>
                     @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white dark:text-white bg-sky-700 dark:bg-sky-700 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content" class="dark:bg-sky-700">
                        <!-- <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link> -->

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white focus:outline-none focus:text-white transition duration-150 ease-in-out">
                    <!-- Ikon Hamburger dan Close -->
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <!-- Ikon Hamburger (muncul saat menu tertutup) -->
                        <path :class="{'hidden': open, 'inline-flex': ! open}"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <!-- Ikon Close (muncul saat menu terbuka) -->
                        <path :class="{'hidden': ! open, 'inline-flex': open}"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-sky-700">
            <!-- Link Responsive untuk Pelanggan -->
            @if(Auth::check() && Auth::user()->isPelanggan())
                <x-responsive-nav-link :href="route('dashboard.pelanggan')" :active="request()->routeIs('dashboard.pelanggan')" class="text-white">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('input.nomor.transaksi')" :active="request()->routeIs('input.nomor.transaksi')">
                    {{ __('Input Nomor Transaksi') }}
                </x-responsive-nav-link>
                <!-- Link Responsive Upload Transaksi untuk Karyawan -->
                @auth
                   
                @endauth
            @endif

            <!-- Link Responsive Daftar Pelanggan untuk Karyawan -->
            @if(Auth::check() && Auth::user()->isKaryawan())
                <x-responsive-nav-link :href="route('dashboard.karyawan')" :active="request()->routeIs('dashboard.karyawan')">
                    {{ __('Daftar Pelanggan') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::check() && Auth::user()->isKaryawan())
                        <!-- Tambahkan link Responsive Tabel Validitas Transaksi -->
                        <x-responsive-nav-link :href="route('validitas.transaksi')" :active="request()->routeIs('validitas.transaksi')">
                            {{ __('Tabel Validitas Transaksi') }}
                        </x-responsive-nav-link>
            @endif
             @if(Auth::user()->isKaryawan())
                        <x-responsive-nav-link :href="route('upload.transaksi.form')" :active="request()->routeIs('upload.transaksi.form')">
                            {{ __('Upload Transaksi') }}
                        </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 dark:bg-sky-700">
            <div class="px-4">
                <div class="font-medium text-base text-white dark:text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1 dark:bg-sky-700">
                <!-- <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link> -->

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>