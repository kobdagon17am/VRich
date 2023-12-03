@extends('layouts.backend.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/table/datatable/dt-global_style.css') }}">
    <link href="{{ asset('backend/assets/css/ui-elements/pagination.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/select2/select2.min.css') }}">
    <link href="{{ asset('backend/assets/css/forms/form-widgets.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/forms/multiple-step.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/dropify/dropify.min.css') }}">
    <link href="{{ asset('backend/assets/css/pages/profile_edit.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-header')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">ระบบสินค้า</li>
            <li class="breadcrumb-item active" aria-current="page"><span>สินค้า</span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="widget-content widget-content-area br-6">
        <div class="row">


            {{-- <div class="col-md-2">
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-12 col-sm-12"><b>รหัสสินค้า</b></label>
                    <input type="text" class="form-control float-left text-center w130 myLike product_code "
                        placeholder="รหัสสินค้า">
                </div>
            </div> --}}

            <div class="col-md-12 text-right">
                <div class="input-group-prepend">
                    <button class="btn btn-success btn-rounded " data-toggle="modal" data-target="#add" type="button"><i
                            class="las la-plus-circle font-20"></i>
                        เพิ่มสินค้า</button>
                </div>
            </div>
            <div class="modal fade bd-example-modal-xl" id="add" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header ml-4">
                            <h5 class="modal-title" id="myLargeModalLabel"><b>เพิ่มสินค้า</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="las la-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="modal-text">
                            <div class="widget-content widget-content-area">
                                <div class="form-group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card multiple-form-one px-0 pb-0 mb-3">

                                            <div class="row">
                                                <div class="col-md-12 mx-0">
                                                    <form method="POST" action="{{ route('admin/Products_insert') }}"
                                                        enctype="multipart/form-data" id="msform">
                                                        @csrf
                                                        <ul id="progressbar">
                                                            <li class="active" id="account" style="width: 50%;">
                                                                <strong>ข้อมูลสินค้า</strong>
                                                            </li>
                                                            <li id="payment" style="width: 50%;">
                                                                <strong>อัพโหลดรูปภาพ</strong>
                                                            </li>
                                                            {{-- <li id="confirm" style="width: 33.33%;">
                                                                <strong>เพิ่มสินค้าสำเร็จ</strong>
                                                            </li> --}}
                                                        </ul>

                                                        <fieldset>
                                                            <div class="form-card">
                                                                <h6 class="fs-title mb-4"><u>รายละเอียดสินค้า</u></h6>
                                                                <div class="w-100">
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-6  mt-2">
                                                                            <input type="hidden" name="id">
                                                                            <label><b>รหัสสินค้า:</b></label>
                                                                            <input type="text" class="form-control"
                                                                                name="product_code"
                                                                                placeholder="รหัสสินค้า">
                                                                        </div>
                                                                        <div class="col-lg-6  mt-2">
                                                                            <label><b>ชื่อสินค้าสินค้า:</b></label>
                                                                            <input type="text" class="form-control"
                                                                                name="product_name"
                                                                                placeholder="ชื่อสินค้าสินค้า">
                                                                        </div>
                                                                        <div class="col-lg-6 mt-2">
                                                                            <label><b>หมวดสินค้า:</b></label>
                                                                            <select class="form-control"
                                                                                name="product_category_name">
                                                                                @foreach ($get_categories as $item)
                                                                                    <option value="{{ $item->id }}">
                                                                                        {{ $item->category_en_name }}</option>
                                                                                @endforeach

                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-6  mt-2">
                                                                            <label><b>หน่วยสินค้า:</b></label>
                                                                            <select class="form-control"
                                                                                name="product_unit_name">
                                                                                @foreach ($get_unit as $item)
                                                                                    <option value="{{ $item->id }}">
                                                                                        {{ $item->product_unit_th }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-6 mt-2">
                                                                            <label><b>ประเภทสินค้า:</b></label>
                                                                            <select class="form-control"
                                                                                name="product_vat">
                                                                                <option value="vat">VAT
                                                                                </option>
                                                                                <option value="no vat">NO VAT
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b>ราคาต้นทุน (Bat):</b></label>
                                                                            <input type="number" step="any"
                                                                                class="form-control" name="product_cost_th"
                                                                                placeholder="ราคาต้นทุน (บาท)">
                                                                        </div>

                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b>ราคาต้นทุน (USD):</b></label>
                                                                            <input type="number" step="any"
                                                                                class="form-control" name="product_cost_usd"
                                                                                placeholder="ราคาต้นทุน (USD)">
                                                                        </div>


                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b>ราคาขายปลีก (Bat):</b></label>
                                                                            <input type="number" class="form-control"
                                                                                name="product_price_retail_th"
                                                                                placeholder="ราคาขายปลีก (บาท)">
                                                                        </div>

                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b>ราคาขายปลีก (USD):</b></label>
                                                                            <input type="number" class="form-control"
                                                                                name="product_price_retail_usd"
                                                                                placeholder="รราคาขายปลีก (USD)">
                                                                        </div>


                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b>ราคาขายสมาชิก (Bat):</b></label>
                                                                            <input type="number" step="any"
                                                                                class="form-control"
                                                                                name="product_price_member_th"
                                                                                placeholder="ราคาขายสมาชิก">
                                                                        </div>

                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b>ราคาขายสมาชิก (USD):</b></label>
                                                                            <input type="number" step="any"
                                                                                class="form-control"
                                                                                name="product_price_member_usd"
                                                                                placeholder="ราคาขายสมาชิก">
                                                                        </div>


                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b> Shipping-Price TH</b></label>
                                                                            <input type="number" class="form-control"
                                                                                name="shipping_th"
                                                                                placeholder=" Shipping-Price TH" >
                                                                        </div>

                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b> Shipping-Price USD</b></label>
                                                                            <input type="number" class="form-control"
                                                                                name="shipping_usd"
                                                                                placeholder="Shipping-Price USD" >
                                                                        </div>



                                                                        <div class="col-lg-6  mt-2">
                                                                            <label><b>คะแนน PT:</b></label>
                                                                            <input type="number" class="form-control"
                                                                                name="product_pv" placeholder="คะแนน PT">
                                                                        </div>


                                                                        <div class="col-lg-6 mt-2">
                                                                            <label><b>ค่าขนส่ง:</b></label>
                                                                            <select class="form-control"
                                                                                name="status_shipping">
                                                                                <option value="Y">คิดค่าส่ง
                                                                                </option>
                                                                                <option value="N">ไม่คิดค่าส่ง
                                                                                </option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-lg-6 mt-2">
                                                                            <label><b>สถานะสินค้า:</b></label>
                                                                            <select class="form-control"
                                                                                name="product_status">
                                                                                <option value="1">เปิดใช้งาน
                                                                                </option>
                                                                                <option value="0">ปิดใช้งาน
                                                                                </option>
                                                                            </select>
                                                                        </div>

                                                                        {{-- <div class="col-lg-6 mt-2">
                                                                            <label><b>YOUTUBE Link 1:</b></label>
                                                                            <input type="text" class="form-control" name="product_url1" placeholder="ใส่ URL ของวิดีโอจาก YouTube">
                                                                        </div>
                                                                        <div class="col-lg-6 mt-2">
                                                                            <label><b>YOUTUBE Link 2:</b></label>
                                                                            <input type="text" class="form-control" name="product_url2" placeholder="ใส่ URL ของวิดีโอจาก YouTube">
                                                                        </div> --}}
                                                                        <div class="col-lg-12  mt-2">
                                                                            <label><b>รายละเอียดสินค้า:</b></label>
                                                                            <textarea class="form-control" name="product_detail" placeholder="รายละเอียดสินค้า"></textarea>
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="button" name="next"
                                                                class="next action-button btn btn-info btn-rounded"
                                                                value="ถัดไป">
                                                        </fieldset>
                                                        <fieldset>
                                                            <div class="form-card">
                                                                <h6 class="fs-title mb-4"><u>รูปภาพสินค้า</u> (ขนาดภาพ
                                                                    500*500px)</h6>
                                                                <div class="w-100">
                                                                    <div class="row">
                                                                        <div class="col-lg-6  mt-2">

                                                                            <label for="product_image1">รูปภาพที่ 1
                                                                                <b
                                                                                    class="text-danger">(ภาพหลัก)</b></label>
                                                                            <div class="upload text-center img-thumbnail">
                                                                                <input type="file"
                                                                                    name="product_image1" class="dropify">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6  mt-2">
                                                                            <label for="product_image2">รูปภาพที่
                                                                                2</label>
                                                                            <div class="upload text-center img-thumbnail">
                                                                                <input type="file"
                                                                                    name="product_image2" class="dropify">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6  mt-2">
                                                                            <label for="product_image3">รูปภาพที่
                                                                                3</label>
                                                                            <div class="upload text-center img-thumbnail">
                                                                                <input type="file"
                                                                                    name="product_image3" class="dropify">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6  mt-2">
                                                                            <label for="product_image4">รูปภาพที่
                                                                                4</label>
                                                                            <div class="upload text-center img-thumbnail">
                                                                                <input type="file"
                                                                                    name="product_image4" class="dropify">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="button" name="previous"
                                                                class="previous action-button-previous btn btn-info btn-rounded"
                                                                value="ย้อนกลับ">
                                                            <button type="submit" class="btn btn-info btn-rounded">
                                                                <i class="las la-save"></i> เพิ่มสินค้า</button>
                                                        </fieldset>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal fade bd-example-modal-lg" id="edit" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header ml-4">
                            <h5 class="modal-title" id="myLargeModalLabel"><b>แก้ไขสินค้า</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="las la-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="modal-text">
                            <div class="widget-content widget-content-area">
                                <div class="form-group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card multiple-form-one px-0 pb-0 mb-3">

                                            <div class="row">
                                                <div class="col-md-12 mx-0">
                                                    <form method="POST" action="{{ route('admin/edit_products') }}"
                                                        enctype="multipart/form-data" id="msform">
                                                        @csrf
                                                        <ul id="progressbar">
                                                            <li class="active" id="account" style="width: 50%;">
                                                                <strong>ข้อมูลสินค้า</strong>
                                                            </li>
                                                            <li id="payment" style="width: 50%;">
                                                                <strong>อัพโหลดรูปภาพ</strong>
                                                            </li>
                                                            {{-- <li id="confirm" style="width: 33.33%;">
                                                            <strong>เพิ่มสินค้าสำเร็จ</strong>
                                                        </li> --}}
                                                        </ul>

                                                        <fieldset>
                                                            <div class="form-card">
                                                                <h6 class="fs-title mb-4"><u>รายละเอียดสินค้า</u></h6>
                                                                <div class="w-100">
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-6  mt-2">
                                                                            <input type="hidden" name="id"
                                                                                id="id">
                                                                            <label><b>รหัสสินค้า:</b></label>
                                                                            <input type="text" class="form-control"
                                                                                id="product_code" name="product_code"
                                                                                placeholder="รหัสสินค้า">
                                                                        </div>
                                                                        <div class="col-lg-6  mt-2">
                                                                            <label><b>ชื่อสินค้าสินค้า:</b></label>
                                                                            <input type="text" class="form-control"
                                                                                id="product_name" name="product_name"
                                                                                placeholder="ชื่อสินค้าสินค้า">
                                                                        </div>
                                                                        <div class="col-lg-6 mt-2">
                                                                            <label><b>หมวดสินค้า:</b></label>
                                                                            <select class="form-control"
                                                                                id="product_category_name"
                                                                                name="product_category_name">
                                                                                @foreach ($get_categories as $item)
                                                                                    <option value="{{ $item->id }}">
                                                                                        {{ $item->category_name }}</option>
                                                                                @endforeach

                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-6  mt-2">
                                                                            <label><b>หน่วยสินค้า:</b></label>
                                                                            <select class="form-control"
                                                                                id="product_unit_name"
                                                                                name="product_unit_name">
                                                                                @foreach ($get_unit as $item)
                                                                                    <option value="{{ $item->id }}">
                                                                                        {{ $item->product_unit_th }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-6 mt-2">
                                                                            <label><b>ประเภทสินค้า:</b></label>
                                                                            <select class="form-control" id="product_vat"
                                                                                name="product_vat">
                                                                                <option value="vat">VAT
                                                                                </option>
                                                                                <option value="no vat">NO VAT
                                                                                </option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b>ราคาต้นทุน (Bat):</b></label>
                                                                            <input type="number" step="any"
                                                                                class="form-control" id="product_cost_th" name="product_cost_th"
                                                                                placeholder="ราคาต้นทุน (บาท)">
                                                                        </div>

                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b>ราคาต้นทุน (USD):</b></label>
                                                                            <input type="number" step="any"
                                                                                class="form-control" id="product_cost_usd" name="product_cost_usd"
                                                                                placeholder="ราคาต้นทุน (USD)">
                                                                        </div>


                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b>ราคาขายปลีก (Bat):</b></label>
                                                                            <input type="number" class="form-control"
                                                                                name="product_price_retail_th" id="product_price_retail_th"
                                                                                placeholder="ราคาขายปลีก (บาท)">
                                                                        </div>

                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b>ราคาขายปลีก (USD):</b></label>
                                                                            <input type="number" class="form-control"
                                                                                name="product_price_retail_usd" id="product_price_retail_usd"
                                                                                placeholder="รราคาขายปลีก (USD)">
                                                                        </div>


                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b>ราคาขายสมาชิก (Bat):</b></label>
                                                                            <input type="number" step="any"
                                                                                class="form-control"
                                                                                name="product_price_member_th" id="product_price_member_th"
                                                                                placeholder="ราคาขายสมาชิก">
                                                                        </div>

                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b>ราคาขายสมาชิก (USD):</b></label>
                                                                            <input type="number" step="any"
                                                                                class="form-control"
                                                                                name="product_price_member_usd" id="product_price_member_usd"
                                                                                placeholder="ราคาขายสมาชิก">
                                                                        </div>


                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b> Shipping-Price TH</b></label>
                                                                            <input type="number"  step="any" class="form-control"
                                                                                id="shipping_th" name="shipping_th"
                                                                                placeholder=" Shipping-Price TH" >
                                                                        </div>

                                                                        <div class="col-lg-3  mt-2">
                                                                            <label><b> Shipping-Price USD</b></label>
                                                                            <input type="number" step="any" class="form-control"
                                                                                id="shipping_usd" name="shipping_usd"
                                                                                placeholder="Shipping-Price USD" >
                                                                        </div>



                                                                        <div class="col-lg-6  mt-2">
                                                                            <label><b>คะแนน PT:</b></label>
                                                                            <input type="number" class="form-control"
                                                                                id="product_pv" name="product_pv"
                                                                                placeholder="คะแนน PV">
                                                                        </div>
                                                                        <div class="col-lg-6 mt-2">
                                                                            <label><b>ค่าขนส่ง:</b></label>
                                                                            <select class="form-control"
                                                                                name="status_shipping" id="status_shipping">
                                                                                <option value="Y">คิดค่าส่ง
                                                                                </option>
                                                                                <option value="N">ไม่คิดค่าส่ง
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-6 mt-2">
                                                                            <label><b>สถานะสินค้า:</b></label>
                                                                            <select class="form-control"
                                                                                id="product_status" name="product_status">
                                                                                <option value="1">เปิดใช้งาน
                                                                                </option>
                                                                                <option value="0">ปิดใช้งาน
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        {{-- <div class="col-lg-6 mt-2">
                                                                            <label><b>YOUTUBE Link 1:</b></label>
                                                                            <input type="text" class="form-control" name="product_url1" id="product_url1" placeholder="ใส่ URL ของวิดีโอจาก YouTube">
                                                                        </div>
                                                                        <div class="col-lg-6 mt-2">
                                                                            <label><b>YOUTUBE Link 2:</b></label>
                                                                            <input type="text" class="form-control" name="product_url2" id="product_url2" placeholder="ใส่ URL ของวิดีโอจาก YouTube">
                                                                        </div> --}}
                                                                        <div class="col-lg-12  mt-2">
                                                                            <label><b>รายละเอียดสินค้า:</b></label>
                                                                            <textarea class="form-control" id="product_detail" name="product_detail" placeholder="รายละเอียดสินค้า"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="button" name="next"
                                                                class="next action-button btn btn-info btn-rounded"
                                                                value="ถัดไป">
                                                        </fieldset>
                                                        <fieldset>
                                                            <div class="form-card">
                                                                <h6 class="fs-title mb-4"><u>รูปภาพสินค้า</u> (ขนาดภาพ
                                                                    500*500px)</h6>
                                                                <div class="w-100">
                                                                    <div class="row">
                                                                        <div class="col-lg-6  mt-2">

                                                                            <label for="product_image1">รูปภาพที่ 1
                                                                                <b
                                                                                    class="text-danger">(ภาพหลัก)</b></label>
                                                                            <div class="upload text-center img-thumbnail">
                                                                                <input type="file" id="product_image1"
                                                                                    name="product_image1" class="dropify"
                                                                                    data-default-file="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6  mt-2">
                                                                            <label for="product_image2">รูปภาพที่
                                                                                2</label>
                                                                            <div class="upload text-center img-thumbnail">
                                                                                <input type="file" id="product_image2"
                                                                                    name="product_image2" class="dropify"
                                                                                    data-default-file="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6  mt-2">
                                                                            <label for="product_image3">รูปภาพที่
                                                                                3</label>
                                                                            <div class="upload text-center img-thumbnail">
                                                                                <input type="file" id="product_image3"
                                                                                    name="product_image3" class="dropify"
                                                                                    data-default-file="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6  mt-2">
                                                                            <label for="product_image4">รูปภาพที่
                                                                                4</label>
                                                                            <div class="upload text-center img-thumbnail">
                                                                                <input type="file" id="product_image4"
                                                                                    name="product_image4" class="dropify"
                                                                                    data-default-file="">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="button" name="previous"
                                                                class="previous action-button-previous btn btn-info btn-rounded"
                                                                value="ย้อนกลับ">
                                                            <button type="submit" class="btn btn-info btn-rounded">
                                                                <i class="las la-save"></i> แก้ไขข้อมูลสินค้า</button>
                                                        </fieldset>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="table-responsive mb-4">
            <table id="ordertable" class="table table-hover table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>รหัส</th>
                        <th>รูปภาพ</th>
                        <th>ชื่อสินค้า</th>
                        <th>หมวดสินค้า</th>
                        <th>หน่วย</th>
                        <th>ประเภทสินค้า</th>
                        <th>ราคาต้นทุน (TH/USD)</th>
                        <th>ราคาขายปลีก (TH/USD)</th>
                        <th>ราคาขายสมาชิก(TH/USD)</th>
                        <th>ค่าขนส่ง(TH/USD)</th>
                        <th>PT</th>
                        <th>สถานะ</th>
                        <th>Set CashBack</th>
                        <th>แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($get_products as $value)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $value->product_code }}</td>

                            <td> <img src="{{ asset($value->product_image_url . '' . $value->product_image_name) }}"
                                    alt="contact-img" title="contact-img" class="rounded-circle mr-3" height="60"
                                    width="60" style="object-fit: cover;"></td>
                            <td>{{ $value->product_name }}</td>
                            <td>{{ $value->product_category_name }}</td>
                            <td>{{ $value->product_unit_name }}</td>
                            <td>{{ $value->product_vat }}</td>
                            <td>{{ $value->product_cost_th }}฿/{{ $value->product_cost_usd }}$</td>
                            <td>{{ $value->product_price_retail_th }}฿/{{ $value->product_price_retail_usd }}$</td>
                            <td>{{ $value->product_price_member_th }}฿/{{ $value->product_price_member_usd }}$</td>
                            <td>{{ $value->shipping_th }}฿/{{ $value->shipping_usd }}$</td>
                            <td>{{ $value->product_pv }}</td>
                            <td>
                                @if ($value->status == '1')
                                    <span class="badge badge-pill badge-success light">เปิดใช้งาน</span>
                                @endif
                                @if ($value->status == '0')
                                    <span class="badge badge-pill badge-danger light">ปิดใช้งาน</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="#!" onclick="cash_back({{ $value->id }})" class="p-2">
                                    <i class="lab la-whmcs font-25 text-warning"></i></a>
                            </td>
                            <td>
                                <a href="#!" onclick="edit({{ $value->id }})" class="p-2">
                                    <i class="lab la-whmcs font-25 text-warning"></i></a>
                            </td>
                        </tr>
                    @endforeach
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

        <div class="modal fade" id="CashBack" tabindex="-1" role="dialog" aria-labelledby="CashBackTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="CashBackTitle">Set CashBack</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="modal-heading mb-4 mt-2" id="c_product_name"></h4>
                        <input type="hidden" id="product_name_cash" value="">

                            <diV class="form-group row">
                                <div class="col-md-3  mt-2">
                                    <label><b>UNIT (AMT):</b></label>
                                    <input type="number" class="form-control" name="amt" id="amt" placeholder="UNIT(AMT)">
                                </div>
                                <div class="col-md-3  mt-2">
                                    <label><b>PRICE/UNIT (THAI)</b></label>
                                    <input type="number" class="form-control" name="price_th" id="price_th" placeholder="PRICE/UNIT (THAI)">
                                </div>
                                <div class="col-md-3  mt-2">
                                    <label><b>PRICE/UNIT (USD)</b></label>
                                    <input type="number" class="form-control" name="price_usd" id="price_usd" placeholder="PRICE/UNIT (USD)">
                                </div>
                                <div class="col-md-3  mt-2">
                                    <label><b>PROFIT (THAI)</b></label>
                                    <input type="number" class="form-control" name="profit_th" id="profit_th" placeholder="PROFIT (THAI)">
                                </div>
                                <div class="col-md-3  mt-2">
                                    <label><b>PROFIT (USD)</b></label>
                                    <input type="number" class="form-control" name="profit_usd" id="profit_usd" placeholder="PROFIT (USD)">
                                </div>

                                <div class="col-md-3  mt-1">

                                        <div id="add_cashback"></div>

                                </div>
                            </diV>
                            <div class="table-responsive mb-4">
                           <div id="table_cashback"></div>
                        </div>
                    </div>
                    {{-- <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div> --}}
                </div>
            </div>
        </div>



    </div>
@endsection
@section('js')
    <script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/forms/custom-select2.js') }}"></script>
    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>
    <script src="{{ asset('backend/assets/js/forms/multiple-step.js') }}"></script>
    <script src="{{ asset('backend/plugins/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/profile_edit.js') }}"></script>
    <script>
        function edit(id) {
            $.ajax({
                    url: '{{ route('admin/view_products') }}',
                    type: 'GET',
                    data: {
                        id
                    }
                })
                .done(function(data) {
                    // console.log(data);
                    $("#edit").modal();
                    $("#id").val(data['data']['id']);
                    $("#product_code").val(data['data']['product_code']);
                    $("#product_name").val(data['data']['product_name']);
                    $("#product_category_name").val(data['data']['product_category_id_fk']);
                    $("#product_vat").val(data['data']['product_vat']);
                    $("#product_unit_name").val(data['data']['product_unit_id_fk']);
                    $("#product_cost_th").val(data['data']['product_cost_th']);
                    $("#product_cost_usd").val(data['data']['product_cost_usd']);
                    $("#product_price_retail_th").val(data['data']['product_price_retail_th']);
                    $("#product_price_retail_usd").val(data['data']['product_price_retail_usd']);
                    $("#product_price_member_th").val(data['data']['product_price_member_th']);
                    $("#product_price_member_usd").val(data['data']['product_price_member_usd']);
                    $("#shipping_th").val(data['data']['shipping_th']);
                    $("#shipping_usd").val(data['data']['shipping_usd']);

                    $("#product_pv").val(data['data']['product_pv']);
                    $("#product_status").val(data['data']['status']);
                    $("#product_detail").val(data['data']['product_detail']);

                    $("#status_shipping").val(data['data']['status_shipping']);




                    $.each(data['img'], function(index, value) {
                        if (value['product_image_orderby'] == 1) {

                            var img = '{{ asset('') }}' + value['product_image_url'] + value[
                                'product_image_name'];
                            $('#product_image1').attr('data-default-file', img).dropify();
                        }

                        if (value['product_image_orderby'] == 2) {
                            var img = '{{ asset('') }}' + value['product_image_url'] + value[
                                'product_image_name'];
                            $('#product_image2').attr('data-default-file', img).dropify();
                        }

                        if (value['product_image_orderby'] == 3) {
                            var img = '{{ asset('') }}' + value['product_image_url'] + value[
                                'product_image_name'];
                            $('#product_image3').attr('data-default-file', img).dropify();
                        }

                        if (value['product_image_orderby'] == 4) {
                            var img = '{{ asset('') }}' + value['product_image_url'] + value[
                                'product_image_name'];
                            $('#product_image4').attr('data-default-file', img).dropify();
                        }

                    });

                    //$('#product_image1').attr('data-default-file', 'เส้นทางไปยังรูปภาพใหม่');


                })
                .fail(function() {
                    console.log("error");
                })
        }

        function cash_back(id) {
            $.ajax({
                    url: '{{ route('admin/view_cashback') }}',
                    type: 'GET',
                    data: {
                        id
                    }
                })
                .done(function(data) {
                    $("#c_product_name").html(data['data']['product_name']);
                    $("#product_name_cash").val(data['data']['product_name']);
                    $("#table_cashback").html(data['html']);
                    var add_bt ='<button type="button" onclick="add_cashback('+id+');" class="btn btn-success mt-4">ADD</button>';
                    $("#add_cashback").html(add_bt);

                    $("#CashBack").modal();


                })
                .fail(function() {
                    console.log("error");
                })
        }
         function delete_cashback(dataset_casback_product_id_fk,product_id) {

            $.ajax({
                    url: '{{ route('admin/delete_cashback') }}',
                    type: 'GET',
                    data: {
                        dataset_casback_product_id_fk: dataset_casback_product_id_fk,
                        product_id:product_id,

                    }
                })
    .done(function(data) {
        if(data['status'] == 'success'){
            console.log(data['html']);
            $("#table_cashback").html(data['html']);

        }else{

                alert(data['ms']);
        }
        // $("#c_product_name").html(data['data']['product_name']);


        // var add_bt ='<button type="button" onclick="add_cashback('+id+');" class="btn btn-success mt-4">ADD</button>';
        // $("#add_cashback").html(add_bt);
        // $("#CashBack").modal();


    })
    .fail(function() {
        console.log("error");
    })
}
        function add_cashback(id) {

            var amt =  $("#amt").val();
            var product_name_cash =  $("#product_name_cash").val();
            var price_th =  $("#price_th").val();
            var price_usd =  $("#price_usd").val();
            var profit_th =  $("#profit_th").val();
            var profit_usd =  $("#profit_usd").val();
            if(amt == 0 || amt == null){
                alert('UNIT Is Null');
                return;

            }

            if(price_th == 0 || price_th == null){
                alert('price_th Is Null');
                return;

            }
            if(price_usd == 0 || price_usd == null){
                alert('price_usd Is Null');
                return;

            }
            if(profit_th == 0 || profit_th == null){
                alert('profit_th Is Null');
                return;

            }
            if(profit_usd == 0 || profit_usd == null){
                alert('profit_usd Is Null');
                return;

            }

            $.ajax({
                    url: '{{ route('admin/add_cashback') }}',
                    type: 'GET',
                    data: {
                        id: id,
                        product_name_cash:product_name_cash,
                        amt: amt,
                        price_th: price_th,
                        price_usd: price_usd,
                        profit_th: profit_th,
                        profit_usd: profit_usd,
                    }
                })
                .done(function(data) {
                    if(data['status'] == 'success'){
                            $("#table_cashback").html(data['html']);
                            // alert('Add Success');
                    }else{

                            alert(data['ms']);
                    }
                    // $("#c_product_name").html(data['data']['product_name']);


                    // var add_bt ='<button type="button" onclick="add_cashback('+id+');" class="btn btn-success mt-4">ADD</button>';
                    // $("#add_cashback").html(add_bt);
                    // $("#CashBack").modal();


                })
                .fail(function() {
                    console.log("error");
                })
        }
    </script>
@endsection
