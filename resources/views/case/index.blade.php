<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium uppercase tracking-widest mb-0.5" style="color:var(--gold);">Records</p>
                <h1 class="serif text-2xl text-white" style="font-style:italic;">Cases</h1>
            </div>
            <a href="{{ route('cases.create') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded text-sm font-semibold text-white transition hover:opacity-90"
               style="background:var(--gold); color:var(--navy);">
                + New Case
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-md text-sm font-medium"
                     style="background:#f0fdf4; color:#166534; border:1px solid #bbf7d0;">
                    <span>✓</span> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg overflow-hidden" style="border:1px solid var(--border);">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="background:#fafaf9; border-bottom:2px solid var(--border);">
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Case Number</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Lawyer</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Client</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Type</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Status</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Filed</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cases as $case)
                                <tr class="transition hover:bg-amber-50/20" style="border-bottom:1px solid #f3f2ef;">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('cases.show', $case) }}"
                                        class="font-semibold text-xs hover:underline" style="color:var(--navy);">
                                            {{ $case->case_number }}
                                        </a>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        {{-- FIX: Check if the lawyer relationship exists before generating the link --}}
                                        @if($case->lawyer)
                                            <a href="{{ route('lawyers.show', $case->lawyer) }}"
                                            class="text-xs hover:underline" style="color:#3b82f6;">
                                                {{ $case->lawyer->name }}
                                            </a>
                                        @else
                                            <span class="text-xs italic" style="color:var(--muted);">Unassigned</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-xs" style="color:var(--muted);">{{ $case->client_name }}</td>
                                    <td class="px-6 py-4 text-xs" style="color:var(--muted);">{{ $case->case_type }}</td>
                                    <td class="px-6 py-4">
                                        @include('partials.status-badge', ['status' => $case->status])
                                    </td>
                                    <td class="px-6 py-4 text-xs" style="color:var(--muted);">
                                        {{ $case->filing_date ? $case->filing_date->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('cases.show', $case) }}"
                                            class="text-xs font-medium transition hover:underline" style="color:#3b82f6;">View</a>
                                            <a href="{{ route('cases.edit', $case) }}"
                                            class="text-xs font-medium transition hover:underline" style="color:var(--gold);">Edit</a>
                                            <form action="{{ route('cases.destroy', $case) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Delete this case?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-xs font-medium transition hover:underline" style="color:#ef4444;">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="text-4xl mb-3 opacity-20">📂</div>
                                        <p class="text-sm" style="color:var(--muted);">No cases found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-5">{{ $cases->links() }}</div>

        </div>
    </div>
</x-app-layout>