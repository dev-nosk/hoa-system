@extends('layouts.MainLayout')


@section('content')
<div class="row g-0">
    <div class="col-xxl-6 px-xxl-2">
        <div class="card h-100">
            <div class="card-header bg-body-tertiary py-2">
                <div class="row flex-between-center">
                    <div class="col-auto">
                        <h6 class="mb-0">Service</h6>
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
                    <h3 class="mb-3">Service List</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection