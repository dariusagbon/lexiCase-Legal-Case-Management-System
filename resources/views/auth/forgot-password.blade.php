<x-guest-layout>

    <div class="mb-7">
        <h2 class="serif text-2xl" style="font-style:italic; color:var(--navy);">Reset password</h2>
        <p class="mt-1 text-sm" style="color:var(--muted);">Enter your email and we'll send a reset link.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-input @error('email') !border-red-400 @enderror"
                   required autofocus placeholder="you@lawfirm.com">
            @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn-primary">Send Reset Link →</button>

        <p class="text-center text-xs" style="color:var(--muted);">
            <a href="{{ route('login') }}" class="font-medium" style="color:var(--gold);">← Back to sign in</a>
        </p>
    </form>

</x-guest-layout>   