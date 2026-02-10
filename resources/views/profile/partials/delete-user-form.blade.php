<section class="mb-5">

    <!-- Header -->
    <header class="mb-3">
        <h2 class="h5">
            {{ __('Delete Account') }}
        </h2>

        <p class="text-muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <!-- Trigger Button -->
    <button
        type="button"
        class="btn btn-danger"
        data-bs-toggle="modal"
        data-bs-target="#confirmUserDeletion"
    >
        {{ __('Delete Account') }}
    </button>

    <!-- Modal -->
    <x-modal name="confirmUserDeletion" title="{{ __('Confirm Account Deletion') }}">

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <p class="text-muted mb-3">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <!-- Password -->
            <div class="mb-3">
                <x-input-label for="password" value="{{ __('Password') }}" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error
                    :messages="$errors->userDeletion->get('password')"
                />
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-end gap-2">
                <x-secondary-button
                    type="button"
                    data-bs-dismiss="modal"
                >
                    {{ __('Cancel') }}
                </x-secondary-button>

                <button type="submit" class="btn btn-danger">
                    {{ __('Delete Account') }}
                </button>
            </div>

        </form>

    </x-modal>

</section>
