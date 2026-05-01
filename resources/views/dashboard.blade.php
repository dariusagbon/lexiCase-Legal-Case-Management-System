<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium uppercase tracking-widest mb-0.5" style="color:var(--gold);">Overview</p>
                <h1 class="serif text-2xl text-white" style="font-style:italic;">Dashboard</h1>
            </div>
            <span class="text-xs" style="color:rgba(255,255,255,0.35);">{{ now()->format('l, F j, Y') }}</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome banner --}}
            <div class="rounded-lg px-7 py-6 flex items-center justify-between"
                 style="background:var(--navy); border:1px solid rgba(201,168,76,0.2);">
                <div>
                    <h2 class="text-white text-lg font-semibold mb-1">
                        Welcome back, {{ Auth::user()->name }}
                    </h2>
                    <p class="text-sm" style="color:rgba(255,255,255,0.45);">
                        Here's what's happening with your cases today.
                    </p>
                </div>
                <div class="hidden sm:block serif text-5xl" style="color:var(--gold); opacity:0.3; font-style:italic;">⚖</div>
            </div>

            {{-- Stat cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                @php
                $stats = Auth::user()->isAdmin() ? [
                    ['label' => 'Total Cases',         'value' => $totalCases ?? 0,        'route' => 'cases.index',   'sub' => 'All cases',          'accent' => '#3b82f6'],
                    ['label' => 'Total Lawyers',        'value' => $totalLawyers ?? 0,       'route' => 'lawyers.index', 'sub' => 'Team members',        'accent' => 'var(--gold)'],
                    ['label' => 'Upcoming Deadlines',   'value' => $upcomingDeadlines ?? 0,  'route' => 'cases.index',   'sub' => 'Cases to track',      'accent' => '#f59e0b'],
                ] : [
                    ['label' => 'My Cases',         'value' => $totalCases ?? 0,        'route' => 'my-cases.index',   'sub' => 'Assigned to me',          'accent' => '#3b82f6'],
                    ['label' => 'Available Cases',  'value' => $totalLawyers ?? 0,       'route' => 'available-cases.index', 'sub' => 'Ready to claim',        'accent' => 'var(--gold)'],
                    ['label' => 'Active Cases',     'value' => $upcomingDeadlines ?? 0,  'route' => 'my-cases.index',   'sub' => 'Currently working',      'accent' => '#f59e0b'],
                ];
                @endphp

                @foreach($stats as $s)
                <a href="{{ route($s['route']) }}"
                   class="block rounded-lg px-6 py-5 bg-white transition hover:shadow-md group"
                   style="border:1px solid var(--border);">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">{{ $s['label'] }}</span>
                        <div class="w-2 h-2 rounded-full" style="background:{{ $s['accent'] }};"></div>
                    </div>
                    <div class="text-3xl font-bold" style="color:var(--navy);">{{ $s['value'] }}</div>
                    <div class="text-xs mt-1" style="color:#9ca3af;">{{ $s['sub'] }}</div>
                </a>
                @endforeach

            </div>

            {{-- Main content --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Recent cases table --}}
                <div class="lg:col-span-2 bg-white rounded-lg overflow-hidden" style="border:1px solid var(--border);">
                    <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border);">
                        <h3 class="font-semibold text-sm" style="color:var(--navy);">Recent Cases</h3>
                        <a href="{{ route('cases.index') }}" class="text-xs font-medium transition" style="color:var(--gold);">View all →</a>
                    </div>

                    @if(isset($recentCases) && $recentCases->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr style="border-bottom:1px solid var(--border); background:#fafaf9;">
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Case No.</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Client</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Lawyer</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Filed</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentCases as $case)
                                <tr class="hover:bg-amber-50/30 transition" style="border-bottom:1px solid #f3f2ef;">
                                    <td class="px-6 py-3.5">
                                        <a href="{{ route('cases.show', $case) }}" class="font-medium text-blue-700 hover:underline text-xs">{{ $case->case_number }}</a>
                                    </td>
                                    <td class="px-6 py-3.5 text-xs" style="color:var(--muted);">{{ $case->client_name }}</td>
                                    <td class="px-6 py-3.5 text-xs" style="color:var(--muted);">{{ $case->lawyer ? $case->lawyer->name : 'Unassigned' }}</td>
                                    <td class="px-6 py-3.5">
                                        @include('partials.status-badge', ['status' => $case->status])
                                    </td>
                                    <td class="px-6 py-3.5 text-xs" style="color:var(--muted);">{{ $case->filing_date->format('M j, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="py-16 text-center">
                        <div class="text-4xl mb-3 opacity-30">📂</div>
                        <p class="text-sm mb-4" style="color:var(--muted);">No cases yet. Start by creating one.</p>
                        <a href="{{ route('cases.create') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded text-sm font-medium text-white transition hover:opacity-90"
                           style="background:var(--navy);">
                            + New Case
                        </a>
                    </div>
                    @endif
                </div>

                {{-- Right sidebar --}}
                <div class="space-y-4">

                    {{-- Case status overview --}}
                    <div class="bg-white rounded-lg overflow-hidden" style="border:1px solid var(--border);">
                        <div class="px-5 py-3.5" style="border-bottom:1px solid var(--border);">
                            <h3 class="font-semibold text-sm" style="color:var(--navy);">Case Status</h3>
                        </div>
                        <div class="p-5 space-y-3">
                            @php
                            $statuses = [
                                ['label'=>'Active',   'count'=>$activeCases ?? 0,  'color'=>'#16a34a', 'bg'=>'#f0fdf4'],
                                ['label'=>'Pending',  'count'=>$pendingCases ?? 0, 'color'=>'#d97706', 'bg'=>'#fffbeb'],
                                ['label'=>'Closed',   'count'=>$closedCases ?? 0,  'color'=>'#6b7280', 'bg'=>'#f9fafb'],
                            ];
                            $total = max(1, ($activeCases ?? 0) + ($pendingCases ?? 0) + ($closedCases ?? 0));
                            @endphp

                            @foreach($statuses as $st)
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-xs font-medium" style="color:var(--muted);">{{ $st['label'] }}</span>
                                    <span class="text-xs font-bold" style="color:{{ $st['color'] }};">{{ $st['count'] }}</span>
                                </div>
                                <div class="h-1.5 rounded-full" style="background:#f3f2ef;">
                                    <div class="h-1.5 rounded-full transition-all" style="width:{{ round(($st['count']/$total)*100) }}%; background:{{ $st['color'] }};"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Top lawyers --}}
                    <div class="bg-white rounded-lg overflow-hidden" style="border:1px solid var(--border);">
                        <div class="px-5 py-3.5" style="border-bottom:1px solid var(--border);">
                            <h3 class="font-semibold text-sm" style="color:var(--navy);">Top Lawyers</h3>
                        </div>
                        <div class="p-4 space-y-2">
                            @forelse($activeLawyers ?? [] as $lawyer)
                            <a href="{{ route('lawyers.show', $lawyer) }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-md transition hover:bg-amber-50/40"
                               style="border:1px solid transparent;">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                     style="background:var(--navy); color:var(--gold);">
                                    {{ strtoupper(substr($lawyer->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-semibold truncate" style="color:var(--navy);">{{ $lawyer->name }}</div>
                                    <div class="text-xs" style="color:#9ca3af;">{{ $lawyer->cases_count }} {{ Str::plural('case', $lawyer->cases_count) }}</div>
                                </div>
                            </a>
                            @empty
                            <p class="text-xs text-center py-4" style="color:#9ca3af;">No lawyers yet.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Quick actions --}}
                    <div class="bg-white rounded-lg overflow-hidden" style="border:1px solid var(--border);">
                        <div class="px-5 py-3.5" style="border-bottom:1px solid var(--border);">
                            <h3 class="font-semibold text-sm" style="color:var(--navy);">Quick Actions</h3>
                        </div>
                        <div class="p-3 space-y-1.5">
                            <a href="{{ route('cases.create') }}"
                               class="flex items-center gap-2.5 px-3 py-2.5 rounded-md text-xs font-medium transition hover:bg-amber-50/40"
                               style="color:var(--navy); border:1px solid var(--border);">
                                <span style="color:var(--gold);">+</span> New Case
                            </a>
                            <a href="{{ route('lawyers.create') }}"
                               class="flex items-center gap-2.5 px-3 py-2.5 rounded-md text-xs font-medium transition hover:bg-amber-50/40"
                               style="color:var(--navy); border:1px solid var(--border);">
                                <span style="color:var(--gold);">+</span> Add Lawyer
                            </a>
                            <a href="{{ route('cases.index') }}"
                               class="flex items-center gap-2.5 px-3 py-2.5 rounded-md text-xs font-medium transition hover:bg-amber-50/40"
                               style="color:var(--navy); border:1px solid var(--border);">
                                <span style="color:var(--gold);">→</span> All Cases
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>