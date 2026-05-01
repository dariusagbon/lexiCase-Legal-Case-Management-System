<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'LexiCase') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-serif-display:400,400i|instrument-sans:400,500,600&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            :root {
                --navy:   #0b1628;
                --navy-2: #132040;
                --gold:   #c9a84c;
                --gold-l: #e8c97a;
                --cream:  #f5f1eb;
                --muted:  #8a9ab5;
            }

            /* ── Base ─────────────────────────────────── */
            body { font-family: 'Instrument Sans', sans-serif; }

            .font-display { font-family: 'DM Serif Display', Georgia, serif; }

            /* ── Noise texture overlay ────────────────── */
            .noise::before {
                content: '';
                position: absolute;
                inset: 0;
                background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
                background-size: 200px;
                opacity: 0.35;
                pointer-events: none;
                z-index: 0;
            }

            /* ── Hero gradient ────────────────────────── */
            .hero-bg {
                background:
                    radial-gradient(ellipse 80% 60% at 50% -10%, #1e3a6e 0%, transparent 70%),
                    linear-gradient(180deg, var(--navy) 0%, #0d1e38 100%);
            }

            /* ── Gold divider ─────────────────────────── */
            .gold-line {
                width: 48px; height: 2px;
                background: var(--gold);
                display: block; margin: 0 auto;
            }

            /* ── Stat card ───────────────────────────── */
            .stat-card {
                border: 1px solid rgba(201,168,76,.2);
                background: rgba(255,255,255,.03);
                backdrop-filter: blur(8px);
            }

            /* ── Lawyer card ─────────────────────────── */
            .lawyer-card {
                transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
                border: 1px solid #e8e4dc;
            }
            .lawyer-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 24px 48px rgba(11,22,40,.10);
                border-color: var(--gold);
            }

            /* ── Avatar ring ─────────────────────────── */
            .avatar-ring {
                background: linear-gradient(135deg, var(--navy-2), var(--navy));
                box-shadow: 0 0 0 3px var(--gold), 0 8px 24px rgba(11,22,40,.25);
            }

            /* ── Table row hover ─────────────────────── */
            .case-row { transition: background .15s; }
            .case-row:hover { background: #f8f5ef; }

            /* ── CTA gradient ────────────────────────── */
            .cta-bg {
                background:
                    radial-gradient(ellipse 60% 80% at 100% 50%, #1e3a6e 0%, transparent 65%),
                    linear-gradient(135deg, var(--navy) 0%, #0d1e38 100%);
            }

            /* ── Blur teaser ─────────────────────────── */
            .blur-overlay {
                filter: blur(5px);
                pointer-events: none;
                user-select: none;
            }

            /* ── Badge pill ──────────────────────────── */
            .hero-badge {
                background: rgba(201,168,76,.12);
                border: 1px solid rgba(201,168,76,.35);
                color: var(--gold-l);
                letter-spacing: .04em;
            }

            /* ── Fade-up animation ───────────────────── */
            @keyframes fadeUp {
                from { opacity: 0; transform: translateY(20px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            .fade-up   { animation: fadeUp .7s ease both; }
            .delay-100 { animation-delay: .10s; }
            .delay-200 { animation-delay: .20s; }
            .delay-300 { animation-delay: .30s; }
            .delay-400 { animation-delay: .40s; }

            /* ── Nav link ────────────────────────────── */
            .nav-link {
                position: relative;
                padding-bottom: 2px;
            }
            .nav-link::after {
                content: '';
                position: absolute; left: 0; bottom: 0;
                width: 0; height: 1px;
                background: var(--gold);
                transition: width .25s ease;
            }
            .nav-link:hover::after { width: 100%; }

            /* ── Primary button ──────────────────────── */
            .btn-primary {
                background: var(--gold);
                color: var(--navy);
                font-weight: 600;
                transition: background .2s, box-shadow .2s, transform .15s;
            }
            .btn-primary:hover {
                background: var(--gold-l);
                box-shadow: 0 8px 24px rgba(201,168,76,.35);
                transform: translateY(-1px);
            }

            /* ── Ghost button ────────────────────────── */
            .btn-ghost {
                border: 1px solid rgba(255,255,255,.25);
                color: #fff;
                transition: background .2s, border-color .2s;
            }
            .btn-ghost:hover {
                background: rgba(255,255,255,.08);
                border-color: rgba(255,255,255,.5);
            }

            /* ── Section label ───────────────────────── */
            .section-label {
                color: var(--gold);
                font-size: .7rem;
                font-weight: 600;
                letter-spacing: .12em;
                text-transform: uppercase;
            }

            /* ── Outcome badge ───────────────────────── */
            .badge-resolved {
                background: #d1fae5;
                color: #065f46;
                font-size: .7rem;
                font-weight: 600;
                letter-spacing: .04em;
                padding: 2px 10px;
                border-radius: 999px;
            }
        </style>
    </head>

    <body class="bg-white text-[#1b1b18] min-h-screen flex flex-col antialiased">

        {{-- ═══════════════════════════════════════ NAVBAR ══ --}}
        <header class="w-full px-6 lg:px-20 py-4 flex items-center justify-between bg-[var(--navy)] sticky top-0 z-50 border-b border-white/5 shadow-lg shadow-black/20">

            {{-- Brand --}}
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto brightness-0 invert">
                <span class="font-display text-lg text-white tracking-wide">LexiCase</span>
            </div>

            {{-- Nav links --}}
            <nav class="hidden lg:flex items-center gap-10 text-sm text-[var(--muted)]">
                <a href="#lawyers" class="nav-link hover:text-white transition-colors">Our Lawyers</a>
                <a href="#cases"   class="nav-link hover:text-white transition-colors">Resolved Cases</a>
                <a href="#contact" class="nav-link hover:text-white transition-colors">Contact</a>
            </nav>

            {{-- Auth --}}
            @if (Route::has('login'))
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="btn-primary px-5 py-2 rounded text-sm">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm text-[var(--muted)] hover:text-white transition-colors px-3 py-2">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="btn-primary px-5 py-2 rounded text-sm">
                                Register as Lawyer
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </header>


        {{-- ═══════════════════════════════════════ HERO ══ --}}
        <section class="hero-bg noise relative text-white px-6 lg:px-20 py-28 lg:py-44 text-center overflow-hidden">

            {{-- Decorative circle glows --}}
            <div class="absolute top-[-120px] left-1/2 -translate-x-1/2 w-[700px] h-[700px] rounded-full bg-blue-700/10 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-[-80px] right-[-80px] w-[400px] h-[400px] rounded-full bg-[var(--gold)]/5 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl mx-auto">
                <span class="hero-badge inline-flex items-center gap-2 text-xs font-semibold px-4 py-1.5 rounded-full mb-7 fade-up">
                    ⚖️ Professional Legal Case Management for Lawyers
                </span>

                <h1 class="font-display text-5xl lg:text-7xl leading-[1.1] mb-6 fade-up delay-100">
                    Manage Your Legal Cases<br>
                    <em class="not-italic" style="color: var(--gold-l);">Smarter &amp; Faster</em>
                </h1>

                <p class="text-white/60 text-base lg:text-lg max-w-2xl mx-auto mb-10 leading-relaxed fade-up delay-200">
                    A comprehensive legal case management platform designed specifically for lawyers.
                    Register as a legal professional, claim available cases, and manage your practice efficiently.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 fade-up delay-300">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="btn-primary px-8 py-3 rounded text-sm w-full sm:w-auto">
                            Go to Dashboard →
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="btn-primary px-8 py-3 rounded text-sm w-full sm:w-auto">
                                Register as Lawyer →
                            </a>
                        @endif
                        <a href="{{ route('login') }}"
                            class="btn-ghost px-8 py-3 rounded text-sm w-full sm:w-auto">
                            Log in to Your Account
                        </a>
                    @endauth
                </div>
            </div>
        </section>


        {{-- ═══════════════════════════════════════ STATS ══ --}}
        <section class="bg-[var(--navy)] px-6 lg:px-20 py-12 border-t border-white/5">
            <div class="max-w-5xl mx-auto grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach([
                    [$totalLawyers,        'Lawyers'],
                    [$resolvedCasesCount,  'Cases Resolved'],
                    [$totalClients,        'Clients Served'],
                    [$yearsActive,         'Years Active'],
                ] as [$val, $label])
                <div class="stat-card rounded-lg px-6 py-6 text-center">
                    <div class="font-display text-4xl lg:text-5xl" style="color: var(--gold-l);">{{ $val }}</div>
                    <div class="text-[var(--muted)] text-xs mt-2 uppercase tracking-widest">{{ $label }}</div>
                </div>
                @endforeach
            </div>
        </section>


        {{-- ═══════════════════════════════════════ LAWYERS ══ --}}
        <section id="lawyers" class="px-6 lg:px-20 py-24 bg-[var(--cream)]">
            <div class="max-w-6xl mx-auto">

                {{-- Section header --}}
                <div class="text-center mb-14">
                    <span class="section-label">Meet the Team</span>
                    <span class="gold-line mt-3 mb-5"></span>
                    <h2 class="font-display text-4xl lg:text-5xl text-[var(--navy)]">Our Lawyers</h2>
                    <p class="text-[#706f6c] mt-4 max-w-lg mx-auto text-sm leading-relaxed">
                        Experienced legal professionals dedicated to delivering justice and protecting your rights.
                    </p>
                </div>

                @if($publicLawyers->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($publicLawyers as $lawyer)
                            <div class="lawyer-card rounded-xl p-8 text-center bg-white">
                                <div class="avatar-ring w-20 h-20 rounded-full mx-auto mb-5 flex items-center justify-center text-white text-2xl font-display">
                                    {{ strtoupper(substr($lawyer->name, 0, 1)) }}
                                </div>
                                <h3 class="font-display text-lg text-[var(--navy)]">{{ $lawyer->name }}</h3>
                                <p class="text-sm mt-1 font-medium" style="color: var(--gold);">{{ $lawyer->specialization }}</p>
                                <p class="text-[#8a9ab5] text-xs mt-1">{{ $lawyer->experience_years }} yrs experience</p>
                                <div class="mt-4 pt-4 border-t border-[#eee] space-y-1">
                                    <p class="text-[#706f6c] text-xs">{{ $lawyer->email }}</p>
                                    <p class="text-[#706f6c] text-xs">{{ $lawyer->phone }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @guest
                        <div class="relative mt-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 blur-overlay">
                                @foreach([1,2,3] as $_)
                                    <div class="border border-[#e3e3e0] rounded-xl p-8 text-center bg-white">
                                        <div class="w-20 h-20 rounded-full mx-auto mb-5 bg-gray-200"></div>
                                        <div class="h-4 bg-gray-200 rounded w-32 mx-auto mb-3"></div>
                                        <div class="h-3 bg-gray-100 rounded w-24 mx-auto mb-2"></div>
                                        <div class="h-3 bg-gray-100 rounded w-20 mx-auto"></div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-[var(--cream)]/70 rounded-xl backdrop-blur-sm">
                                <div class="text-4xl mb-3">🔒</div>
                                <p class="font-display text-xl text-[var(--navy)] mb-1">More Lawyers Available</p>
                                <p class="text-[#706f6c] text-sm mb-5">Log in to view the full team directory.</p>
                                <a href="{{ route('login') }}"
                                    class="btn-primary px-6 py-2.5 rounded text-sm">
                                    Log In to View All
                                </a>
                            </div>
                        </div>
                    @endguest

                @else
                    <div class="text-center py-20">
                        <div class="text-5xl mb-4">👨‍⚖️</div>
                        <p class="text-gray-400 text-sm">No lawyers have been added yet.</p>
                    </div>
                @endif

            </div>
        </section>


        {{-- ═══════════════════════════════════════ RESOLVED CASES ══ --}}
        <section id="cases" class="px-6 lg:px-20 py-24 bg-white">
            <div class="max-w-6xl mx-auto">

                {{-- Section header --}}
                <div class="text-center mb-14">
                    <span class="section-label">Track Record</span>
                    <span class="gold-line mt-3 mb-5"></span>
                    <h2 class="font-display text-4xl lg:text-5xl text-[var(--navy)]">Resolved Cases</h2>
                    <p class="text-[#706f6c] mt-4 max-w-lg mx-auto text-sm leading-relaxed">
                        A glimpse into our successful case outcomes. Full details are available to registered users.
                    </p>
                </div>

                @if($publicCases->count() > 0)
                    <div class="rounded-xl overflow-hidden border border-[#e8e4dc] shadow-sm">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-[var(--navy)] text-left">
                                    <th class="px-6 py-4 text-[var(--gold-l)] font-semibold text-xs uppercase tracking-widest">Case</th>
                                    <th class="px-6 py-4 text-[var(--gold-l)] font-semibold text-xs uppercase tracking-widest">Type</th>
                                    <th class="px-6 py-4 text-[var(--gold-l)] font-semibold text-xs uppercase tracking-widest">Handled By</th>
                                    <th class="px-6 py-4 text-[var(--gold-l)] font-semibold text-xs uppercase tracking-widest">Outcome</th>
                                    <th class="px-6 py-4 text-[var(--gold-l)] font-semibold text-xs uppercase tracking-widest">Year</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#f0ebe3]">
                                @foreach($publicCases as $case)
                                    <tr class="case-row">
                                        <td class="px-6 py-4 font-semibold text-[var(--navy)]">{{ $case->case_number }}</td>
                                        <td class="px-6 py-4 text-[#706f6c]">{{ $case->case_type }}</td>
                                        <td class="px-6 py-4 text-[#706f6c]">{{ $case->lawyer->name ?? '—' }}</td>
                                        <td class="px-6 py-4">
                                            <span class="badge-resolved">{{ ucfirst($case->status) }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-[#8a9ab5]">
                                            {{ $case->filing_date?->format('Y') ?? '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @guest
                        <div class="relative mt-1">
                            <div class="border border-[#e8e4dc] border-t-0 rounded-b-xl overflow-hidden blur-overlay bg-white">
                                @foreach([1,2,3] as $_)
                                    <div class="px-6 py-4 border-t border-[#f0ebe3] flex gap-6">
                                        <div class="h-3 bg-gray-200 rounded w-48"></div>
                                        <div class="h-3 bg-gray-200 rounded w-24"></div>
                                        <div class="h-3 bg-gray-200 rounded w-32"></div>
                                        <div class="h-3 bg-gray-200 rounded w-16"></div>
                                        <div class="h-3 bg-gray-200 rounded w-12"></div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/70 backdrop-blur-sm rounded-b-xl">
                                <div class="text-4xl mb-3">🔒</div>
                                <p class="font-display text-xl text-[var(--navy)] mb-1">More Cases Available</p>
                                <p class="text-[#706f6c] text-sm mb-5">Log in to view the full resolved cases record.</p>
                                <a href="{{ route('login') }}"
                                    class="btn-primary px-6 py-2.5 rounded text-sm">
                                    Log In to View All
                                </a>
                            </div>
                        </div>
                    @endguest

                @else
                    <div class="text-center py-20">
                        <div class="text-5xl mb-4">📂</div>
                        <p class="text-gray-400 text-sm">No resolved cases have been published yet.</p>
                    </div>
                @endif

            </div>
        </section>


        {{-- ═══════════════════════════════════════ CTA ══ --}}
        <section id="contact" class="cta-bg noise relative text-white px-6 lg:px-20 py-24 text-center overflow-hidden">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute bottom-[-60px] left-[-60px] w-[500px] h-[500px] rounded-full bg-[var(--gold)]/5 blur-3xl"></div>
            </div>
            <div class="relative z-10 max-w-3xl mx-auto">
                <span class="gold-line mb-6"></span>
                <h2 class="font-display text-4xl lg:text-5xl mb-5">Ready to Join Our Legal Team?</h2>
                <p class="text-white/60 text-base lg:text-lg mb-10 leading-relaxed">
                    Register as a lawyer to access case management tools, claim available cases, and manage your legal practice efficiently.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="btn-primary px-8 py-3 rounded text-sm w-full sm:w-auto">
                            Register as Lawyer →
                        </a>
                    @endif
                    <a href="{{ route('login') }}"
                        class="btn-ghost px-8 py-3 rounded text-sm w-full sm:w-auto">
                        Log In
                    </a>
                </div>
            </div>
        </section>


        {{-- ═══════════════════════════════════════ FOOTER ══ --}}
        <footer class="bg-[var(--navy)] border-t border-white/5 px-6 lg:px-20 py-8">
            <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center justify-between gap-4 text-sm">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-6 w-auto opacity-70 brightness-0 invert">
                    <span class="font-display text-white text-base">{{ config('app.name', 'LexiCase') }}</span>
                </div>
                <div class="text-[var(--muted)] text-xs">
                    © {{ date('Y') }} {{ config('app.name', 'LexiCase') }}. All rights reserved.
                </div>
                <div class="flex gap-6 text-[var(--muted)] text-xs">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-white transition-colors">Contact</a>
                </div>
            </div>
        </footer>

    </body>
</html>