<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium uppercase tracking-widest mb-0.5" style="color:var(--gold);">Case Detail</p>
                <h1 class="serif text-2xl text-white" style="font-style:italic;">{{ $case->case_number }}</h1>
            </div>
            @include('partials.status-badge', ['status' => $case->status])
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Case info card --}}
            <div class="bg-white rounded-lg overflow-hidden" style="border:1px solid var(--border);">
                <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid var(--border); background:#fafaf9;">
                    <div class="w-1 h-5 rounded-full" style="background:var(--gold);"></div>
                    <h2 class="font-semibold text-sm" style="color:var(--navy);">Case Information</h2>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @php
                    $fields = [
                        ['label'=>'Case Number',     'value'=>$case->case_number],
                        ['label'=>'Client Name',     'value'=>$case->client_name],
                        ['label'=>'Case Type',       'value'=>$case->case_type],
                        ['label'=>'Filing Date',     'value'=>$case->filing_date->format('F d, Y')],
                        ['label'=>'Date Created',    'value'=>$case->created_at->format('F d, Y')],
                    ];
                    @endphp

                    @foreach($fields as $f)
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider mb-1" style="color:var(--muted);">{{ $f['label'] }}</dt>
                        <dd class="text-sm font-medium" style="color:var(--navy);">{{ $f['value'] }}</dd>
                    </div>
                    @endforeach

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider mb-1" style="color:var(--muted);">Assigned Lawyer</dt>
                        <dd>
                            <a href="{{ route('lawyers.show', $case->lawyer) }}"
                               class="text-sm font-medium hover:underline" style="color:#3b82f6;">
                                {{ $case->lawyer->name }}
                            </a>
                        </dd>
                    </div>
                </div>

                {{-- Description --}}
                <div class="px-6 pb-6">
                    <div style="border-top:1px solid var(--border);" class="pt-5">
                        <dt class="text-xs font-semibold uppercase tracking-wider mb-3" style="color:var(--muted);">Case Description</dt>
                        <dd class="text-sm leading-relaxed" style="color:#374151;">{{ $case->description }}</dd>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="px-6 py-4 flex flex-wrap gap-3" style="border-top:1px solid var(--border); background:#fafaf9;">
                    <a href="{{ route('cases.edit', $case) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded text-xs font-semibold text-white transition hover:opacity-90"
                       style="background:var(--navy);">
                        Edit Case
                    </a>
                    <form action="{{ route('cases.destroy', $case) }}" method="POST" class="inline"
                          onsubmit="return confirm('Delete this case?');">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded text-xs font-semibold text-white transition hover:opacity-90"
                                style="background:#ef4444;">
                            Delete Case
                        </button>
                    </form>
                    <a href="{{ route('cases.index') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded text-xs font-medium transition hover:bg-gray-100"
                       style="color:var(--muted); border:1px solid var(--border);">
                        ← Back to Cases
                    </a>
                </div>
            </div>

            {{-- Lawyer card --}}
            <div class="bg-white rounded-lg overflow-hidden" style="border:1px solid var(--border);">
                <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid var(--border); background:#fafaf9;">
                    <div class="w-1 h-5 rounded-full" style="background:#3b82f6;"></div>
                    <h2 class="font-semibold text-sm" style="color:var(--navy);">Assigned Lawyer</h2>
                </div>

                <div class="p-6 flex items-start gap-5">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold flex-shrink-0"
                         style="background:var(--navy); color:var(--gold);">
                        {{ strtoupper(substr($case->lawyer->name, 0, 1)) }}
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 flex-1">
                        @php
                        $lFields = [
                            ['label'=>'Name',           'value'=>$case->lawyer->name],
                            ['label'=>'Specialization', 'value'=>$case->lawyer->specialization],
                            ['label'=>'Email',          'value'=>$case->lawyer->email,  'href'=>'mailto:'.$case->lawyer->email],
                            ['label'=>'Phone',          'value'=>$case->lawyer->phone,  'href'=>'tel:'.$case->lawyer->phone],
                            ['label'=>'Experience',     'value'=>$case->lawyer->experience_years.' years'],
                        ];
                        @endphp

                        @foreach($lFields as $f)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider mb-0.5" style="color:var(--muted);">{{ $f['label'] }}</dt>
                            <dd class="text-sm" style="color:var(--navy);">
                                @if(isset($f['href']))
                                    <a href="{{ $f['href'] }}" class="hover:underline" style="color:#3b82f6;">{{ $f['value'] }}</a>
                                @else
                                    {{ $f['value'] }}
                                @endif
                            </dd>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="px-6 pb-5">
                    <a href="{{ route('lawyers.show', $case->lawyer) }}"
                       class="text-xs font-medium hover:underline" style="color:var(--gold);">
                        View full lawyer profile →
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>