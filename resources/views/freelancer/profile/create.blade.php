@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-body">

                    <form method="POST">
                        @csrf

                        <!-- Skills -->
                        <div class="mb-3">
                            <label class="form-label">Skills</label>
                            <input
                                type="text"
                                name="skills"
                                class="form-control"
                                placeholder="Skills"
                            >
                        </div>

                        <!-- Hourly Rate -->
                        <div class="mb-3">
                            <label class="form-label">Hourly Rate</label>
                            <input
                                type="number"
                                name="hourly_rate"
                                class="form-control"
                                placeholder="Rate"
                            >
                        </div>

                        <!-- Availability -->
                        <div class="mb-3">
                            <label class="form-label">Availability</label>
                            <select name="availability" class="form-select">
                                <option value="">Select availability</option>
                                <option value="part-time">Part-time</option>
                                <option value="full-time">Full-time</option>
                            </select>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
