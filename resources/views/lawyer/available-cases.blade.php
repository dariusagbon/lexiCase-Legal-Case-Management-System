<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium uppercase tracking-widest mb-0.5" style="color:var(--gold);">Available Cases</p>
                <h1 class="serif text-2xl text-white" style="font-style:italic;">Grab a Case</h1>
            </div>
            <a href="{{ route('my-cases.index') }}" class="text-xs" style="color:rgba(255,255,255,0.45);">← Back to My Cases</a>
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

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white rounded-lg px-6 py-5" style="border:1px solid var(--border);">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">My Cases</span>
                        <div class="w-2 h-2 rounded-full" style="background:var(--gold);"></div>
                    </div>
                    <div class="text-3xl font-bold" style="color:var(--navy);">{{ $myCases }}</div>
                    <div class="text-xs mt-1" style="color:#9ca3af;">Cases you're handling</div>
                </div>

                <div class="bg-white rounded-lg px-6 py-5" style="border:1px solid var(--border);">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Available</span>
                        <div class="w-2 h-2 rounded-full" style="background:#3b82f6;"></div>
                    </div>
                    <div class="text-3xl font-bold" style="color:var(--navy);">{{ $availableCases->total() }}</div>
                    <div class="text-xs mt-1" style="color:#9ca3af;">Ready to claim</div>
                </div>
            </div>

            {{-- Cases Table --}}
            <div class="bg-white rounded-lg overflow-hidden" style="border:1px solid var(--border);">
                <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border);">
                    <h3 class="font-semibold text-sm" style="color:var(--navy);">Available Cases</h3>
                    <span class="text-xs" style="color:var(--muted);">{{ $availableCases->total() }} total</span>
                </div>

                @if($availableCases->count() > 0)
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
                                @foreach($availableCases as $case)
                                <tr class="hover:bg-amber-50/30 transition" style="border-bottom:1px solid #f3f2ef;">
                                    <td class="px-6 py-3.5">
                                        <a href="#" class="font-medium text-blue-700 hover:underline text-xs">{{ $case->case_number }}</a>
                                    </td>
                                    <td class="px-6 py-3.5 text-xs" style="color:var(--muted);">{{ $case->client_name }}</td>
                                    <td class="px-6 py-3.5 text-xs" style="color:var(--muted);">{{ $case->case_type }}</td>
                                    <td class="px-6 py-3.5">
                                        @include('partials.status-badge', ['status' => $case->status])
                                    </td>
                                    <td class="px-6 py-3.5 text-xs" style="color:var(--muted);">{{ $case->filing_date->format('M j, Y') }}</td>
                                    <td class="px-6 py-3.5">
                                        <form action="{{ route('cases.claim', $case) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded text-xs font-medium transition"
                                                    style="background:var(--gold); color:var(--navy); border:none; cursor:pointer;">
                                                Claim
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="px-6 py-4 flex items-center justify-between" style="border-top:1px solid var(--border);">
                        {{ $availableCases->links() }}
                    </div>
                @else
                    <div class="py-16 text-center">
                        <div class="text-4xl mb-3 opacity-30">📋</div>
                        <p class="text-sm mb-2" style="color:var(--muted);">No cases available at the moment.</p>
                        <p class="text-xs" style="color:var(--muted);">Check back later or contact your administrator.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
