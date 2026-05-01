<x-guest-layout>
    <div class="mb-7">
        <h2 class="serif text-2xl" style="font-style:italic; color:var(--navy);">New password</h2>
        <p class="mt-1 text-sm" style="color:var(--muted);">Choose a strong password for your account.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                   class="form-input @error('email') !border-red-400 @enderror" required>
            @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="form-label">New password</label>
            <input id="password" type="password" name="password"
                   class="form-input @error('password') !border-red-400 @enderror"
                   required autocomplete="new-password" placeholder="Min. 8 characters">
            @error('password') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="form-label">Confirm new password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="form-input" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn-primary">Reset Password →</button>
    </form>
</x-guest-layout>