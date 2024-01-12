@extends('layouts.backend.app')
@section('css')
    <link href="{{ asset('backend/assets/css/dashboard/dashboard_1.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-header')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            {{-- <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboards</a></li> --}}
            <li class="breadcrumb-item active" aria-current="page"><span>หน้าหลัก</span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-lg-12 layout-spacing">

            <div class="layout-px-spacing">
                <div class="row layout-top-spacing">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 mb-2">
                                <div class="widget">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="mr-3">
                                            <span class="quick-category-icon qc-primary rounded-circle">
                                                <i class="las la-shopping-cart"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">รายการสั่งซื้อวันนี้</h5>
                                    </div>
                                    <div class="text-muted mt-3">
                                        <h5 class="mb-2">{{number_format($orders_count)}} รายการ
                                            {{-- <i class="las la-angle-up text-success-teal"></i> --}}
                                        </h5>
                                        {{-- <div class="d-flex">
                                            <span class="badge badge-success-teal font-size-12"> + 0.2% </span>
                                            <span class="ml-2 text-truncate">เทียบจากเดือนที่แล้ว</span>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 mb-2">
                                <div class="widget">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="mr-3">
                                            <span class="quick-category-icon qc-primary rounded-circle">
                                                <i class="las la-hand-holding-usd"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">ยอดขายทั้งหมด</h5>
                                    </div>
                                    <div class="text-muted mt-3">
                                        <h5 class="mb-2">฿ 20K
                                            <i class="las la-angle-down text-danger"></i>
                                        </h5>
                                        <div class="d-flex">
                                            <span class="badge badge-danger font-size-12"> - 5.4% </span>
                                            <span class="ml-2 text-truncate">เทียบจากเดือนที่แล้ว</span>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 mb-2">
                                <div class="widget">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="mr-3">
                                            <span class="quick-category-icon qc-primary rounded-circle">
                                                <i class="las la-user"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">จำนวนสมาชิกทั้งหมด</h5>
                                    </div>
                                    <div class="text-muted mt-3">
                                        <h5 class="mb-2">{{number_format($customers_count)}} คน
                                            {{-- <i class="las la-angle-up text-success-teal"></i> --}}
                                        </h5>
                                        {{-- <div class="d-flex">
                                            <span class="badge badge-success-teal font-size-12"> + 25% </span>
                                            <span class="ml-2 text-truncate">เทียบจากเดือนที่แล้ว</span>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 mb-2">
                                <div class="widget">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="mr-3">
                                            <span class="quick-category-icon qc-primary rounded-circle">
                                                <i class="las la-user-plus"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">จำนวนสมาชิกใหม่</h5>
                                    </div>
                                    <div class="text-muted mt-3">
                                        <h5 class="mb-2">1,000 คน
                                            <i class="las la-angle-up text-success-teal"></i>
                                        </h5>
                                        <div class="d-flex">
                                            <span class="badge badge-success-teal font-size-12"> + 10% </span>
                                            <span class="ml-2 text-truncate">เทียบจากเดือนที่แล้ว</span>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    {{-- <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-chart-one">
                            <div class="widget-heading">
                                <div>
                                    <h5 class="">รายงานข้อมูลสมาชิก</h5>
                                    <span class="w-numeric-title">ตามตำแหน่ง</span>
                                </div>
                                <ul class="tabs tab-pills list-unstyled">
                                    <li>
                                        <div class="dropdown  custom-dropdown-icon">
                                            <a class="dropdown-toggle" href="#" role="button" id="customDropdown"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>New
                                                    Member</span> <i class="las la-angle-down"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown">
                                                <a class="dropdown-item" data-value="Bronze"
                                                    href="javascript:void(0);">Bronze</a>
                                                <a class="dropdown-item" data-value="Silver"
                                                    href="javascript:void(0);">Silver</a>
                                                <a class="dropdown-item" data-value="Gold"
                                                    href="javascript:void(0);">Gold</a>
                                                <a class="dropdown-item" data-value="Diamond"
                                                    href="javascript:void(0);">Diamond</a>
                                                <a class="dropdown-item" data-value="Member"
                                                    href="javascript:void(0);">Member</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="row mt-10">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-10">
                                    <div class="widget-content">
                                        <div class="sales-summary-content d-flex mb-3 mt-4">
                                            <div class="sales-summary-icon mr-3">
                                                <i class="las la-user sales-primary-icon"></i>
                                            </div>
                                            <div class="sales-progress flex-grow-1">
                                                <span class="font-12">จำนวนสมาชิก</span>
                                                <span class="font-12 float-right">2,000</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-gradient-primary" role="progressbar"
                                                        aria-valuenow="70" style="width:70%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sales-summary-content d-flex mb-0">
                                            <div class="sales-summary-icon mr-3">
                                                <i class="las las la-hand-holding-usd sales-success-icon"></i>
                                            </div>
                                            <div class="sales-progress flex-grow-1">
                                                <span class="font-12">ยอดขาย</span>
                                                <span class="font-12 float-right">$ 100,000</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-gradient-success" role="progressbar"
                                                        aria-valuenow="35" style="width:35%"></div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>
                    </div> --}}

                    {{-- <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget dashboard-table">
                            <div class="widget-heading">
                                <h5 class="">TOPS 10 of the month</h5>
                                <div class="dropdown custom-dropdown-icon">
                                    <a class="dropdown-toggle" href="#" role="button" id="customDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>รายได้</span> <i class="las la-angle-down"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown" style="will-change: transform;">
                                        <a class="dropdown-item" data-value="Mail" href="javascript:void(0);">โบนัส</a>
                                        <a class="dropdown-item" data-value="Print" href="javascript:void(0);">การแนะนำ</a>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">สมาชิก</div></th>
                                                <th><div class="th-content">ตำแหน่ง</div></th>
                                                <th><div class="th-content">รายได้</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-center">
                                                        <img src="{{asset('backend/assets/img/profile-16.jpg')}}" class="avatar-sm rounded-circle border-width-2px border-solid border-light mr-3" alt="avatar">
                                                        <p class="mb-0">กิ่งทอง</p>
                                                    </div>
                                                </td>
                                                <td><span class="text-success">Diamond</span></td>
                                                <td><span class="text-warning">$ 100,000</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-center">
                                                        <img src="{{asset('backend/assets/img/profile-16.jpg')}}" class="avatar-sm rounded-circle border-width-2px border-solid border-light mr-3" alt="avatar">
                                                        <p class="mb-0">ใบหยก</p>
                                                    </div>
                                                </td>
                                                <td><span class="text-success">Diamond</span></td>
                                                <td><span class="text-warning">$ 50,000</span></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> --}}


                </div>
            </div>
        </div>
        {{-- </div> --}}
    </div>
@endsection
@section('js')
@endsection
