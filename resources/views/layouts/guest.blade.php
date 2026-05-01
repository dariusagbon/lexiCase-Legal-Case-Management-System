<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'LexiCase') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-serif-display:400i|dm-sans:300,400,500,600&display=swap" rel="stylesheet"/>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --navy:#0c1a2e; --navy2:#162032; --gold:#c9a84c; --gold-lt:#e8c97a;
                --smoke:#f4f3f0; --ink:#1a1a1a; --muted:#6b7280; --border:#e2e0db;
            }
            body { font-family:'DM Sans',sans-serif; }
            .serif { font-family:'DM Serif Display',serif; }

            .panel-left {
                background: var(--navy);
                background-image:
                    radial-gradient(ellipse at 20% 50%, rgba(201,168,76,0.07) 0%, transparent 60%),
                    radial-gradient(ellipse at 80% 10%, rgba(59,130,246,0.06) 0%, transparent 50%);
            }

            /* Subtle grid texture */
            .panel-left::before {
                content: '';
                position: absolute;
                inset: 0;
                background-image:
                    linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
                background-size: 40px 40px;
                pointer-events: none;
            }

            .form-input {
                width: 100%;
                padding: 0.625rem 0.875rem;
                border: 1.5px solid var(--border);
                border-radius: 5px;
                font-size: 0.875rem;
                background: white;
                color: var(--ink);
                transition: border-color 0.15s, box-shadow 0.15s;
                outline: none;
            }
            .form-input:focus {
                border-color: var(--gold);
                box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
            }
            .form-label {
                display: block;
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                color: #4b5563;
                margin-bottom: 0.4rem;
            }
            .btn-primary {
                width: 100%;
                padding: 0.7rem 1.5rem;
                background: var(--navy);
                color: white;
                border: none;
                border-radius: 5px;
                font-size: 0.875rem;
                font-weight: 600;
                letter-spacing: 0.02em;
                cursor: pointer;
                transition: background 0.15s, transform 0.1s;
            }
            .btn-primary:hover { background: #1a2e4a; transform: translateY(-1px); }
            .btn-primary:active { transform: translateY(0); }
        </style>
    </head>

    <body class="font-sans antialiased min-h-screen flex" style="background:var(--smoke);">

        {{-- LEFT PANEL --}}
        <div class="panel-left relative hidden lg:flex lg:w-[45%] flex-col justify-between p-14 text-white overflow-hidden">

            {{-- Logo --}}
            <div class="relative flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-auto">
                <span class="serif text-xl" style="font-style:italic; color:var(--gold-lt);">LexiCase</span>
            </div>

            {{-- Center content --}}
            <div class="relative">
                <div class="mb-6 inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-full"
                     style="background:rgba(201,168,76,0.15); color:var(--gold-lt); border:1px solid rgba(201,168,76,0.25);">
                    ⚖ Legal Case Management
                </div>
                <h1 class="serif text-4xl leading-tight mb-5" style="font-style:italic; color:white;">
                    Your practice,<br>
                    <span style="color:var(--gold-lt);">fully in order.</span>
                </h1>
                <p class="text-sm leading-relaxed mb-10" style="color:rgba(255,255,255,0.55); max-width:340px;">
                    Manage cases, coordinate with your legal team, and stay ahead of every deadline — all from one secure platform.
                </p>

                <div class="space-y-3.5">
                    @foreach(['Case & client management', 'Deadline tracking', 'Secure document storage', 'Lawyer portal access'] as $feat)
                    <div class="flex items-center gap-3 text-sm" style="color:rgba(255,255,255,0.7);">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold"
                              style="background:rgba(201,168,76,0.2); color:var(--gold);">✓</span>
                        {{ $feat }}
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Footer quote --}}
            <div class="relative" style="border-top:1px solid rgba(255,255,255,0.08); padding-top:1.5rem;">
                <p class="text-xs italic" style="color:rgba(255,255,255,0.3);">
                    "Justice delayed is justice denied." — W. E. Gladstone
                </p>
            </div>
        </div>

        {{-- RIGHT PANEL --}}
        <div class="w-full lg:w-[55%] flex flex-col justify-center items-center px-6 py-12" style="background:var(--smoke);">

            {{-- Mobile logo --}}
            <div class="flex lg:hidden items-center gap-2 mb-10">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
                <span class="serif text-xl" style="font-style:italic; color:var(--navy);">LexiCase</span>
            </div>

            <div class="w-full max-w-md">
                {{-- Form card --}}
                <div class="bg-white rounded-lg p-8 shadow-sm" style="border:1px solid var(--border);">
                    {{ $slot }}
                </div>

                <a href="/" class="mt-6 block text-center text-xs transition" style="color:var(--muted);">
                    ← Back to Home
                </a>
                <p class="mt-4 text-center text-xs" style="color:#9ca3af;">
                    © {{ date('Y') }} {{ config('app.name', 'LexiCase') }}. All rights reserved.
                </p>
            </div>
        </div>

    </body>
</html>