<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium uppercase tracking-widest mb-0.5" style="color:var(--gold);">My Work</p>
                <h1 class="serif text-2xl text-white" style="font-style:italic;">My Cases</h1>
            </div>
            <a href="{{ route('available-cases.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded text-xs font-semibold transition hover:opacity-90"
               style="background:var(--gold); color:var(--navy);">
                + Grab a Case
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-md text-sm font-medium"
                     style="background:#f0fdf4; color:#166534; border:1px solid #bbf7d0;">
                    <span>✓</span> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-md text-sm font-medium"
                     style="background:#fef2f2; color:#991b1b; border:1px solid #fecaca;">
                    <span>✕</span> {{ session('error') }}
                </div>
            @endif

            {{-- Profile Card --}}
            <div class="bg-white rounded-lg overflow-hidden" style="border:1px solid var(--border);">
                <div class="px-6 py-5 flex items-center gap-4" style="background:#fafaf9; border-bottom:1px solid var(--border);">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center text-white text-2xl font-semibold" style="background:var(--navy);">
                        {{ strtoupper(substr($lawyer->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="font-semibold text-lg" style="color:var(--navy);">{{ $lawyer->name }}</h2>
                        <p class="text-sm" style="color:var(--muted);">{{ $lawyer->specialization }} • {{ $lawyer->experience_years }} years experience</p>
                        <p class="text-xs" style="color:#9ca3af;">{{ $lawyer->email }} • {{ $lawyer->phone }}</p>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @php
                $stats = [
                    ['label' => 'Open Cases', 'value' => $openCases, 'accent' => '#3b82f6'],
                    ['label' => 'Pending Cases', 'value' => $pendingCases, 'accent' => '#f59e0b'],
                    ['label' => 'Closed Cases', 'value' => $closedCases, 'accent' => '#10b981'],
                ];
                @endphp

                @foreach($stats as $stat)
                <div class="bg-white rounded-lg px-6 py-5" style="border:1px solid var(--border);">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">{{ $stat['label'] }}</span>
                        <div class="w-2 h-2 rounded-full" style="background:{{ $stat['accent'] }};"></div>
                    </div>
                    <div class="text-3xl font-bold" style="color:var(--navy);">{{ $stat['value'] }}</div>
                </div>
                @endforeach
            </div>

            {{-- My Cases Table --}}
            <div class="bg-white rounded-lg overflow-hidden" style="border:1px solid var(--border);">
                <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border);">
                    <h3 class="font-semibold text-sm" style="color:var(--navy);">Your Cases</h3>
                    <span class="text-xs" style="color:var(--muted);">{{ $myCases->total() }} total</span>
                </div>

                @if($myCases->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr style="background:#fafaf9; border-bottom:2px solid var(--border);">
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Case No.</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Client</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Type</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Status</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Filed</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myCases as $case)
                                <tr class="hover:bg-amber-50/30 transition" style="border-bottom:1px solid #f3f2ef;">
                                    <td class="px-6 py-3.5">
                                        <a href="{{ route('my-cases.show', $case) }}" class="font-medium text-blue-700 hover:underline text-xs">{{ $case->case_number }}</a>
                                    </td>
                                    <td class="px-6 py-3.5 text-xs" style="color:var(--muted);">{{ $case->client_name }}</td>
                                    <td class="px-6 py-3.5 text-xs" style="color:var(--muted);">{{ $case->case_type }}</td>
                                    <td class="px-6 py-3.5">
                                        @include('partials.status-badge', ['status' => $case->status])
                                    </td>
                                    <td class="px-6 py-3.5 text-xs" style="color:var(--muted);">{{ $case->filing_date->format('M j, Y') }}</td>
                                    <td class="px-6 py-3.5">
                                        @if($case->status !== 'closed')
                                        <form action="{{ route('cases.release', $case) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded text-xs font-medium transition"
                                                    style="background:#fee2e2; color:#991b1b; border:none; cursor:pointer;">
                                                Release
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="px-6 py-4 flex items-center justify-between" style="border-top:1px solid var(--border);">
                        {{ $myCases->links() }}
                    </div>
                @else
                    <div class="py-16 text-center">
                        <div class="text-4xl mb-3 opacity-30">📋</div>
                        <p class="text-sm mb-4" style="color:var(--muted);">You haven't claimed any cases yet.</p>
                        <a href="{{ route('available-cases.index') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded text-xs font-semibold transition hover:opacity-90"
                           style="background:var(--gold); color:var(--navy);">
                            Browse Available Cases
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
