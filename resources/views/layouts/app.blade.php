<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LexiCase') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-serif-display:400i|dm-sans:300,400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --navy:   #0c1a2e;
                --navy2:  #162032;
                --gold:   #c9a84c;
                --gold-lt:#e8c97a;
                --smoke:  #f4f3f0;
                --ink:    #1a1a1a;
                --muted:  #6b7280;
                --border: #e2e0db;
                --radius: 6px;
            }
            body { font-family: 'DM Sans', sans-serif; background: var(--smoke); color: var(--ink); }
            .serif { font-family: 'DM Serif Display', serif; }

            /* Scrollbar */
            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: var(--smoke); }
            ::-webkit-scrollbar-thumb { background: #c5c2ba; border-radius: 3px; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen" style="background:var(--smoke);">
            @include('layouts.navigation')

            @isset($header)
                <header style="background:var(--navy); border-bottom:1px solid rgba(255,255,255,0.06);">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>