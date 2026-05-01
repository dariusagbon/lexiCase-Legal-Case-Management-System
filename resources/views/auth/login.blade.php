<x-guest-layout>

    <div class="mb-7">
        <h2 class="serif text-2xl" style="font-style:italic; color:var(--navy);">Welcome back</h2>
        <p class="mt-1 text-sm" style="color:var(--muted);">Sign in to access your legal dashboard.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-input @error('email') !border-red-400 @enderror"
                   required autofocus autocomplete="username" placeholder="you@lawfirm.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password"
                   class="form-input @error('password') !border-red-400 @enderror"
                   required autocomplete="current-password" placeholder="••••••••">
            @error('password')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                       class="w-4 h-4 rounded" style="accent-color:var(--gold);">
                <span class="text-xs" style="color:var(--muted);">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs font-medium transition"
                   style="color:var(--gold);">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn-primary mt-2">
            Sign In →
        </button>
    </form>

</x-guest-layout>