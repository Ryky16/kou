<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo de la Mairie -->
                <div class="shrink-0 flex items-center">
                    <a href="
                        @if (Auth::user()->hasRole('Administrateur'))
                            {{ route('admin.dashboard') }}
                        @elseif (Auth::user()->hasRole('Secretaire_Municipal'))
                            {{ route('secretaire.dashboard') }}
                        @elseif (Auth::user()->hasRole('Agent'))
                            {{ route('agent.dashboard') }}
                        @else
                            {{ route('home') }}
                        @endif
                    ">
                        <img src="/images/logo.png" alt="Logo de la Mairie" class="h-9 w-auto">
                    </a>
                </div>
            </div>

            <!-- Menu de Profil -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center">
                                <i class="fas fa-user-circle mr-2 text-gray-600"></i>
                                <div>{{ Auth::user()->name }}</div>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-user-circle mr-2"></i> Profil
                        </x-dropdown-link>

                        <!-- Déconnexion -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-sign-out-alt mr-2"></i> Se déconnecter
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Menu (Pour les écrans mobiles) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 focus:text-gray-900 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-user-circle mr-2"></i> Profil
                </x-responsive-nav-link>

                <!-- Déconnexion -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-sign-out-alt mr-2"></i> Se déconnecter
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    
</nav>