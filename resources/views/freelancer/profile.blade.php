@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <!-- Page Title -->
            <h2 class="mb-4">Freelancer Profile</h2>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">

                    <form method="POST" action="{{ route('freelancer.profile.store') }}">
                        @csrf

                        <!-- Skills -->
                        <div class="mb-3">
                            <x-input-label value="Skills" />
                            <textarea
                                name="skills"
                                class="form-control"
                                rows="4"
                            >{{ old('skills', $profile->skills ?? '') }}</textarea>
                        </div>

                        <!-- Hourly Rate -->
                        <div class="mb-3">
                            <x-input-label value="Hourly Rate (₹)" />
                            <x-text-input
                                type="number"
                                name="hourly_rate"
                                value="{{ old('hourly_rate', $profile->hourly_rate ?? '') }}"
                            />
                        </div>

                        <!-- Availability -->
                        <div class="mb-4">
                            <x-input-label value="Availability" />
                            <select name="availability" class="form-select">
                                <option value="part-time"
                                    @selected(($profile->availability ?? '') === 'part-time')
                                >
                                    Part-time
                                </option>
                                <option value="full-time"
                                    @selected(($profile->availability ?? '') === 'full-time')
                                >
                                    Full-time
                                </option>
                            </select>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex justify-content-end">
                            <x-primary-button>
                                Save Profile
                            </x-primary-button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
