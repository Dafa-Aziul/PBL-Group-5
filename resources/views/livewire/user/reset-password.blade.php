<div>
    <h2 class="mt-4">Reset Password Menu</h2>
    <ol class="breadcrumb mb-4">
        {{-- <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('user.view') }}">Profile</a></li> --}}
        <li class="breadcrumb-item active">Change your password</li>
    </ol>
    <form wire:submit.prevent="updatePassword" class="space-y-4">
        <div>
            <label for="current_password" class="block font-medium text-sm text-gray-700">Password Saat Ini</label>
            <input type="password" id="current_password" wire:model.defer="current_password"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password" class="block font-medium text-sm text-gray-700">Password Baru</label>
            <input type="password" id="password" wire:model.defer="password"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Konfirmasi Password
                Baru</label>
            <input type="password" id="password_confirmation" wire:model.defer="password_confirmation"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                Update Password
            </button>
        </div>

        @if (session()->has('status') && session('status') === 'password-updated')
        <div class="text-green-600 mt-2">
            Password berhasil diperbarui.
        </div>
        @endif
    </form>
</div>
