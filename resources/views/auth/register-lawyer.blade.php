{{-- resources/views/auth/register-lawyer.blade.php --}}
<x-guest-layout>

    <div class="mb-7">
        <h2 class="serif text-2xl" style="font-style:italic; color:var(--navy);">Lawyer Registration</h2>
        <p class="mt-1 text-sm" style="color:var(--muted);">Join LexiCase as a legal professional.</p>
    </div>

    <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="form-label">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   class="form-input @error('name') !border-red-400 @enderror"
                   required autofocus placeholder="Atty. Juan dela Cruz">
            @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-input @error('email') !border-red-400 @enderror"
                   required placeholder="you@lawfirm.com">
            @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="phone" class="form-label">Phone number</label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                   class="form-input @error('phone') !border-red-400 @enderror"
                   required placeholder="+63 9XX XXX XXXX">
            @error('phone') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="specialization" class="form-label">Specialization</label>
            <input id="specialization" type="text" name="specialization" value="{{ old('specialization') }}"
                   class="form-input @error('specialization') !border-red-400 @enderror"
                   required placeholder="e.g., Corporate Law, Criminal Law">
            @error('specialization') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="experience_years" class="form-label">Years of experience</label>
            <input id="experience_years" type="number" name="experience_years" value="{{ old('experience_years') }}"
                   class="form-input @error('experience_years') !border-red-400 @enderror"
                   required min="0" max="70" placeholder="0">
            @error('experience_years') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password"
                   class="form-input @error('password') !border-red-400 @enderror"
                   required autocomplete="new-password" placeholder="Min. 8 characters">
            @error('password') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="form-label">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="form-input" required autocomplete="new-password" placeholder="Re-enter password">
        </div>

        <button type="submit" class="btn-primary mt-2">Create Account →</button>

        <p class="text-center text-xs" style="color:var(--muted);">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium" style="color:var(--gold);">Sign in</a>
        </p>
    </form>

</x-guest-layout>
