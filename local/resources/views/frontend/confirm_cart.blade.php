    <title>VRich</title>

    @extends('layouts.frontend.app')
    @section('conten')
    <?php

    $cartCollection = Cart::session($bill['type'])->getContent();
    $data = $cartCollection->toArray();

    if ($data) {
        foreach ($data as $value) {
            $pv[] = $value['quantity'] * $value['attributes']['pv'];
        }
        $pv_total = array_sum($pv);
    } else {
        $pv_total = 0;
    }

    ?>
        <div class="bg-whiteLight page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Order') }}">Product List</a></li>
                                <li class="breadcrumb-item active text-truncate" aria-current="page"> Confirm Product List
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-box borderR10 mb-2 mb-md-0">

                            <div class="card-body">

                                <form action="{{ route('payment_submit') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-md-8 col-sm-12">


                                        <div class="card card-box borderR10 mb-2 mb-md-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <input type="hidden" name="sent_type_to_customer" value="sent_type_customer">

                                                    @if($bill['type'] == 'promotion')
                                                <div class="col-md-6">

                                                <h4 class="card-title">Delivery</h4>

                                                <div class="row g-3">
                                                    <div class="col-md-12 col-xl-12 mb-3">
                                                        {{-- <div class="form-check form-check-inline">
                                                            <input class="form-check-input radio" type="radio"
                                                                name="sent_type_to_customer" id="sent_type_customer"
                                                                onclick="sent_type('customer')" value="sent_type_customer"
                                                                checked="checked">
                                                            <label class="form-check-label"
                                                                for="option1R">Buy ownself</label>
                                                        </div> --}}
                                                        {{-- <div class="form-check form-check-inline">
                                                            <input class="form-check-input radio" type="radio"
                                                                name="sent_type_to_customer" value="sent_type_other"
                                                                id="sent_type_other" onclick="sent_type('other')">
                                                            <label class="form-check-label"
                                                                for="option2R">ซื้อให้ลูกทีม</label>
                                                        </div> --}}


                                                     <div class="form-check form-check-inline">
                                                            <input class="form-check-input radio" type="radio"
                                                                name="sent_stock_type"
                                                                onclick="sent_stock('send')" value="send"
                                                                checked="checked">
                                                            <label class="form-check-label"
                                                                for="option1R">Send to address</label>
                                                        </div>

                                                        @if($pv_total >= 1000)
                                                       <div class="form-check form-check-inline">
                                                            <input class="form-check-input radio" type="radio"
                                                                name="sent_stock_type" value="add"
                                                                 onclick="sent_stock('add')">
                                                            <label class="form-check-label"
                                                                for="option2R">Add to Stock</label>
                                                        </div>
                                                        @endif

                                                    </div>

                                                </div>
                                                    </div>
                                                    @endif
{{--
                                                    <div class="col-md-6">
                                                        <h4 class="card-title">เลือกจัดส่งสินค้าโดย </h4>
                                                        <div class="row g-3">
                                                            <div class="col-md-12 col-xl-12 mb-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input radio" type="radio"
                                                                        name="tracking_type"
                                                                         value="Kerry"
                                                                        checked="checked">
                                                                    <label class="form-check-label"
                                                                        for="option1R">Kerry</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input radio" type="radio"
                                                                        name="tracking_type" value="Flash">
                                                                    <label class="form-check-label"
                                                                        for="option2R">Flash </label>
                                                                </div>
                                                                 <div class="form-check form-check-inline">
                                                                    <input class="form-check-input radio" type="radio"
                                                                        name="tracking_type" value="Ems">
                                                                    <label class="form-check-label"
                                                                        for="option2R">Ems </label>
                                                                </div>


                                                            </div>
                                                        </div>
                                                            </div> --}}

                                            </div>




                                                <div class="row">
                                                    <div class="col-md-5 col-xl-5 mb-3" id="check_user"
                                                        style="display: none">
                                                        <div class="card">

                                                            <div class="card-body">
                                                                <h6>Username of the member purchasing the product (PV belongs to the member)</h6>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" id="username"
                                                                        class="form-control" placeholder="Username"
                                                                        aria-label="Username"
                                                                        aria-describedby="button-addon2">
                                                                    <button class="btn btn-primary" type="button"
                                                                        onclick="check()">Confirm Username</button>
                                                                </div>
                                                                <span style="font-size: 12px"
                                                                    class="text-danger">*PT will be spent on the selected member.</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-7 col-xl-7 mb-3" id="data_direct"
                                                        style="display: none">
                                                        <div class="card">

                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-4 col-xxl-3">
                                                                        <div class="ratio ratio-1x1">
                                                                            <div class="rounded-circle">
                                                                                <img src="{{ asset('/frontend/images/man.png') }}"
                                                                                    class="mw-100" alt="">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-8 col-xxl-9">

                                                                        <p id="text_username">Username : PS97 (Position)
                                                                        </p>
                                                                        <p id="text_name"> จันทราวรรณ</p>
                                                                            {{-- <p class="fs-12">
                                                                                รักษาสภาพสมาชิกมาแล้ว
                                                                                <span class="badge rounded-pill bg-light text-dark fw-light">
                                                                                    56 วัน
                                                                                </span>
                                                                            </p> --}}
                                                                            <input type="hidden"
                                                                                name="customers_sent_id_fk"
                                                                                id="customers_sent_id_fk"
                                                                                value="">
                                                                            <input type="hidden"
                                                                                name="customers_sent_user_name"
                                                                                id="customers_sent_user_name"
                                                                                value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>


                                                <h4 class="card-title">Receiver's Address</h4>
                                                <div class="row g-3">
                                                        <div class="col-md-12 col-xl-12 mb-3">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" onchange="sent_address('sent_address')"
                                                                id="sent_address_check" name="receive" value="sent_address"
                                                                checked="checked">
                                                                <label class="form-check-label" for="option1R">Delivery</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" id="sent_other"
                                                                onchange="sent_address('sent_other')" name="receive"
                                                                value="sent_address_other">
                                                                <label class="form-check-label" for="option2R">Others</label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    @if (@$address->province_id)
                                                    <div id="i_sent_address">
                                                        <div class="row g-3" >
                                                            <div class="col-md-4 col-xl-4">
                                                                <label for="" class="form-label">First Name <span
                                                                        class="text-danger same_address_err _err">*</span></label>
                                                                <input type="text" name="name" class="form-control "
                                                                    id="" value="{{ $customer->prefix_name }} {{ $customer->name }} {{ $customer->last_name }}" required>
                                                            </div>

                                                            <div class="col-md-4 col-xl-4">
                                                                <label for="" class="form-label">Phone <span class="text-danger phone_err _err">*</span></label>
                                                                <input name="phone" type="text" class="form-control" name="phone" value="{{ @$address->phone }}">
                                                            </div>

                                                            <div class="col-md-4 col-xl-4">
                                                            </div>

                                                            <div class="col-md-3 col-xl-3">
                                                                <label for="" class="form-label">Address<span
                                                                        class="text-danger same_address_err _err">*</span></label>
                                                                <input type="text" name="house_no" class="form-control"
                                                                value="{{ @$address->address }}" readonly="">
                                                            </div>
                                                            <div class="col-md-2 col-xl-2">
                                                                <label for="" class="form-label">Moo <span
                                                                        class="text-danger same_moo_err _err">*</span></label>
                                                                <input type="text" name="moo" class="form-control"
                                                                value="{{ @$address->moo }}" readonly="">
                                                            </div>
                                                            <div class="col-md-3 col-xl-3">
                                                                <label for="" class="form-label">Soi <span
                                                                        class="text-danger same_soi_err _err">*</span></label>
                                                                <input type="text" name="soi" value="{{ @$address->soi }}" class="form-control"
                                                                readonly="">
                                                            </div>
                                                            <div class="col-md-4 col-xl-4">
                                                                <label for="" class="form-label">Road <span
                                                                        class="text-danger same_road_err _err">*</span></label>
                                                                <input type="text" name="road" class="form-control"
                                                                value="{{ @$address->road }}" readonly="">
                                                            </div>
                                                            <div class="col-md-6 col-xl-4">
                                                                <label for="province" class="form-label">Province</label>
                                                                <label class="form-label text-danger same_province_err _err"></label>


                                                                <input name="province_id" type="hidden" class="form-control"
                                                                value="{{ @$address->province_id }}" >
                                                                <input type="text"  class="form-control"
                                                                value="{{@$address->province_name}}" readonly="">


                                                            </div>
                                                            <div class="col-md-6 col-xl-4">

                                                                <label for="district" class="form-label">District</label>
                                                                <label class="form-label text-danger same_district_err _err"></label>


                                                                <input name="district_id" type="hidden" class="form-control"
                                                                value="{{ @$address->district_id }}">
                                                                <input type="text"  class="form-control"
                                                                value="{{@$address->district_name}}" readonly="">
                                                            </div>
                                                            <div class="col-md-6 col-xl-4">
                                                                <label for="tambon" class="form-label">Subdistrict</label>
                                                                <label class="form-label text-danger same_tambon_err _err"></label>

                                                                <input name="tambon_id" type="hidden" class="form-control"
                                                                value="{{ @$address->tambon_id }}" >
                                                                <input type="text"  class="form-control"
                                                                value="{{@$address->tambon_name}}" readonly="">
                                                            </div>
                                                            <div class="col-md-6 col-xl-4">
                                                                <label for="" class="form-label">Zipcode <span
                                                                        class="text-danger same_zipcode_err _err ">*</span></label>
                                                                <input id="zipcode" name="zipcode" type="text"
                                                                    class="form-control"  value="{{ @$address->zipcode }}"  readonly>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    @else
                                                    <div id="i_sent_address">

                                                        <div class="alert alert-warning icons-alert">

                                                            <p><strong>Warning!</strong> <code>There is no shipping address,
                                                                Please setting before paying.</code> <a
                                                                    href="{{ route('editprofile') }}"
                                                                    class="pcoded-badge label label-warning ">Setting CLICK!!</a></p>
                                                        </div>

                                                    </div>

                                                @endif
                                                <div id="i_sent_other" style="display: none;">


                                                    <div class="row g-3" >
                                                        <div class="col-md-4 col-xl-4">
                                                            <label for="" class="form-label">First Name <span
                                                                    class="text-danger same_address_err _err">*</span></label>
                                                            <input type="text" name="sam_name" class="form-control "
                                                                id="" >
                                                        </div>


                                                        <div class="col-md-6 col-xl-4 mb-3">
                                                            <label for="" class="form-label">Phone </label>
                                                            <input type="text" name="same_phone" class="form-control address_same_card"
                                                                id="">
                                                        </div>
                                                        <div class="col-md-6 col-xl-5">
                                                            <label for="" class="form-label">Address <span
                                                                    class="text-danger same_address_err _err">*</span></label>
                                                            <input type="text" name="same_address" class="form-control address_same_card"
                                                                id="">
                                                        </div>
                                                        <div class="col-md-6 col-xl-3">
                                                            <label for="" class="form-label">Moo <span
                                                                    class="text-danger same_moo_err _err">*</span></label>
                                                            <input type="text" name="same_moo" class="form-control address_same_card"
                                                                id="">
                                                        </div>
                                                        <div class="col-md-6 col-xl-4">
                                                            <label for="" class="form-label">Soi <span
                                                                    class="text-danger same_soi_err _err">*</span></label>
                                                            <input type="text" name="same_soi" class="form-control address_same_card"
                                                                id="">
                                                        </div>
                                                        <div class="col-md-6 col-xl-4">
                                                            <label for="" class="form-label">Road <span
                                                                    class="text-danger same_road_err _err">*</span></label>
                                                            <input type="text" name="same_road" class="form-control address_same_card"
                                                                id="">
                                                        </div>
                                                        <div class="col-md-6 col-xl-4">
                                                            <label for="province" class="form-label">Province</label>
                                                            <label class="form-label text-danger same_province_err _err"></label>
                                                            <select class="form-select address_same_card select_same" name="same_province"
                                                                id="same_province">
                                                                <option value="">--please select--</option>
                                                                @foreach ($province as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name_th }}</option>
                                                                @endforeach
                                                            </select>


                                                        </div>
                                                        <div class="col-md-6 col-xl-4">

                                                            <label for="district" class="form-label">District</label>
                                                            <label class="form-label text-danger same_district_err _err"></label>
                                                            <select class="form-select address_same_card select_same" name="same_district"
                                                                id="same_district" disabled readonly>
                                                                <option value="">--please select--</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-xl-4">
                                                            <label for="tambon" class="form-label">Subdistrict</label>
                                                            <label class="form-label text-danger same_tambon_err _err"></label>
                                                            <select class="form-select address_same_card select_same" name="same_tambon"
                                                                id="same_tambon" disabled readonly>
                                                                <option value="">--please select--</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-xl-4">
                                                            <label for="" class="form-label">Zipcode <span
                                                                    class="text-danger same_zipcode_err _err ">*</span></label>
                                                            <input id="same_zipcode" name="same_zipcode" type="text"
                                                                class="form-control address_same_card" id="">
                                                        </div>

                                                    </div>
                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">

                                        <div class="card card-box borderR10 mb-2 mb-md-0">
                                            <div class="card-body">
                                                <div class="row">

                                                        <h4>Payment Mothod</h4>
                                                        <div class="col-12 col-md-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="type_pay"
                                                                id="flexRadioDefault1" value="e-wallet" checked>
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                                eWallet
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-8 col-lg-8">

                                                            <div class="card cardL card-body borderR10 bg-warning bg-opacity-20 mb-2 mb-md-3">
                                                                <div class="d-flex">
                                                                    <div class="flex-shrink-0">
                                                                        <div class="bg-warning borderR8 iconFlex">
                                                                            <i class="bx bxs-wallet"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <h5>eWallet balance</h5>
                                                                        <h5 class="text-p1  mb-0 fw-bold">{{number_format(Auth::guard('c_user')->user()->ewallet,2)}}</h5>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    </div>
                                                    </div>

                                                <h4>ORDER SUMMARY</h4>
                                                <hr>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="mb-2">Price ({{Cart::session($bill['type'])->getTotalQuantity()}}) Piece</p>
                                                    </div>
                                                    <div class="col-md-6 text-md-end">
                                                        <p class="mb-2">{{ number_format(Cart::session($bill['type'])->getTotal(),2) }} {!!$dataset_currency->icon!!}</p>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <p class="mb-2">Total PT</p>
                                                    </div>
                                                    <div class="col-md-6 text-md-end">

                                                        <p class="mb-2">{{ number_format($pv_total) }} PT</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="mb-2">Shipping cost</p>
                                                    </div>
                                                    <div class="col-md-6 text-md-end">
                                                        @if($dataset_currency->id == 1)
                                                        <p class="mb-2" id="shipping">{{$bill['shipping_th']}}  {!!$dataset_currency->icon!!}</p>
                                                        @else
                                                        <p class="mb-2" id="shipping">{{$bill['shipping_usd']}}  {!!$dataset_currency->icon!!}</p>
                                                        @endif
                                                    </div>


{{--
                                                    <div class="col-md-8">
                                                        <p class="mb-2">ส่วนลดประจำตำแหน่ง( {{$bill['position']}} {{$bill['bonus']}} %)</p>
                                                    </div>
                                                    <div class="col-md-4 text-md-end">
                                                        <p class="mb-2">{{number_format($bill['discount'])}} บาท</p>
                                                    </div> --}}
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="mb-2">Grand Total</p>
                                                    </div>
                                                    <div class="col-md-6 text-md-end">

                                                        @if($dataset_currency->id == 1)
                                                        <p class="mb-2 text-purple1"><span class="text-p1 h5" id="total">{{ number_format(Cart::session($bill['type'])->getTotal()+$bill['shipping_th']) }}</span> {!!$dataset_currency->icon!!}</p>
                                                        @else
                                                        <p class="mb-2 text-purple1"><span class="text-p1 h5" id="total">{{ number_format(Cart::session($bill['type'])->getTotal()+$bill['shipping_usd']) }}</span> {!!$dataset_currency->icon!!}</p>
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <input type="hidden" name="type" value="{{$bill['type']}}">
                                                    <button type="submit"
                                                    class="btn btn-p1 rounded-pill w-100 mb-2 justify-content-center">Confirm Order</button>
                                                <a href="{{ route('cancel_order',['type'=>$bill['type']]) }}" type="button"
                                                    class="btn btn-outline-dark rounded-pill w-100 mb-2 justify-content-center">Cancel</a>



                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <div class="modal fade" id="modal_check" tabindex="-1" aria-labelledby="depositModal3Label"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content borderR25">
                    <div class="modal-header justify-content-center">
                        <h5 class="modal-title" id="depositModal3Label">Buy to member</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4 col-xxl-3">
                                <div class="ratio ratio-1x1">
                                    <div class="rounded-circle">
                                        <img src="{{ asset('/frontend/images/man.png') }}" class="mw-100"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-8 col-xxl-9">



                                <p id="modal_text_username">Username : PS97 (Position)</p>
                                <p id="modal_name"> จันทราวรรณ
                                </p>
                                {{-- <p class="fs-12">
                                รักษาสภาพสมาชิกมาแล้ว
                                <span class="badge rounded-pill bg-light text-dark fw-light">
                                    56 วัน
                                </span>
                            </p> --}}
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer justify-content-center border-0">


                        <div id="confirm_pay_sent_customer"></div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script>
            function sent_type(type) {
                if (type == 'other') {

                    document.getElementById("check_user").style.display = "block";

                } else {
                    document.getElementById("check_user").style.display = "none";
                    document.getElementById("data_direct").style.display = "none";

                }
            }


            function check() {

                var username = $('#username').val();

                $.ajax({
                        url: '{{ route('check_custome_unline') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            'user_name': username
                        }
                    })
                    .done(function(data) {

                        if (data['status'] == 'success') {

                            document.getElementById("modal_text_username").innerHTML = 'Username : ' + data['data'][
                                'user_name'
                            ] + ' (' + data['data']['qualification_name'] + ')';
                            document.getElementById("modal_name").innerHTML = 'K. ' + data['data']['name'] + ' ' + data[
                                'data']['last_name'];


                            var sent_to_customer_username = data['data']['user_name'];
                            document.getElementById("confirm_pay_sent_customer").innerHTML =
                                '<button type="button" class="btn btn-p1 rounded-pill"  onclick="data_direct_confirm(\'' +
                                sent_to_customer_username + '\')">Confirm Username</button>';


                            $("#modal_check").modal('show');
                            //  alert(data['status']);

                        } else {

                            //console.log(data);
                            Swal.fire({
                                icon: 'error',
                                text: data['ms'],
                            })
                        }
                    })
                    .fail(function() {
                        console.log("error");
                    })
            }

            function data_direct_confirm(sent_to_customer_username) {

                var username = $('#username').val();

                $.ajax({
                        url: '{{ route('check_custome_unline') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            'user_name': username
                        }
                    })
                    .done(function(data) {

                        if (data['status'] == 'success') {

                            document.getElementById("text_username").innerHTML = 'Username : ' + data['data'][
                                'user_name'] + ' (' + data['data']['qualification_name'] + ')';
                            document.getElementById("text_name").innerHTML = 'K. ' + data['data']['name'] + ' ' + data[
                                'data']['last_name'];

                            $('#customers_sent_user_name').val(data['data']['user_name']);
                            $('#customers_sent_id_fk').val(data['data']['id']);

                            $('#modal_check').modal('hide');
                            document.getElementById("data_direct").style.display = "block";

                            //  alert(data['status']);
                        } else {

                            //console.log(data);
                            Swal.fire({
                                icon: 'error',
                                text: data['ms'],
                            })
                        }
                    })
                    .fail(function() {
                        console.log("error");
                    })
            }

            function sent_address(type){

                if(type =='sent_other'){

                    document.getElementById("i_sent_address").style.display = "none";
                    document.getElementById("i_sent_other").style.display = "block";
                    var same_zipcode = $("#same_zipcode").val();


                }else{
                    var zipcode = $("#zipcode").val();

                    document.getElementById("i_sent_address").style.display = "block";
                    document.getElementById("i_sent_other").style.display = "none";

                }

            }
        </script>

<script>
    // BEGIN province
    $("#same_province").change(function() {
        let province_id = $(this).val();
        $.ajax({
            url: '{{ route('getDistrict') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                province_id: province_id,
            },
            success: function(data) {
                $("#same_district").children().remove();
                $("#same_tambon").children().remove();
                $("#same_district").append(` <option value="">--please select--</option>`);
                $("#same_tambon").append(` <option value="">--please select--</option>`);
                $("#same_zipcode").val("");
                data.forEach((item) => {
                    $("#same_district").append(
                        `<option value="${item.id}">${item.name_th}</option>`
                    );
                });
                $("#same_district").attr('disabled', false);
                $("#same_tambon").attr('disabled', true);

            },
            error: function() {}
        })
    });
    // END province

    // BEGIN district
    $("#same_district").change(function() {

        let district_id = $(this).val();
        $.ajax({
            url: '{{ route('getTambon') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                district_id: district_id,
            },
            success: function(data) {

                $("#same_tambon").children().remove();
                $("#same_tambon").append(` <option value="">--please select--</option>`);
                $("#same_zipcode").val("");
                data.forEach((item) => {
                    $("#same_tambon").append(
                        `<option value="${item.id}">${item.name_th}</option>`
                    );
                });
                $("#same_tambon").attr('disabled', false);
            },
            error: function() {}
        })
    });

    // BEGIN district

    //  BEGIN tambon
    $("#same_tambon").change(function() {
        let tambon_id = $(this).val();
        $.ajax({
            url: '{{ route('getZipcode') }}',
            type: 'GET',
            dataType: 'json',
            data: {
                tambon_id: tambon_id,
            },
            success: function(data) {
                $("#same_zipcode").val(data.zipcode);

            },
            error: function() {}
        })
    });

    function sent_stock(type){
        // if(type == 'add'){
        //     $("#shipping").html('0');
        //     var total = '{{ number_format(Cart::session($bill['type'])->getTotal()) }}';
        //      $("#total").html(total);

        // }else{
        //     location.reload();
        // }
    }
    //  END tambon
</script>
    @endsection
