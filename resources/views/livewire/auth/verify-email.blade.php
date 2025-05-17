<div class="container mt-5">
    <div class="text-center">
        <h4>Verifikasi Email</h4>
        <p>
            {{ __('Silakan verifikasi alamat email Anda dengan mengklik tautan yang telah kami kirim.') }}
        </p>
    </div>

    @if (session('status') === 'verification-link-sent')
        <div class="alert alert-success text-center">
            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
        </div>
    @endif

    <div class="d-flex flex-column align-items-center mt-4 gap-3">
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                {{ __('Kirim Ulang Email Verifikasi') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-danger">
                {{ __('Logout') }}
            </button>
        </form>
    </div>
</div>