<div class="container-fluid">
  <main class="card shadow-lg p-4 rounded-4 position-absolute top-50 start-50 translate-middle" style="max-width: 420px; width: 100%;">
    <div class="text-center mb-4">
      <i class="fa-solid fa-envelope-circle-check fs-1 text-primary mb-4"></i>
      <h1 class="h4 fw-bold">Verifikasi Email Anda</h1>
      <p class="text-muted small">
        {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
      </p>
    </div>

    @if (session('status') == 'verification-link-sent')
      <div class="alert alert-success text-center" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>
        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
      </div>
    @endif

    <div class="d-grid gap-3">
      <button wire:click="sendVerification" class="btn btn-primary py-2" wire:loading.attr="disabled">
        <span wire:loading.remove>
          <i class="fa-solid fa-envelope me-2"></i> {{ __('Resend verification email') }}
        </span>
        <span wire:loading>
          <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Mengirim...
        </span>
      </button>

      <button wire:click="logout" class="btn btn-outline-secondary py-2">
        <i class="fa-solid fa-right-from-bracket me-2"></i> {{ __('Log out') }}
      </button>
    </div>
  </main>
</div>
