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
            <li class="breadcrumb-item">แก้ไขข้อมูลสมาชิก</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="widget-content widget-content-area br-6">
        <div class="media">
            <div class="profile-shadow w-100">
                <h6 class="font-16 mb-3"><b>แก้ไขข้อมูลสมาชิก</b></h6>
                <hr>
                <div class="row">
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="upline_id">ภายใต้
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="upline_id"
                                placeholder="Upline">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sponsor">ผู้แนะนำ
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="sponsor"
                                placeholder="Sponsor">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="side">สาย
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="side"
                                placeholder="Side">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Prefix">จองรหัส
                                <span class="text-danger">* </span></label>
                            <select class="form-control" id="number_of_member">
                                <option>ทั่วไป</option>
                                <option>จอง 3 รหัส</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Prefix">ประเทศ
                                <span class="text-danger">* </span></label>
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
                <h6 class="font-16 mb-3 mt-2"><u>ข้อมูลพื้นฐาน (GENERAL INFORMATION)</u></h6>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Prefix">คำนำหน้าชื่อ
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
                            <input type="text" class="form-control" id="firstname"
                                placeholder="ชื่อ">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="lastname">นามสุกล
                                <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="lastname"
                                placeholder="นามสุกล">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phone">หมายเลขโทรศัพท์
                                <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone"
                                placeholder="หมายเลขโทรศัพท์">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Email Address
                                <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email"
                                placeholder="email@example.com">
                        </div>
                    </div>
                </div>
                <h6 class="font-16 mb-3 mt-2"><b><u>ที่อยู่ตามบัตรประชาชน (ADDRESS)</u></b></h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="no">บ้านเลขที่
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="no"
                                placeholder="บ้านเลขที่">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="moo">หมู่ที่
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="moo"
                                placeholder="หมู่ที่">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homename">หมู่บ้าน/อาคาร
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="homename"
                                placeholder="หมู่บ้าน/อาคาร">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="soi">ตรอก/ซอย
                                <span class="text-danger"> </span></label>
                            <input type="text" class="form-control" id="soi"
                                placeholder="ตรอก/ซอย">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="road">ถนน
                                <span class="text-danger"> </span></label>
                            <input type="text" class="form-control" id="road"
                                placeholder="ถนน">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tambon">แขวง/ตำบล
                                <span class="text-danger">*</span></label>
                            <select class="form-control" id="tambon">
                                <option>แขวง/ตำบล</option>
                                <option> </option>
                                <option> </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amphur">เขต/อำเภอ
                                <span class="text-danger">*</span></label>
                            <select class="form-control" id="amphur">
                                <option>เขต/อำเภอ</option>
                                <option> </option>
                                <option> </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="changwat">จังหวัด
                                <span class="text-danger">*</span></label>
                            <select class="form-control" id="changwat">
                                <option>จังหวัด</option>
                                <option> </option>
                                <option> </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="zipcode">รหัสไปรษณีย์
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="zipcode"
                                placeholder="รหัสไปรษณีย์">
                        </div>
                    </div>
                </div>
                <h6 class="font-16 mb-3 mt-2"><u><b>ที่อยู่สำหรับการติดต่อและจัดส่งผลิตภัณฑ์
                        (DELIVERY ADDRESS)</b></u>
                </h6>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-12 col-form-label">
                                <div class="checkbox-inline">
                                    <label class="checkbox checkbox-success ">
                                        <input type="checkbox" class="p-2"
                                            name="copy_card_address">
                                        <span class="ml-2">
                                            ที่อยู่ตามบัตรประชาชน</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="no1">บ้านเลขที่
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="no1"
                                placeholder="บ้านเลขที่">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="moo1">หมู่ที่
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="moo1"
                                placeholder="หมู่ที่">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="homename1">หมู่บ้าน/อาคาร
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="homename1"
                                placeholder="หมู่บ้าน/อาคาร">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="soi1">ตรอก/ซอย
                                <span class="text-danger"> </span></label>
                            <input type="text" class="form-control" id="soi1"
                                placeholder="ตรอก/ซอย">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="road1">ถนน
                                <span class="text-danger"> </span></label>
                            <input type="text" class="form-control" id="road1"
                                placeholder="ถนน">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tambon1">แขวง/ตำบล
                                <span class="text-danger">*</span></label>
                            <select class="form-control" id="tambon1">
                                <option>แขวง/ตำบล</option>
                                <option> </option>
                                <option> </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amphur1">เขต/อำเภอ
                                <span class="text-danger">*</span></label>
                            <select class="form-control" id="amphur1">
                                <option>เขต/อำเภอ</option>
                                <option> </option>
                                <option> </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="changwat1">จังหวัด
                                <span class="text-danger">*</span></label>
                            <select class="form-control" id="changwat1">
                                <option>จังหวัด</option>
                                <option> </option>
                                <option> </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="zipcode1">รหัสไปรษณีย์
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="zipcode1"
                                placeholder="รหัสไปรษณีย์">
                        </div>
                    </div>
                </div>
                <h6 class="font-16 mb-4 mt-2"><u><b>ข้อมูลบัญชี (ACCOUNT DATA)</b></u></h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="accname">ชื่อบัญชี
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="accname"
                                placeholder="ชื่อบัญชี">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="accno">เลขที่บัญชี
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="accno"
                                placeholder="เลขที่บัญชี">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="bank">ธนาคาร
                                    <span class="text-danger">*</span></label>
                                <select class="form-control" id="bank">
                                    <option>ธนาคารกรุงเทพ</option>
                                    <option>ธนาคารกสิกรไทย</option>
                                    <option>ธนาคารกรุงไทย</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bankbranch">สาขา
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="bankbranch"
                                placeholder="สาขา">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-form-label">
                            <label for="banktype">ประเภทบัญชี
                                <span class="text-danger">* </span></label>
                            <div class="radio-inline">
                                <label class="radio radio-success">
                                    <input type="radio" name="radios5">
                                    <span></span>กระแสรายวัน</label>
                                <label class="radio radio-success">
                                    <input type="radio" name="radios5" checked="checked">
                                    <span></span>ออมทรัพย์</label>
                            </div>
                        </div>
                    </div>
                </div>
                <h6 class="font-16 mb-4 mt-2"><u><b>ผู้สืบทอดผลประโยชน์</b></u></h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="benefitname">ชื่อ-นามสกุล ผู้รับผลประโยชน์
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="benefitname"
                                placeholder="ชื่อ-นามสกุล ผู้รับผลประโยชน์">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reletionship">ความสัมพันธ์
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="reletionship"
                                placeholder="ความสัมพันธ์">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id1">หมายเลขบัตรประชาชน
                                <span class="text-danger">* </span></label>
                            <input type="text" class="form-control" id="id1"
                                placeholder="หมายเลขบัตรประชาชน">
                        </div>
                    </div>
                </div>
                <h6 class="font-16 mb-4 mt-2"><u><b>เอกสารสำหรับการสมัคร</b></u></h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="widget-header">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <label for="idcard_image">อัพโหลดภาพถ่ายบัตรประชาชน
                                    <span class="text-danger">* </span></label>
                            </div>
                        </div>
                        <div class="upload text-center img-thumbnail">
                            <input type="file" id="idcard_image" class="dropify"
                                data-default-file="{{ asset('frontend/assets/img/idcard.png') }}"
                                data-max-file-size="2M" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="widget-header">

                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <label for="user_idcard_image">อัพโหลดภาพหน้าตรงพร้อมบัตรประชาชน
                                    <span class="text-danger">* </span></label>
                            </div>

                        </div>
                        <div class="upload text-center img-thumbnail">
                            <input type="file" id="user_idcard_image" class="dropify"
                                data-default-file="{{ asset('frontend/assets/img/user_card.jpg') }}"
                                data-max-file-size="2M" />
                            {{-- <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i>
                                อัปโหลดรูปภาพ</p> --}}
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="widget-header">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <label for="user_image">อัพโหลดภาพถ่ายหน้าตรง
                                    <span class="text-danger">* </span></label>
                            </div>
                        </div>
                        <div class="upload text-center img-thumbnail">
                            <input type="file" id="user_image" class="dropify"
                                data-default-file="{{ asset('frontend/assets/img/user.png') }}"
                                data-max-file-size="2M" />
                            {{-- <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i>
                                อัปโหลดรูปภาพ</p> --}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="widget-header">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <label for="bookbank_image">อัพโหลดภาพถ่ายหน้าบัญชีธนาคาร
                                    <span class="text-danger">* </span></label>
                            </div>
                        </div>
                        <div class="upload text-center img-thumbnail">
                            <input type="file" id="bookbank_image" class="dropify"
                                data-default-file="{{ asset('frontend/assets/img/BookBank.png') }}"
                                data-max-file-size="2M" />
                            {{-- <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i>
                                อัปโหลดรูปภาพ</p> --}}
                        </div>
                    </div>
                </div>
                <div class="info-area col-md-12 text-center mt-4">
                    <button type="submit" class="btn btn-info btn-rounded">
                        <i class="las la-save"></i> ยืนยันการแก้ไข</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/forms/custom-select2.js') }}"></script>
@endsection
