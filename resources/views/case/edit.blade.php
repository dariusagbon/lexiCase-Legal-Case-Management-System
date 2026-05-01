<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium uppercase tracking-widest mb-0.5" style="color:var(--gold);">Cases</p>
                <h1 class="serif text-2xl text-white" style="font-style:italic;">Edit Case</h1>
            </div>
            <a href="{{ route('cases.show', $case) }}" class="text-xs" style="color:rgba(255,255,255,0.45);">← Back to Case</a>
        </div>
    </x-slot>

    @include('partials.form-styles')

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('cases.update', $case) }}" method="POST">
                @csrf @method('PATCH')

                <div class="form-section">
                    <div class="form-section-header">
                        <div class="w-1 h-5 rounded-full" style="background:var(--gold);"></div>
                        <h2 class="text-sm font-semibold" style="color:var(--navy);">Edit — {{ $case->case_number }}</h2>
                    </div>
                    <div class="form-section-body">

                        <div class="form-grid">

                            <div class="col-span-2 sm:col-span-1">
                                <label for="lawyer_id" class="field-label">Assigned Lawyer</label>
                                <select id="lawyer_id" name="lawyer_id" class="field-select {{ $errors->has('lawyer_id') ? 'err' : '' }}" required>
                                    <option value="">— Select a Lawyer —</option>
                                    @foreach($lawyers as $lawyer)
                                        <option value="{{ $lawyer->id }}" {{ old('lawyer_id', $case->lawyer_id) == $lawyer->id ? 'selected' : '' }}>
                                            {{ $lawyer->name }} — {{ $lawyer->specialization }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lawyer_id') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="case_number" class="field-label">Case Number</label>
                                <input id="case_number" type="text" name="case_number" value="{{ old('case_number', $case->case_number) }}"
                                       class="field-input {{ $errors->has('case_number') ? 'err' : '' }}" required>
                                @error('case_number') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="client_name" class="field-label">Client Name</label>
                                <input id="client_name" type="text" name="client_name" value="{{ old('client_name', $case->client_name) }}"
                                       class="field-input {{ $errors->has('client_name') ? 'err' : '' }}" required>
                                @error('client_name') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="case_type" class="field-label">Case Type</label>
                                <input id="case_type" type="text" name="case_type" value="{{ old('case_type', $case->case_type) }}"
                                       class="field-input {{ $errors->has('case_type') ? 'err' : '' }}" required>
                                @error('case_type') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="filing_date" class="field-label">Filing Date</label>
                                <input id="filing_date" type="date" name="filing_date" value="{{ old('filing_date', $case->filing_date->format('Y-m-d')) }}"
                                       class="field-input {{ $errors->has('filing_date') ? 'err' : '' }}" required>
                                @error('filing_date') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="status" class="field-label">Status</label>
                                <select id="status" name="status" class="field-select {{ $errors->has('status') ? 'err' : '' }}" required>
                                    <option value="open"    {{ old('status', $case->status) == 'open'    ? 'selected' : '' }}>Open</option>
                                    <option value="pending" {{ old('status', $case->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="closed"  {{ old('status', $case->status) == 'closed'  ? 'selected' : '' }}>Closed</option>
                                </select>
                                @error('status') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="description" class="field-label">Case Description</label>
                                <textarea id="description" name="description" rows="5"
                                          class="field-textarea {{ $errors->has('description') ? 'err' : '' }}"
                                          required>{{ old('description', $case->description) }}</textarea>
                                @error('description') <p class="field-error">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-5" style="border-top:1px solid #f3f2ef;">
                            <button type="submit" class="btn-submit">Update Case →</button>
                            <a href="{{ route('cases.show', $case) }}" class="btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>