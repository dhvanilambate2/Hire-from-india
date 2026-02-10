@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- Page Title -->
    <div class="mb-4">
        <h1 class="h4">
            {{ __('Dashboard') }}
        </h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm">
                <div class="card-body">
                    {{ __("You're logged in!") }}
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
