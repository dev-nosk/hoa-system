@extends('layouts.MainLayout')


@section('content')
<div class="row g-0">
    <div class="col-xxl-6 px-xxl-2">
        <div class="card h-100">
            <div class="card-header bg-body-tertiary py-2">
                <div class="row flex-between-center">
                    <div class="col-auto">
                        <h6 class="mb-0"><span id="system_display">Feed</span></h6>
                    </div>
                    <div class="col-auto d-flex"><a class="btn btn-link btn-sm me-2" href="#!">View Details</a>
                        <div class="dropdown font-sans-serif btn-reveal-trigger"><button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-top-products" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs-11"></span></button>
                            <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-top-products"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body h-100">
                <div class="container-fluid mt-4">
                    <div id="content-display" style="min-height: 60vh;">

                        <div class="p-3">
                            <div class="skeleton skeleton-title"></div>
                            <div class="skeleton skeleton-text"></div>
                            <div class="skeleton skeleton-text"></div>
                            <div class="skeleton skeleton-text"></div>
                            <div class="mt-3 skeleton skeleton-button"></div>
                        </div>
                         <div class="p-3">
                            <div class="skeleton skeleton-title"></div>
                            <div class="skeleton skeleton-text"></div>
                            <div class="skeleton skeleton-text"></div>
                            <div class="skeleton skeleton-text"></div>
                            <div class="mt-3 skeleton skeleton-button"></div>
                        </div>
                         <div class="p-3">
                            <div class="skeleton skeleton-title"></div>
                            <div class="skeleton skeleton-text"></div>
                            <div class="skeleton skeleton-text"></div>
                            <div class="skeleton skeleton-text"></div>
                            <div class="mt-3 skeleton skeleton-button"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="page-overlay" style="
    display:none;
    position:fixed;
    inset:0;
    background:rgba(255,255,255,0.7);
    z-index:9999;
">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div>
            <div class="spinner-border text-primary"></div>
            <div class="mt-2 text-center">Saving...</div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('form_builder/js/view-record.js') }}?v={{ config('app.asset_version') }}"></script>
<script src="{{ asset('form_builder/js/create-record.js') }}?v={{ config('app.asset_version') }}"></script>
<script src="{{ asset('form_builder/js/list-view.js') }}?v={{ config('app.asset_version') }}"></script>
<script src="{{ asset('form_builder/js/field-amount.js') }}?v={{ config('app.asset_version') }}"></script>
<script src="{{ asset('form_builder/js/field-lookup.js') }}?v={{ config('app.asset_version') }}"></script>
<script src="{{ asset('form_builder/js/field-category.js') }}?v={{ config('app.asset_version') }}"></script>
@endsection