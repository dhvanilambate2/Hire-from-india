<section class="mb-5">

    <!-- Header -->
    <header class="mb-3">
        <h2 class="h5">
            {{ __('Update Password') }}
        </h2>

        <p class="text-muted">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <!-- Success Message -->
    @if (session('status') === 'password-updated')
        <div class="alert alert-success mb-3">
            {{ __('Password updated successfully.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="mb-3">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="@error('current_password', 'updatePassword') is-invalid @enderror"
            />
            <x-input-error
                :messages="$errors->updatePassword->get('current_password')"
            />
        </div>

        <!-- New Password -->
        <div class="mb-3">
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="@error('password', 'updatePassword') is-invalid @enderror"
            />
            <x-input-error
                :messages="$errors->updatePassword->get('password')"
            />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="@error('password_confirmation', 'updatePassword') is-invalid @enderror"
            />
            <x-input-error
                :messages="$errors->updatePassword->get('password_confirmation')"
            />
        </div>

        <!-- Actions -->
        <div class="d-flex align-items-center gap-3">
            <x-primary-button>
                {{ __('Save') }}
            </x-primary-button>
        </div>
    </form>

</section>
