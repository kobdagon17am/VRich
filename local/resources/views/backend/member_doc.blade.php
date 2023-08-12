@extends('layouts.backend.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/table/datatable/dt-global_style.css') }}">
    <link href="{{ asset('backend/assets/css/ui-elements/pagination.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/select2/select2.min.css') }}">
    <link href="{{ asset('backend/assets/css/pages/profile.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/forms/form-widgets.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-header')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">ระบบบริการสมาชิก</li>
            <li class="breadcrumb-item active" aria-current="page"><span>ระบบตรวจสอบเอกสาร</span></li>
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
            {{-- <div class="col-md-2">
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-12 col-sm-12"><b>รหัสผู้แนะนำ</b></label>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <select class="form-control dynamic-data">
                        </select>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-2">
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-12 col-sm-12"><b>สถานะการตรวจสอบ</b></label>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <select class="form-control" id="verifyDoc_status">
                            <option>รอตรวจสอบ</option>
                            <option>ผ่าน</option>
                            <option>ไม่ผ่าน</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-12 col-sm-12"><b>ประเทศ</b></label>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <select class="form-control" id="business_location">
                            <option>Thailand</option>
                            <option>Cambodia</option>
                            <option>Laos</option>
                            <option>Myanmar</option>
                            <option>Vietnam</option>
                        </select>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-12 col-sm-12"><b>หมายเลขบัตรประชาชน</b></label>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <select class="form-control dynamic-data">
                        </select>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-2 mt-4 text-center">
                <button type="button" class="btn btn-outline-primary btn-rounded"><i class="las la-search"></i>
                    สืบค้น</button>
            </div>
        </div>
        <p>
        </p>
        <div class="table-responsive mb-4">
            <table id="ordertable" class="table table-hover table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>รหัสสมาชิก</th>
                        <th>ชื่อสมาชิก</th>
                        <th>รหัสผู้แนะนำ</th>
                        <th>สถานะการตรวจสอบ</th>
                        <th>ผู้อนุมัติ</th>
                        <th>วันที่อนุมัติ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>A001</td>
                        <td>Vrich</td>
                        <td>A000</td>
                        <td>
                            <div class="row">
                                <div class="col-md-12">

                                    <a href="#!" data-toggle="modal" data-target=".verify_1"><i
                                            class="las la-id-card font-35 text-danger"></i></a>
                                    <i class="las la-portrait font-35 text-success"></i>
                                    <i class="las la-id-card-alt font-35 text-info"></i>
                                    <i class="las la-money-check font-35"></i>
                                </div>
                            </div>
                        </td>
                        <td>นำโชค</td>
                        <td>06/09/2023</td>

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
        <div class="row ml-4">
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
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl verify_1" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel"><b>ตรวจสอบภาพถ่ายหน้าบัตรประชาชน</b></h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img class="img-fluid" src="{{ asset('backend/assets/img/idcard.png') }}">
                    </div>
                    <div class="col-md-8 p-4 ">
                        {{-- <div class="profile-shadow p-4"> --}}
                            <h6 class="font-16 mb-3 mt-2">ข้อมูลพื้นฐาน (GENERAL INFORMATION)</h6>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Prefix">คำนำหน้า
                                            <span class="text-danger">* </span></label>
                                        <select class="form-control" id="Prefix">
                                            <option>นาย</option>
                                            <option>นาง</option>
                                            <option>นางสาว</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="firstname">ชื่อ
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="firstname" placeholder="ชื่อ">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="lastname">นามสุกล
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lastname" placeholder="นามสุกล">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="maritalstatus">สถานภาพ
                                            <span class="text-danger">*</span></label>
                                        <select class="form-control" id="maritalstatus">
                                            <option>โสด</option>
                                            <option>สมรส</option>
                                            <option>หย่าร้าง</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="businessname">ชื่อในทางธุรกิจ
                                            <span class="text-danger">* กรณีที่ไม่มีให้ใส่
                                                (-)</span></label>
                                        <input type="text" class="form-control" id="businessname"
                                            placeholder="ชื่อในทางธุรกิจ">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="birthdate">วัน/เดือน/ปี เกิด
                                            <span class="text-danger"></span>*</label>
                                        <div>
                                            <input class="form-control" type="date" value="yyyy-mm-dd"
                                                id="birthdate">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="idcard">หมายเลขบัตรประชาชน
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="idcard"
                                            placeholder="หมายเลขบัตรประชาชน">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country">ประเทศ
                                            <span class="text-danger">*</span></label>
                                        <select class="form-control" id="country">
                                            <option>ไทย</option>
                                            <option>ไทย (ไม่มีสัญชาติ)</option>
                                            <option>ลาว</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="national">สัญชาติ
                                            <span class="text-danger">*</span></label>
                                        <select class="form-control" id="national">
                                            <option>ไทย</option>
                                            <option>ลาว</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        {{-- </div> --}}
                    </div>
                    <div class="col-md-12 mt-4">
                        <hr>
                        <label
                            class="col-form-label text-center col-lg-12 col-sm-12"><u><b>ยืนยันการตรวจสอบเอกสาร</b></u></label>
                        <div class="row">
                            <div class="col-md-2 ">
                            </div>
                            <div class="col-md-4 p-4">
                                <div class="form-group">
                                    <label for="firstname"><b>หมายเหตุ : </b></label>
                                    <textarea class="form-control" id="remark" placeholder="หมายเหตุ"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4 p-4">
                                <div class="form-group">
                                    <label for="maritalstatus"><b>ผลการตรวจสอบ :</b></label>
                                    <select class="form-control" id="verify_status">
                                        <option>ผ่าน</option>
                                        <option>ไม่ผ่าน</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="info-area col-md-12 text-center">
                                <button type="submit" class="btn btn-info">
                                    <i class="las la-save"></i> บันทึก</button>
                            </div>
                        </div>
                    </div>


                </div>

                </p>
            </div>

        </div>
    </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/forms/custom-select2.js') }}"></script>
@endsection
