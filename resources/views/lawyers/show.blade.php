<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-full flex items-center justify-center text-base font-bold"
                     style="background:var(--gold); color:var(--navy);">
                    {{ strtoupper(substr($lawyer->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-widest mb-0.5" style="color:var(--gold);">Lawyer Profile</p>
                    <h1 class="serif text-2xl text-white" style="font-style:italic;">{{ $lawyer->name }}</h1>
                </div>
            </div>
            <a href="{{ route('lawyers.index') }}" class="text-xs" style="color:rgba(255,255,255,0.45);">← Back to Lawyers</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Profile card --}}
            <div class="bg-white rounded-lg overflow-hidden" style="border:1px solid var(--border);">
                <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid var(--border); background:#fafaf9;">
                    <div class="w-1 h-5 rounded-full" style="background:var(--gold);"></div>
                    <h2 class="font-semibold text-sm" style="color:var(--navy);">Profile Information</h2>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    @php
                    $fields = [
                        ['label'=>'Full Name',       'value'=>$lawyer->name],
                        ['label'=>'Specialization',  'value'=>$lawyer->specialization],
                        ['label'=>'Email',           'value'=>$lawyer->email,  'href'=>'mailto:'.$lawyer->email],
                        ['label'=>'Phone',           'value'=>$lawyer->phone,  'href'=>'tel:'.$lawyer->phone],
                        ['label'=>'Experience',      'value'=>$lawyer->experience_years.' years'],
                        ['label'=>'Member Since',    'value'=>$lawyer->created_at->format('F d, Y')],
                    ];
                    @endphp

                    @foreach($fields as $f)
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider mb-1" style="color:var(--muted);">{{ $f['label'] }}</dt>
                        <dd class="text-sm font-medium" style="color:var(--navy);">
                            @if(isset($f['href']))
                                <a href="{{ $f['href'] }}" class="hover:underline" style="color:#3b82f6;">{{ $f['value'] }}</a>
                            @else
                                {{ $f['value'] }}
                            @endif
                        </dd>
                    </div>
                    @endforeach
                </div>

                <div class="px-6 py-4 flex flex-wrap gap-3" style="border-top:1px solid var(--border); background:#fafaf9;">
                    <a href="{{ route('lawyers.edit', $lawyer) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded text-xs font-semibold text-white transition hover:opacity-90"
                       style="background:var(--navy);">
                        Edit Lawyer
                    </a>
                    <form action="{{ route('lawyers.destroy', $lawyer) }}" method="POST" class="inline"
                          onsubmit="return confirm('Delete this lawyer and all associated data?');">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded text-xs font-semibold text-white transition hover:opacity-90"
                                style="background:#ef4444;">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            {{-- Associated cases --}}
            <div class="bg-white rounded-lg overflow-hidden" style="border:1px solid var(--border);">
                <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border); background:#fafaf9;">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full" style="background:#3b82f6;"></div>
                        <h2 class="font-semibold text-sm" style="color:var(--navy);">Associated Cases
                            <span class="ml-1.5 text-xs font-normal px-2 py-0.5 rounded-full"
                                  style="background:rgba(12,26,46,0.07); color:var(--muted);">
                                {{ $lawyer->cases->count() }}
                            </span>
                        </h2>
                    </div>
                    <a href="{{ route('cases.create') }}" class="text-xs font-medium" style="color:var(--gold);">+ New Case</a>
                </div>

                @if($lawyer->cases->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="background:#fafaf9; border-bottom:1px solid var(--border);">
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Case No.</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);">Filed</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color:var(--muted);"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lawyer->cases as $case)
                            <tr class="transition hover:bg-amber-50/20" style="border-bottom:1px solid #f3f2ef;">
                                <td class="px-6 py-3.5">
                                    <a href="{{ route('cases.show', $case) }}" class="font-semibold text-xs hover:underline" style="color:var(--navy);">
                                        {{ $case->case_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-3.5 text-xs" style="color:var(--muted);">{{ $case->client_name }}</td>
                                <td class="px-6 py-3.5 text-xs" style="color:var(--muted);">{{ $case->case_type }}</td>
                                <td class="px-6 py-3.5">
                                    @include('partials.status-badge', ['status' => $case->status])
                                </td>
                                <td class="px-6 py-3.5 text-xs" style="color:var(--muted);">{{ $case->filing_date->format('M d, Y') }}</td>
                                <td class="px-6 py-3.5">
                                    <a href="{{ route('cases.show', $case) }}" class="text-xs font-medium hover:underline" style="color:#3b82f6;">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="py-12 text-center">
                    <p class="text-sm" style="color:var(--muted);">No cases associated with this lawyer.</p>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>