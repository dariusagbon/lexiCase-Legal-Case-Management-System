<nav x-data="{ open: false }" style="background:var(--navy); border-bottom:1px solid rgba(255,255,255,0.07);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-10">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
                    <span class="serif text-white text-lg tracking-wide" style="font-style:italic;">LexiCase</span>
                </a>

                {{-- Desktop nav links --}}
                <div class="hidden sm:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                        Dashboard
                    </a>
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('cases.index') }}"
                       class="nav-link {{ request()->routeIs('cases.*') ? 'nav-active' : '' }}">
                        Cases
                    </a>
                    <a href="{{ route('lawyers.index') }}"
                       class="nav-link {{ request()->routeIs('lawyers.*') ? 'nav-active' : '' }}">
                        Lawyers
                    </a>
                    @endif
                </div>
            </div>

            {{-- Right side --}}
            <div class="hidden sm:flex items-center gap-3">
                <span class="text-xs" style="color:rgba(255,255,255,0.35);">{{ now()->format('D, d M Y') }}</span>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                        class="flex items-center gap-2 px-3 py-1.5 rounded text-sm transition"
                        style="color:rgba(255,255,255,0.75); hover:background:rgba(255,255,255,0.06);">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-semibold"
                             style="background:var(--gold); color:var(--navy);">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-3.5 h-3.5 transition-transform" :class="{'rotate-180': open}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-1 w-44 rounded shadow-lg z-50 py-1"
                         style="background:#1a2b42; border:1px solid rgba(255,255,255,0.1); display:none;">
                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-2 text-sm transition"
                           style="color:rgba(255,255,255,0.7);">
                            Profile
                        </a>
                        <div style="border-top:1px solid rgba(255,255,255,0.08);" class="my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm transition"
                                    style="color:#f87171;">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mobile hamburger --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded text-white/50 hover:text-white hover:bg-white/5 transition">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden" style="border-top:1px solid rgba(255,255,255,0.07);">
        <div class="px-4 pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded text-sm text-white/70 hover:bg-white/5 hover:text-white transition">Dashboard</a>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('cases.index') }}" class="block px-3 py-2 rounded text-sm text-white/70 hover:bg-white/5 hover:text-white transition">Cases</a>
            <a href="{{ route('lawyers.index') }}" class="block px-3 py-2 rounded text-sm text-white/70 hover:bg-white/5 hover:text-white transition">Lawyers</a>
            @endif
        </div>
        <div class="px-4 pt-3 pb-4" style="border-top:1px solid rgba(255,255,255,0.07);">
            <div class="text-sm text-white font-medium">{{ Auth::user()->name }}</div>
            <div class="text-xs mt-0.5" style="color:rgba(255,255,255,0.4);">{{ Auth::user()->email }}</div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded text-sm text-white/70 hover:bg-white/5 hover:text-white transition">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded text-sm transition" style="color:#f87171;">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    .nav-link {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.85rem;
        border-radius: 4px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: rgba(255,255,255,0.55);
        letter-spacing: 0.01em;
        transition: color 0.15s, background 0.15s;
    }
    .nav-link:hover { color: rgba(255,255,255,0.9); background: rgba(255,255,255,0.05); }
    .nav-active { color: var(--gold) !important; background: rgba(201,168,76,0.1) !important; }
</style>