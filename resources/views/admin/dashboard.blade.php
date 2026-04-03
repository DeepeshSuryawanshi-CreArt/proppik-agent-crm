@extends('admin.layouts.vertical', ['title' => $title, 'subTitle' => 'Admin Dashboard demo'])

@section('content')
    <div class="row">
        <!-- propert count caard -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-6">
                            <div class="avatar-md bg-light bg-opacity-50 rounded">
                                <iconify-icon icon="solar:buildings-2-broken"
                                    class="fs-32 text-primary avatar-title"></iconify-icon>
                            </div>
                            <p class="text-muted mb-2 mt-3">No. of Properties</p>
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0">{{ number_format(100) }}</h3>
                        </div> <!-- end col -->
                        <div class="col-6">
                            <div id="total_property_card" class="apex-charts"></div>
                        </div> <!-- end col -->
                    </div> <!-- end row-->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
        <!-- live tour count card -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-6">
                            <div class="avatar-md bg-light bg-opacity-50 rounded">
                                <iconify-icon icon="solar:users-group-two-rounded-broken"
                                    class="fs-32 text-primary avatar-title"></iconify-icon>
                            </div>
                            <p class="text-muted mb-2 mt-3">Live Tours</p>
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0">{{ number_format(100) }}</h3>
                        </div> <!-- end col -->
                        <div class="col-6 text-end">
                            <div id="live_tours_card" class="apex-charts"></div>
                        </div> <!-- end col -->
                    </div> <!-- end row-->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
        <!-- total customer card -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-5">
                            <div class="avatar-md bg-light bg-opacity-50 rounded">
                                <iconify-icon icon="solar:shield-user-broken"
                                    class="fs-32 text-primary avatar-title"></iconify-icon>
                            </div>
                            <p class="text-muted mb-2 mt-3">Customers</p>
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0">{{ number_format(100) }}</h3>
                        </div> <!-- end col -->
                        <div class="col-6 text-end">
                            <div id="total_customer_card" class="apex-charts"></div>
                        </div> <!-- end col -->
                    </div> <!-- end row-->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
        <!-- total revenue -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-5">
                            <div class="avatar-md bg-light bg-opacity-50 rounded">
                                <iconify-icon icon="solar:money-bag-broken"
                                    class="fs-32 text-primary avatar-title"></iconify-icon>
                            </div>
                            <p class="text-muted mb-2 mt-3">Revenue</p>
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0">
                                ₹{{ number_format(200 / 100, 2) }}</h3>
                        </div> <!-- end col -->
                        <div class="col-6 text-end">
                            <div id="total_revenue_card" class="apex-charts"></div>
                        </div> <!-- end col -->
                    </div> <!-- end row-->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->
    <div class="d-none row">
        <div class="col-xl-3 col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center pb-1">
                    <div>
                        <h4 class="card-title mb-1">Social Source</h4>
                        <p class="fs-13 mb-0">Total Traffic In This Week</p>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light rounded" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            This Month
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="#!" class="dropdown-item">Week</a>
                            <!-- item-->
                            <a href="#!" class="dropdown-item">Months</a>
                            <!-- item-->
                            <a href="#!" class="dropdown-item">Years</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="own-property" class="apex-charts"></div>
                    <p class="mb-0 fs-18 fw-medium text-dark"><i class="ri-group-fill"></i> Buyers : <span
                            class="text-primary fw-bold">70</span></p>
                </div>
                <div class="card-footer border-top d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">See More Statistic</h5>
                    <div>
                        <a href="#!" class="btn btn-primary btn-sm">See Details</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center pb-1">
                    <div>
                        <h4 class="card-title">Most Sales Location</h4>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light rounded" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Asia
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">U.S.A</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Russia</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">China</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Canada</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div id="most-sales-location" class="mt-3" style="height: 322px">
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-5 overflow-visible" style="height: 25px;">
                        <div class="progress-bar bg-primary  position-relative overflow-visible rounded-start"
                            role="progressbar" style="width: 20%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                            <p class="progress-value text-start text-dark mb-0 mt-1 fs-14 fw-medium"
                                style="left: 0% !important; top: -50px !important;">Canada</p>
                            <p class="progress-value text-start text-light mb-0 mt-1 fs-14 fw-medium"
                                style="left: 0% !important; top: -30px !important;">|</p>
                            <p class="mb-0  text-start ps-1 ps-lg-2 text-white fs-14">71.1%</p>
                        </div>
                        <div class="progress-bar bg-primary bg-opacity-75 position-relative overflow-visible"
                            role="progressbar" style="width: 20%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                            <p class="progress-value text-start text-dark mb-0 mt-1 fs-14 fw-medium"
                                style="left: 0% !important; top: -50px !important;">USA </p>
                            <p class="progress-value text-start text-light mb-0 mt-1 fs-14 fw-medium"
                                style="left: 0% !important; top: -30px !important;">| </p>
                            <p class="mb-0  text-start ps-1 ps-lg-2 text-white fs-14">67.0%</p>
                        </div>
                        <div class="progress-bar bg-primary bg-opacity-50 position-relative overflow-visible"
                            role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                            <p class="progress-value text-start text-dark mb-0 mt-1 fs-14 fw-medium"
                                style="left: 0% !important; top: -50px !important;">Brazil</p>
                            <p class="progress-value text-start text-light mb-0 mt-1 fs-14 fw-medium"
                                style="left: 0% !important; top: -30px !important;">|</p>
                            <p class="mb-0  text-start ps-1 ps-lg-2 text-white fs-14">53.9%</p>
                        </div>
                        <div class="progress-bar bg-primary bg-opacity-25 position-relative overflow-visible"
                            role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                            <p class="progress-value text-start text-dark mb-0 mt-1 fs-14 fw-medium"
                                style="left: 0% !important; top: -50px !important;">Russia</p>
                            <p class="progress-value text-start text-light mb-0 mt-1 fs-14 fw-medium"
                                style="left: 0% !important; top: -30px !important;">| </p>

                            <p class="mb-0  text-start ps-1 ps-lg-2 text-white fs-14">49.2%</p>
                        </div>
                        <div class="progress-bar bg-primary bg-opacity-10 position-relative overflow-visible rounded-end"
                            role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                            <p class="progress-value text-start text-dark mb-0 mt-1 fs-14 fw-medium"
                                style="left: 0% !important; top: -50px !important;">China </p>
                            <p class="progress-value text-start text-light mb-0 mt-1 fs-14 fw-medium"
                                style="left: 0% !important; top: -30px !important;">| </p>

                            <p class="mb-0  text-start ps-1 ps-lg-2 text-white fs-14">38.8%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
@endsection