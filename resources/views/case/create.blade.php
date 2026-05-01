<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium uppercase tracking-widest mb-0.5" style="color:var(--gold);">Cases</p>
                <h1 class="serif text-2xl text-white" style="font-style:italic;">New Case</h1>
            </div>
            <a href="{{ route('cases.index') }}" class="text-xs" style="color:rgba(255,255,255,0.45);">← Back to Cases</a>
        </div>
    </x-slot>

    @include('partials.form-styles')

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Info Box --}}
            <div class="mb-6 px-4 py-3 rounded-lg text-sm" style="background:#dbeafe; color:#1e40af; border:1px solid #93c5fd;">
                <p class="font-medium mb-1">💡 How it works</p>
                <p style="font-size:0.875rem;">Create a case without assigning a lawyer. Lawyers can then browse and claim available cases from their dashboard.</p>
            </div>

            <form action="{{ route('cases.store') }}" method="POST">
                @csrf

                <div class="form-section">
                    <div class="form-section-header">
                        <div class="w-1 h-5 rounded-full" style="background:var(--gold);"></div>
                        <h2 class="text-sm font-semibold" style="color:var(--navy);">Case Details</h2>
                    </div>
                    <div class="form-section-body">

                        <div class="form-grid">

                            {{-- Case number --}}
                            <div class="col-span-2 sm:col-span-1">
                                <label for="case_number" class="field-label">Case Number</label>
                                <input id="case_number" type="text" name="case_number" value="{{ old('case_number') }}"
                                       class="field-input {{ $errors->has('case_number') ? 'err' : '' }}"
                                       placeholder="e.g., CASE-2025-001" required>
                                @error('case_number') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            {{-- Client name --}}
                            <div>
                                <label for="client_name" class="field-label">Client Name</label>
                                <input id="client_name" type="text" name="client_name" value="{{ old('client_name') }}"
                                       class="field-input {{ $errors->has('client_name') ? 'err' : '' }}" required>
                                @error('client_name') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            {{-- Case type --}}
                            <div>
                                <label for="case_type" class="field-label">Case Type</label>
                                <input id="case_type" type="text" name="case_type" value="{{ old('case_type') }}"
                                       class="field-input {{ $errors->has('case_type') ? 'err' : '' }}"
                                       placeholder="e.g., Criminal, Civil, Corporate" required>
                                @error('case_type') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            {{-- Filing date --}}
                            <div>
                                <label for="filing_date" class="field-label">Filing Date</label>
                                <input id="filing_date" type="date" name="filing_date" value="{{ old('filing_date') }}"
                                       class="field-input {{ $errors->has('filing_date') ? 'err' : '' }}" required>
                                @error('filing_date') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            {{-- Status --}}
                            <div>
                                <label for="status" class="field-label">Status</label>
                                <select id="status" name="status"
                                        class="field-select {{ $errors->has('status') ? 'err' : '' }}" required>
                                    <option value="open"    {{ old('status') == 'open'    ? 'selected' : '' }}>Open</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="closed"  {{ old('status') == 'closed'  ? 'selected' : '' }}>Closed</option>
                                </select>
                                @error('status') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-span-2">
                                <label for="description" class="field-label">Case Description</label>
                                <textarea id="description" name="description" rows="5"
                                          class="field-textarea {{ $errors->has('description') ? 'err' : '' }}"
                                          required>{{ old('description') }}</textarea>
                                @error('description') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-5" style="border-top:1px solid #f3f2ef;">
                            <button type="submit" class="btn-submit">Create Case →</button>
                            <a href="{{ route('cases.index') }}" class="btn-cancel">Cancel</a>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>