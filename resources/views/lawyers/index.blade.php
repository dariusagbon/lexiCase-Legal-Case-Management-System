<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-medium uppercase tracking-widest mb-0.5" style="color:var(--gold);">Team</p>
            <h1 class="serif text-2xl text-white" style="font-style:italic;">Lawyers</h1>
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
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Name</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Email</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Phone</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Specialization</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Experience</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lawyers as $lawyer)
                            <tr class="transition hover:bg-amber-50/20" style="border-bottom:1px solid #f3f2ef;">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                             style="background:var(--navy); color:var(--gold);">
                                            {{ strtoupper(substr($lawyer->name, 0, 1)) }}
                                        </div>
                                        <a href="{{ route('lawyers.show', $lawyer) }}"
                                           class="font-semibold text-xs hover:underline" style="color:var(--navy);">
                                            {{ $lawyer->name }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs" style="color:var(--muted);">{{ $lawyer->email }}</td>
                                <td class="px-6 py-4 text-xs" style="color:var(--muted);">{{ $lawyer->phone }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium"
                                          style="background:rgba(12,26,46,0.07); color:var(--navy);">
                                        {{ $lawyer->specialization }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs" style="color:var(--muted);">{{ $lawyer->experience_years }} yrs</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('lawyers.show', $lawyer) }}" class="text-xs font-medium hover:underline" style="color:#3b82f6;">View</a>
                                        <form action="{{ route('lawyers.destroy', $lawyer) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Delete this lawyer?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs font-medium hover:underline" style="color:#ef4444;">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="text-4xl mb-3 opacity-20">⚖</div>
                                    <p class="text-sm" style="color:var(--muted);">No lawyers found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-5">{{ $lawyers->links() }}</div>

        </div>
    </div>
</x-app-layout>