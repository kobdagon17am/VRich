@extends('layouts.frontend.app')
@section('css')
    <link href='https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css' rel='stylesheet'>
@endsection

@section('conten')
    <div class="bg-whiteLight page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active text-truncate" aria-current="page">MY STOCK</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="card card-box borderR10 mb-2 mb-md-0">
                <div class="card-body">

                    <div class=" table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <tr>
                                    <th>Picture</th>
                                    <th>Product name</th>
                                    <th width="10">Quantity</th>
                                    <th>Transfer </th>
                                    <th>Delivery </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($stock as $value)
                                    <tr id="items">
                                        <td class="text-center">
                                            <img src="{{ asset($value->product_image_url . '' . $value->product_image_name) }}"
                                                class="img-fluid" width="70" alt="tbl"></a>
                                        </td>
                                        <td class="text-center">
                                            <h6> {{ $value->product_name }} </h6>

                                        </td>
                                        <td class="text-center">
                                            {{ $value->pack_amt }}
                                        </td>
                                        <td class="text-center">

                                            @if(Auth::guard('c_user')->user()->qualification_id >= 3)
                                                <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#transferstockModal_{{ $value->id }}"
                                                class="btn btn-p2 rounded-pill"> <i class="fa fa-retweet"></i></button>
                                            @endif

                                        </td>
                                        <td class="text-center">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#recivestockModal_{{ $value->id }}"
                                                class="btn btn-p2 rounded-pill"> <i class="fa fa-paper-plane"></i></button>
                                        </td>


                                    </tr>

                                    <div class="modal fade" id="transferstockModal_{{ $value->id }}" tabindex="-1"
                                        aria-labelledby="transferstockModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                            <form method="post" action="{{ route('stock_tranfer') }}" id=form_{{ $value->id }}">
                                                @csrf
                                                <div class="modal-content borderR25">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="transferstockModalLabel">Tranfers Stock
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{-- <div class="alert alert-warning d-flex align-items-center" role="alert">
                                                            <i class='bx bxs-info-circle me-2'></i>
                                                            <div>
                                                                การโอนเงิน eWallet ขั้นต่ำ = 300 บาท
                                                            </div>
                                                        </div> --}}
                                                        <div class="row gx-2">
                                                            <div class="col-sm-6">
                                                                <div class="alert alert-white p-2 h-82 borderR10">
                                                                    <div class="d-flex">
                                                                        <div class="flex-shrink-0">

                                                                            @if (Auth::guard('c_user')->user()->profile_img)
                                                                                <img src="{{ asset('local/public/profile_customer/' . Auth::guard('c_user')->user()->profile_img) }}" width="30px" alt="" />
                                                                            @else
                                                                                <img src="{{ asset('frontend/images/man.png') }}"  width="30px" alt="" />
                                                                            @endif

                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2">
                                                                            <p class="small mb-0">
                                                                                {{ Auth::guard('c_user')->user()->user_name }}
                                                                            </p>
                                                                            <h6> {{ Auth::guard('c_user')->user()->name }}
                                                                                {{ Auth::guard('c_user')->user()->last_name }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="alert alert-purple p-2 h-82 borderR10">
                                                                    <p class="small" id="product_name">
                                                                        {{ $value->product_name }} </p>
                                                                    <p class="text-end mb-0"><span
                                                                            class="h5 text-purple1 bg-opacity-100">
                                                                            {{ $value->pack_amt }} </span><b
                                                                            id="unit">Qty</b>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="card p-2 borderR10 mb-3">
                                                                    <h5 class="text-center">Transfers Stock </h5>
                                                                    <input type="hidden" name="stock_id"
                                                                        value="{{ $value->id }}">
                                                                    <div class="row gx-3">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for=""
                                                                                class="form-label">UserName <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="username_receive"
                                                                                class="form-control username_receive"
                                                                                required>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for=""
                                                                                class="form-label">Name</label>
                                                                            <input type="text" readonly
                                                                                name="name_receive"
                                                                                class="form-control name_receive">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row gx-3 mb-3">
                                                                        <label for=""
                                                                            class="col-sm-3 col-form-label">Transfer amount
                                                                            <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-9">
                                                                            <select class="form-select" name="amt"
                                                                                aria-label="Default select example">
                                                                                <option value="100">100</option>
                                                                                <option value="200">200</option>
                                                                                <option value="300">300</option>
                                                                                <option value="400">400</option>
                                                                                <option value="500">500</option>
                                                                                <option value="600">600</option>
                                                                                <option value="700">700</option>
                                                                                <option value="800">800</option>
                                                                                <option value="900">900</option>
                                                                                <option value="1000">1,000</option>
                                                                                <option value="1500">1,500</option>
                                                                                <option value="2000">2,000</option>
                                                                            </select>

                                                                            {{-- <p class="small text-muted mb-0">**ไม่สามารถโอนได้มากกว่ายอดเงินคงเหลือที่มีอยู่
                                                                            </p> --}}
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="alert alert-danger d-flex" role="alert">
                                                            <i class='bx bxs-error me-2 bx-sm'></i>
                                                            <div>
                                                                คำเตือน ! บริษัทไม่สามารถแก้ไขหากโอน <u>ผิดพลาด</u> กรุณาตรวจสอบความถูกต้องก่อนทำการโอน
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                    <div class="modal-footer justify-content-between border-0">
                                                        <button type="button" class="btn btn-outline-dark rounded-pill"
                                                            data-bs-dismiss="modal">Cancel</button>

                                                            <button type="submit" class="btn btn-p1 rounded-pill d-flex align-items-center confirm" onclick="return confirm('Confirm the transaction ?')">
                                                                <i class='bx bxs-check-circle me-2'></i>Confirm
                                                              </button>

                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <div class="modal fade" id="recivestockModal_{{ $value->id }}" tabindex="-1"
                                        aria-labelledby="recivestockModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                                            <form method="post" action="{{ route('stock_delivery') }}">
                                                @csrf
                                                <div class="modal-content borderR25">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="recivestockModalLabel">Delivery
                                                            Product
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{-- <div class="alert alert-warning d-flex align-items-center" role="alert">
                                                            <i class='bx bxs-info-circle me-2'></i>
                                                            <div>
                                                                การโอนเงิน eWallet ขั้นต่ำ = 300 บาท
                                                            </div>
                                                        </div> --}}
                                                        <div class="row gx-2">
                                                            <div class="col-sm-6">
                                                                <div class="alert alert-white p-2 h-82 borderR10">
                                                                    <div class="d-flex">
                                                                        <div class="flex-shrink-0">

                                                                            @if (Auth::guard('c_user')->user()->profile_img)
                                                                                <img src="{{ asset('local/public/profile_customer/' . Auth::guard('c_user')->user()->profile_img) }}"
                                                                                    width="30px" alt="" />
                                                                            @else
                                                                                <img src="{{ asset('frontend/images/man.png') }}"
                                                                                    width="30px" alt="" />
                                                                            @endif

                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2">
                                                                            <p class="small mb-0">
                                                                                {{ Auth::guard('c_user')->user()->user_name }}
                                                                            </p>
                                                                            <h6> {{ Auth::guard('c_user')->user()->name }}
                                                                                {{ Auth::guard('c_user')->user()->last_name }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="alert alert-purple p-2 h-82 borderR10">
                                                                    <p class="small" id="product_name">
                                                                        {{ $value->product_name }} </p>
                                                                    <p class="text-end mb-0"><span
                                                                            class="h5 text-purple1 bg-opacity-100">
                                                                            {{ $value->pack_amt }} </span><b
                                                                            id="unit">Qty</b>
                                                                    </p>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="card p-2 borderR10 mb-3">
                                                                    <h5 class="text-center">Delivery Stock </h5>
                                                                    <input type="hidden" name="stock_id"
                                                                        value="{{ $value->id }}">

                                                                    <div class="row gx-3 mb-3">

                                                                        <div class="col-md-4 col-xl-4">
                                                                            <label for=""
                                                                                class="form-label">Transfer amount <span
                                                                                    class="text-danger same_address_err _err">*</span></label>
                                                                            <select class="form-select" name="amt"
                                                                                aria-label="Default select example">
                                                                                <option value="100">100</option>
                                                                                <option value="200">200</option>
                                                                                <option value="300">300</option>
                                                                                <option value="400">400</option>
                                                                                <option value="500">500</option>
                                                                                <option value="600">600</option>
                                                                                <option value="700">700</option>
                                                                                <option value="800">800</option>
                                                                                <option value="900">900</option>
                                                                                <option value="1000">1,000</option>
                                                                                <option value="1500">1,500</option>
                                                                                <option value="2000">2,000</option>
                                                                            </select>
                                                                        </div>


                                                                    </div>


                                                                    <div class="row">
                                                                        <div class="row g-3">
                                                                            <div class="col-md-12 col-xl-12 mb-3">
                                                                                <div class="form-check form-check-inline">
                                                                                    <input
                                                                                        class="form-check-input radio sent_address_check"
                                                                                        type="radio"
                                                                                        onchange="sent_address('sent_address')"
                                                                                        name="receive"
                                                                                        value="sent_address"
                                                                                        checked="checked">
                                                                                    <label class="form-check-label"
                                                                                        for="option1R">Delivery</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input
                                                                                        class="form-check-input radio sent_other"
                                                                                        type="radio"
                                                                                        onchange="sent_address('sent_other')"
                                                                                        name="receive"
                                                                                        value="sent_address_other">
                                                                                    <label class="form-check-label"
                                                                                        for="option2R">Others</label>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        @if (@$address->province_id)
                                                                            <div class="i_sent_address">
                                                                                <div class="row g-3">
                                                                                    <div class="col-md-4 col-xl-4">
                                                                                        <label for=""
                                                                                            class="form-label">First Name
                                                                                            <span
                                                                                                class="text-danger same_address_err _err">*</span></label>
                                                                                        <input type="text"
                                                                                            name="name"
                                                                                            class="form-control "
                                                                                            id=""
                                                                                            value="{{ $customer->prefix_name }} {{ $customer->name }} {{ $customer->last_name }}"
                                                                                            required>
                                                                                    </div>

                                                                                    <div class="col-md-4 col-xl-4">
                                                                                        <label for=""
                                                                                            class="form-label">Phone <span
                                                                                                class="text-danger phone_err _err">*</span></label>
                                                                                        <input name="phone"
                                                                                            type="number"
                                                                                            class="form-control"
                                                                                            name="phone"
                                                                                            value="{{ @$address->phone }}">
                                                                                    </div>

                                                                                    <div class="col-md-4 col-xl-4">
                                                                                    </div>

                                                                                    <div class="col-md-3 col-xl-3">
                                                                                        <label for=""
                                                                                            class="form-label">Address<span
                                                                                                class="text-danger same_address_err _err">*</span></label>
                                                                                        <input type="text"
                                                                                            name="house_no"
                                                                                            class="form-control"
                                                                                            value="{{ @$address->address }}"
                                                                                            readonly="">
                                                                                    </div>
                                                                                    <div class="col-md-2 col-xl-2">
                                                                                        <label for=""
                                                                                            class="form-label">Village No <span
                                                                                                class="text-danger same_moo_err _err">*</span></label>
                                                                                        <input type="text"
                                                                                            name="moo"
                                                                                            class="form-control"
                                                                                            value="{{ @$address->moo }}"
                                                                                            readonly="">
                                                                                    </div>
                                                                                    <div class="col-md-3 col-xl-3">
                                                                                        <label for=""
                                                                                            class="form-label">Lane<span
                                                                                                class="text-danger same_soi_err _err">*</span></label>
                                                                                        <input type="text"
                                                                                            name="soi"
                                                                                            value="{{ @$address->soi }}"
                                                                                            class="form-control"
                                                                                            readonly="">
                                                                                    </div>
                                                                                    <div class="col-md-4 col-xl-4">
                                                                                        <label for=""
                                                                                            class="form-label">Street <span
                                                                                                class="text-danger same_road_err _err">*</span></label>
                                                                                        <input type="text"
                                                                                            name="road"
                                                                                            class="form-control"
                                                                                            value="{{ @$address->road }}"
                                                                                            readonly="">
                                                                                    </div>
                                                                                    <div class="col-md-6 col-xl-4">
                                                                                        <label for="province"
                                                                                            class="form-label">Province</label>
                                                                                        <label
                                                                                            class="form-label text-danger same_province_err _err"></label>


                                                                                        <input name="province_id"
                                                                                            type="hidden"
                                                                                            class="form-control"
                                                                                            value="{{ @$address->province_id }}">
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            value="{{ @$address->province_name }}"
                                                                                            readonly="">


                                                                                    </div>
                                                                                    <div class="col-md-6 col-xl-4">

                                                                                        <label for="district"
                                                                                            class="form-label">District</label>
                                                                                        <label
                                                                                            class="form-label text-danger same_district_err _err"></label>


                                                                                        <input name="district_id"
                                                                                            type="hidden"
                                                                                            class="form-control"
                                                                                            value="{{ @$address->district_id }}" >
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            value="{{ @$address->district_name }}"
                                                                                            readonly="">
                                                                                    </div>
                                                                                    <div class="col-md-6 col-xl-4">
                                                                                        <label for="tambon"
                                                                                            class="form-label">Subdistrict</label>
                                                                                        <label
                                                                                            class="form-label text-danger same_tambon_err _err"></label>

                                                                                        <input name="tambon_id"
                                                                                            type="hidden"
                                                                                            class="form-control"
                                                                                            value="{{ @$address->tambon_id }}">
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            value="{{ @$address->tambon_name }}"
                                                                                            readonly="">
                                                                                    </div>
                                                                                    <div class="col-md-6 col-xl-4">
                                                                                        <label for=""
                                                                                            class="form-label">Zipcode
                                                                                            <span
                                                                                                class="text-danger same_zipcode_err _err ">*</span></label>
                                                                                        <input name="zipcode"
                                                                                            type="text"
                                                                                            class="form-control"
                                                                                            value="{{ @$address->zipcode }}"
                                                                                            readonly>
                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                        @else
                                                                            <div class="i_sent_address">

                                                                                <div
                                                                                    class="alert alert-warning icons-alert">

                                                                                    <p><strong>Warning!</strong> <code>There
                                                                                            is no shipping address,
                                                                                            Please setting before
                                                                                            paying.</code> <a
                                                                                            href="{{ route('editprofile') }}"
                                                                                            class="pcoded-badge label label-warning ">Setting
                                                                                            CLICK!!</a></p>
                                                                                </div>

                                                                            </div>
                                                                        @endif
                                                                        <div class="i_sent_other" style="display: none;">


                                                                            <div class="row g-3">
                                                                                <div class="col-md-4 col-xl-4">
                                                                                    <label for=""
                                                                                        class="form-label">First Name <span
                                                                                            class="text-danger same_address_err _err">*</span></label>
                                                                                    <input type="text" name="sam_name"
                                                                                        class="form-control "
                                                                                        id="">
                                                                                </div>


                                                                                <div class="col-md-6 col-xl-4 mb-3">
                                                                                    <label for=""
                                                                                        class="form-label">Phone </label>
                                                                                    <input type="number"
                                                                                        name="same_phone"
                                                                                        class="form-control address_same_card"
                                                                                        id="">
                                                                                </div>
                                                                                <div class="col-md-6 col-xl-5">
                                                                                    <label for=""
                                                                                        class="form-label">Address <span
                                                                                            class="text-danger same_address_err _err">*</span></label>
                                                                                    <input type="text"
                                                                                        name="same_address"
                                                                                        class="form-control address_same_card"
                                                                                        id="">
                                                                                </div>
                                                                                <div class="col-md-6 col-xl-3">
                                                                                    <label for=""
                                                                                        class="form-label">Village No <span
                                                                                            class="text-danger same_moo_err _err">*</span></label>
                                                                                    <input type="text" name="same_moo"
                                                                                        class="form-control address_same_card"
                                                                                        id="">
                                                                                </div>
                                                                                <div class="col-md-6 col-xl-4">
                                                                                    <label for=""
                                                                                        class="form-label">Lane<span
                                                                                            class="text-danger same_soi_err _err">*</span></label>
                                                                                    <input type="text" name="same_soi"
                                                                                        class="form-control address_same_card"
                                                                                        id="">
                                                                                </div>
                                                                                <div class="col-md-6 col-xl-4">
                                                                                    <label for=""
                                                                                        class="form-label">Street <span
                                                                                            class="text-danger same_road_err _err">*</span></label>
                                                                                    <input type="text" name="same_road"
                                                                                        class="form-control address_same_card"
                                                                                        id="">
                                                                                </div>
                                                                                <div class="col-md-6 col-xl-4">
                                                                                    <label for="province"
                                                                                        class="form-label">Province</label>
                                                                                    <label
                                                                                        class="form-label text-danger same_province_err _err"></label>
                                                                                    <select
                                                                                        class="form-select address_same_card select_same same_province"
                                                                                        name="same_province">
                                                                                        <option value="">--please
                                                                                            select--</option>
                                                                                        @foreach ($province as $item)
                                                                                            <option
                                                                                                value="{{ $item->id }}">
                                                                                                {{ $item->name_en }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>


                                                                                </div>
                                                                                <div class="col-md-6 col-xl-4">

                                                                                    <label for="district"
                                                                                        class="form-label">District</label>
                                                                                    <label
                                                                                        class="form-label text-danger same_district_err _err"></label>
                                                                                    <select
                                                                                        class="form-select address_same_card select_same same_district"
                                                                                        name="same_district" disabled
                                                                                        readonly>
                                                                                        <option value="">--please
                                                                                            select--</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6 col-xl-4">
                                                                                    <label for="tambon"
                                                                                        class="form-label">Subdistrict</label>
                                                                                    <label
                                                                                        class="form-label text-danger same_tambon_err _err"></label>
                                                                                    <select
                                                                                        class="form-select address_same_card select_same same_tambon"
                                                                                        name="same_tambon" disabled
                                                                                        readonly>
                                                                                        <option value="">--please
                                                                                            select--</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6 col-xl-4">
                                                                                    <label for=""
                                                                                        class="form-label">Zipcode <span
                                                                                            class="text-danger same_zipcode_err _err ">*</span></label>
                                                                                    <input name="same_zipcode"
                                                                                        type="number"
                                                                                        class="form-control address_same_card same_zipcode">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="alert alert-danger d-flex" role="alert">
                                                            <i class='bx bxs-error me-2 bx-sm'></i>
                                                            <div>
                                                                คำเตือน ! บริษัทไม่สามารถแก้ไขหากโอน <u>ผิดพลาด</u> กรุณาตรวจสอบความถูกต้องก่อนทำการโอน
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                    <div class="modal-footer justify-content-between border-0">
                                                        <button type="button" class="btn btn-outline-dark rounded-pill"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit"
                                                            class="btn btn-p1 rounded-pill d-flex align-items-center confirm" onclick="return confirm('Confirm the transaction ?')" ><i
                                                                class='bx bxs-check-circle me-2'></i>Confirm</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Modal -->
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $('.page-content').css({
            'min-height': $(window).height() - $('.navbar').height()
        });
    </script>


    <script>
        $('.username_receive').change(function() {
            user_name = '{{ Auth::guard('c_user')->user()->user_name }}';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            id = $(this).val();
            $.ajax({
                type: "post",
                url: '{{ route('checkcustomer') }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(data) {

                    if (data == "fail") {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred.',
                            text: 'Member ID is incorrect.!',
                        })
                        $('.username_receive').val(" ")
                        $('.name_receive').val(" ")
                    } else if (user_name == data.user_name) {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred.',
                            text: 'Unable to make transactions for myself',
                        })
                        $('.username_receive').val(" ")
                        $('.name_receive').val(" ")
                    } else {
                        $('.name_receive').val(data['name'])

                    }
                }
            });
        });
    </script>

    <script>
        // BEGIN province
        $(".same_province").change(function() {
            let province_id = $(this).val();
            $.ajax({
                url: '{{ route('getDistrict') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    province_id: province_id,
                },
                success: function(data) {
                    $(".same_district").children().remove();
                    $(".same_tambon").children().remove();
                    $(".same_district").append(` <option value="">--please select--</option>`);
                    $(".same_tambon").append(` <option value="">--please select--</option>`);
                    $(".same_zipcode").val("");
                    data.forEach((item) => {
                        $(".same_district").append(
                            `<option value="${item.id}">${item.name_en}</option>`
                        );
                    });
                    $(".same_district").attr('disabled', false);
                    $(".same_tambon").attr('disabled', true);

                },
                error: function() {}
            })
        });
        // END province

        // BEGIN district
        $(".same_district").change(function() {

            let district_id = $(this).val();
            $.ajax({
                url: '{{ route('getTambon') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    district_id: district_id,
                },
                success: function(data) {

                    $(".same_tambon").children().remove();
                    $(".same_tambon").append(` <option value="">--please select--</option>`);
                    $(".same_zipcode").val("");
                    data.forEach((item) => {
                        $(".same_tambon").append(
                            `<option value="${item.id}">${item.name_en}</option>`
                        );
                    });
                    $(".same_tambon").attr('disabled', false);
                },
                error: function() {}
            })
        });

        // BEGIN district

        //  BEGIN tambon
        $(".same_tambon").change(function() {
            let tambon_id = $(this).val();
            $.ajax({
                url: '{{ route('getZipcode') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    tambon_id: tambon_id,
                },
                success: function(data) {
                    $(".same_zipcode").val(data.zipcode);

                },
                error: function() {}
            })
        });

        function sent_address(type) {
            console.log(type);

                if (type == 'sent_other') {

                    $(".i_sent_address").hide();
                    $(".i_sent_other").show();
                    var same_zipcode = $(".same_zipcode").val();
                } else {
                    var zipcode = $(".zipcode").val();
                    $(".i_sent_address").show();
                    $(".i_sent_other").hide();

                }

            }
    </script>







@endsection
