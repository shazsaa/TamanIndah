<x-guest-layout>
    <h5 class="text-center mb-3 fw-bold">Lupa Password</h5>

    <p class="small text-muted mb-3">
        Masukkan email kamu dan kami akan mengirimkan link untuk reset password.
    </p>

    @if (session('status'))
        <div class="alert alert-success small mb-3" role="alert">
            Link reset password telah dikirim ke email kamu.
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label small mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                style="height: 38px; font-size: 13px; border: 0.5px solid #d8e8d8; border-radius: 8px; padding: 0 12px; width: 100%; box-sizing: border-box; background: #fafaf9;">
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit"
            style="width: 100%; height: 38px; background: #4A7C59; color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: 500;">
            Kirim Link Reset Password
        </button>
    </form>

    <hr style="border: none; border-top: 0.5px solid #f0f0f0; margin: 12px 0;">
    <a href="{{ route('login') }}"
        style="display: flex; align-items: center; justify-content: center; gap: 4px; font-size: 12px; color: #4A7C59; text-decoration: none;">
        ← Kembali ke Login
    </a>
</x-guest-layout>
