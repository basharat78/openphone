<nav x-data="{ open: false }" class="bg-[#111827]/80 backdrop-blur-md border-b border-gray-800 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('qc.dashboard') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black shadow-lg shadow-indigo-200">
                            QC
                        </div>
                        <span class="font-bold text-gray-100 text-lg tracking-tight">Panel</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden text-gray-100 space-x-8 sm:-my-px sm:ms-10 sm:flex ">
                    <x-nav-link 
                        :href="route('qc.dashboard')" 
                        :active="request()->routeIs('qc.dashboard')"
                        class="!text-gray-400 hover:!text-white transition-colors"
                    >
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link 
                        :href="route('qc.calls.index')" 
                        :active="request()->routeIs('qc.calls.*')"
                        class="!text-gray-400 hover:!text-white transition-colors"
                    >
                        {{ __('Calls') }}
                    </x-nav-link>

                    @if(Auth::user()->user_type === 'admin')
                    <x-nav-link 
                        :href="route('admin.dashboard.index')" 
                        class="!text-gray-400 hover:!text-white transition-colors"
                    >
                        {{-- <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg> --}}
                        {{ __('Admin Panel') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="flex items-center gap-3">
                    <div class="text-right hidden md:block">
                        <div class="text-sm font-bold text-gray-100">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-indigo-500 font-medium">QC Specialist</div>
                    </div>
                    
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center transition ease-in-out duration-150 focus:outline-none">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 border-2 border-white shadow-md flex items-center justify-center text-gray-600 font-bold hover:scale-105 transition-transform">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-gray-100 md:hidden">
                                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                            
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();" class="text-red-500 hover:bg-red-50 hover:text-red-700">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#111827] border-t border-gray-800 shadow-xl text-gray-100">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('qc.dashboard')" :active="request()->routeIs('qc.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('qc.calls.index')" :active="request()->routeIs('qc.calls.*')">
                {{ __('Calls') }}
            </x-responsive-nav-link>

            @if(Auth::user()->user_type === 'admin')
            <x-responsive-nav-link :href="route('admin.dashboard.index')" class="!text-amber-400 font-bold">
                {{ __('Return to Admin') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-800 bg-[#1f2937]/50">
            <div class="px-4 py-3">
                <div class="font-medium text-base text-gray-100">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 px-4 pb-4">
                <x-responsive-nav-link :href="route('profile.edit')" class="!text-gray-400 hover:!text-white hover:!bg-gray-800 transition-colors">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
             
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-red-500 hover:text-red-400 hover:!bg-red-900/20 transition-colors">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
