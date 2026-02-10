<section class="mb-5">

    <!-- Header -->
    <header class="mb-3">
        <h2 class="h5">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Email verification form -->
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Success message -->
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success mb-3">
            {{ __('Profile updated successfully.') }}
        </div>
    @endif

    @if (session('status') === 'verification-link-sent')
        <div class="alert alert-success mb-3">
            {{ __('A new verification link has been sent to your email address.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Name -->
        <div class="mb-3">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
                class="@error('name') is-invalid @enderror"
            />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
                class="@error('email') is-invalid @enderror"
            />
            <x-input-error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-muted mb-1">
                        {{ __('Your email address is unverified.') }}
                    </p>

                    <button
                        type="submit"
                        form="send-verification"
                        class="btn btn-link p-0"
                    >
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="d-flex gap-3">
            <x-primary-button>
                {{ __('Save') }}
            </x-primary-button>
        </div>

    </form>
</section>
