<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium uppercase tracking-widest mb-0.5" style="color:var(--gold);">Team</p>
                <h1 class="serif text-2xl text-white" style="font-style:italic;">Edit Lawyer</h1>
            </div>
            <a href="{{ route('lawyers.show', $lawyer) }}" class="text-xs" style="color:rgba(255,255,255,0.45);">← Back to Profile</a>
        </div>
    </x-slot>

    @include('partials.form-styles')

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('lawyers.update', $lawyer) }}" method="POST">
                @csrf @method('PATCH')

                <div class="form-section">
                    <div class="form-section-header">
                        <div class="w-1 h-5 rounded-full" style="background:var(--gold);"></div>
                        <h2 class="text-sm font-semibold" style="color:var(--navy);">Edit — {{ $lawyer->name }}</h2>
                    </div>
                    <div class="form-section-body">
                        <div class="form-grid">

                            <div>
                                <label for="name" class="field-label">Full Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $lawyer->name) }}"
                                       class="field-input {{ $errors->has('name') ? 'err' : '' }}" required>
                                @error('name') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="email" class="field-label">Email Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $lawyer->email) }}"
                                       class="field-input {{ $errors->has('email') ? 'err' : '' }}" required>
                                @error('email') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="phone" class="field-label">Phone</label>
                                <input id="phone" type="tel" name="phone" value="{{ old('phone', $lawyer->phone) }}"
                                       class="field-input {{ $errors->has('phone') ? 'err' : '' }}" required>
                                @error('phone') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="experience_years" class="field-label">Years of Experience</label>
                                <input id="experience_years" type="number" name="experience_years" value="{{ old('experience_years', $lawyer->experience_years) }}"
                                       class="field-input {{ $errors->has('experience_years') ? 'err' : '' }}"
                                       min="0" required>
                                @error('experience_years') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="specialization" class="field-label">Specialization</label>
                                <input id="specialization" type="text" name="specialization" value="{{ old('specialization', $lawyer->specialization) }}"
                                       class="field-input {{ $errors->has('specialization') ? 'err' : '' }}" required>
                                @error('specialization') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-5" style="border-top:1px solid #f3f2ef;">
                            <button type="submit" class="btn-submit">Update Lawyer →</button>
                            <a href="{{ route('lawyers.show', $lawyer) }}" class="btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>