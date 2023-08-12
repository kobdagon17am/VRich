@extends('layouts.backend.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/table/datatable/dt-global_style.css') }}">
    <link href="{{ asset('backend/assets/css/ui-elements/pagination.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/select2/select2.min.css') }}">
    <link href="{{ asset('backend/assets/css/forms/form-widgets.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('page-header')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">ระบบบริการสมาชิก</li>
            <li class="breadcrumb-item active" aria-current="page"><span>ระบบบริการสมาชิก</span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="widget-content widget-content-area br-6">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-12 col-sm-12"><b>รหัสสมาชิก</b></label>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <select class="form-control dynamic-data">
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-12 col-sm-12"><b>ชื่อสมาชิก</b></label>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <select class="form-control dynamic-data">
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-12 col-sm-12"><b>รหัสผู้แนะนำ</b></label>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <select class="form-control dynamic-data">
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-12 col-sm-12"><b>หมายเลขบัตรประชาชน</b></label>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <select class="form-control dynamic-data">
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-2 text-center">
                <button type="button" class="btn btn-outline-primary btn-rounded mt-4"><i class="las la-search"></i>
                    สืบค้น</button>
            </div>
        </div>
        <br>
        <div class="table-responsive mb-4">
            <table id="ordertable" class="table table-hover table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>รหัสสมาชิก</th>
                        <th>ชื่อสมาชิก</th>
                        <th>คะแนน PV</th>
                        <th>รหัสผู้แนะนำ</th>
                        {{-- <th>สถานะการสมัคร</th> --}}
                        <th>วันที่อนุมัติ</th>
                        <th>รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>A001</td>
                        <td>Vrich</td>
                        <td>200</td>
                        <td>A000</td>
                        {{-- <td>
                            <i class="las la-id-card font-35 text-success"></i>
                            <i class="las la-portrait font-35 text-success"></i>
                            <i class="las la-id-card-alt font-35 text-info"></i>
                            <i class="las la-money-check font-35 text-info"></i>
                        </td> --}}
                        <td>06/09/2023</td>
                        <td>
                            <a href="#!" class="p-2">
                                <i class="las la-sign-in-alt font-25 text-success"></i></a>
                            <a href="{{route('admin/EditProfile')}}" class="p-2">
                                <i class="las la-user-edit font-25 text-info"></i></a>

                            <a href="#!" class="p-2" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="lab la-whmcs font-25 text-warning"></i></a>

                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="#">เปลี่ยนแปลงรหัสผ่าน</a>
                                <a class="dropdown-item" href="#">ยกเลิกรหัสสมาชิก</a>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>A001</td>
                        <td>Vrich</td>
                        <td>200</td>
                        <td>A000</td>
                        {{-- <td>
                            <div class="row">
                                <div class="col-md-12">
                                    <i class="las la-id-card font-35"></i>
                                    <i class="las la-portrait font-35 text-danger"></i>
                                    <i class="las la-id-card-alt font-35 text-danger"></i>
                                    <i class="las la-money-check font-35 text-info"></i>
                                </div>
                            </div>
                        </td> --}}
                        <td>06/09/2023</td>
                        <td>
                            <a href="#!" class="p-2">
                                <i class="las la-sign-in-alt font-25 text-success"></i></a>
                            <a href="{{route('admin/EditProfile')}}" class="p-2">
                                <i class="las la-user-edit font-25 text-info"></i></a>

                            <a href="#!" class="p-2" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="lab la-whmcs font-25 text-warning"></i></a>

                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="#">เปลี่ยนแปลงรหัสผ่าน</a>
                                <a class="dropdown-item" href="#">ยกเลิกรหัสสมาชิก</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- <div class="pagination p1">
            <ul class="mx-auto">
                <a href="previous">
                    <li><i class="las la-angle-left"></i></li>
                </a>
                <a class="is-active" href="page">
                    <li>1</li>
                </a>
                <a href="page2">
                    <li>2</li>
                </a>
                <a href="page2">
                    <li>3</li>
                </a>
                <a href="next">
                    <li><i class="las la-angle-right"></i></li>
                </a>
            </ul>
        </div> --}}
        {{-- <div class="row ml-4">
            <label class="text-left"><b>*หมายเหตุ :</b></label>
            <label class="text-left ml-2">สีดำ = ยังไม่ส่ง,</label>
            <label class="text-left text-info ml-2">สีน้ำเงิน = รอตรวจสอบ,</label>
            <label class="text-left text-success ml-2">สีเขียว = ผ่าน,</label>
            <label class="text-left text-danger ml-2">สีแดง = ไม่ผ่าน</label>
        </div>
        <div class="row">

            <div class="col-md-12">

                <li class="las la-id-card font-25 ml-4"></li>
                <label class="text-left"><b>: ภาพถ่ายหน้าบัตรประชาชน</b></label>
            </div>

            <div class="col-md-12">

                <i class="las la-portrait font-25 ml-4"></i>
                <label class="text-left"><b>: ภาพถ่ายหน้าตรง</b></label>
            </div>

            <div class="col-md-12">

                <i class="las la-id-card-alt font-25 ml-4"></i>
                <label class="text-left"><b>: ภาพหน้าตรงพร้อมบัตรประชาชน</b></label>
            </div>

            <div class="col-md-12">

                <i class="las la-money-check font-25 ml-4"></i>
                <label class="text-left"><b>: ภาพถ่ายหน้าบัญชีธนาคาร</b></label>
            </div>
        </div> --}}


    </div>
@endsection
@section('js')
    <script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/forms/custom-select2.js') }}"></script>
@endsection
