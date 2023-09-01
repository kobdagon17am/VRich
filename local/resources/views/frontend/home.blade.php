@extends('layouts.frontend.app')
@section('conten')

    <div class="bg-whiteLight page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-box borderR10 mb-2 mb-lg-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-xxl-3 text-center">
                                    <div class="ratio ratio-1x1">
                                        <div class="rounded-circle">
                                            @if(Auth::guard('c_user')->user()->profile_img)

                                            <img src="{{asset('local/public/profile_customer/'.Auth::guard('c_user')->user()->profile_img)}}" class="mw-100"
                                                alt="" />
                                            @else
                                            <img src="{{ asset('frontend/images/man.png') }}" class="mw-100"
                                            alt="" />
                                            @endif


                                        </div>

                                    </div>
                                    <a href="{{route('editprofileimg')}}" type="button" class="btn btn-outline-primary btn-sm mt-2 rounded-pill" > แก้ไขรูปโปรไฟล์ </a>
                                </div>
                                <div class="col-8 col-xxl-9">
                                    <div class="row">
                                        <div class="col-6">
                                            @php
                                                if (empty(Auth::guard('c_user')->user()->expire_date) || strtotime(Auth::guard('c_user')->user()->expire_date) < strtotime(date('Ymd'))) {
                                                    if (empty(Auth::guard('c_user')->user()->expire_date)) {
                                                        $date_mt_active = 'Not Active';
                                                    } else {
                                                        //$date_mt_active= date('d/m/Y',strtotime(Auth::guard('c_user')->user()->expire_date));
                                                        $date_mt_active = 'Not Active';
                                                    }
                                                    $status = 'danger';
                                                } else {
                                                    $date_mt_active = 'Active ' . date('d/m/Y', strtotime(Auth::guard('c_user')->user()->expire_date));
                                                    $status = 'success';
                                                }
                                            @endphp

                                            <span
                                                class="badge rounded-pill bg-{{ $status }} bg-opacity-20 text-{{ $status }} fw-light ps-1">
                                                <i class="fas fa-circle text-{{ $status }}"></i> {{ $date_mt_active }}
                                            </span>



                                        </div>
                                        <div class="col-6 text-end">
                                            <a type="button" class="btn btn-warning px-2"
                                                href="{{ route('editprofile') }}"><i class="bx bxs-edit"></i></a>
                                        </div>
                                    </div>


                                    <h5>{{ __('text.MemberID') }} :
                                        {{ Auth::guard('c_user')->user()->user_name }}
                                        <?php
                                         $position = \App\Http\Controllers\Frontend\FC\AllFunctionController::position(Auth::guard('c_user')->user()->qualification_id);
                                        ?>
                                        ({{ $position }})</h5>
                                    <h5> {{ Auth::guard('c_user')->user()->name }}
                                        {{ Auth::guard('c_user')->user()->last_name }}</h5>
                                    {{-- <p class="fs-12">
                                        รักษาสภาพสมาชิกมาแล้ว
                                        <span class="badge rounded-pill bg-light text-dark fw-light">
                                            56 วัน
                                        </span>
                                    </p> --}}

                                    @if (Auth::guard('c_user')->user()->regis_doc1_status == 3)
                                        <p class="text-warning">
                                            - รอตรวจสอบเอกสาร บัตรประชาชน
                                        </p>
                                    @endif
                                    @if (Auth::guard('c_user')->user()->regis_doc1_status == 4)
                                        <p class="text-danger">
                                            - บัตรประชาชนไม่ถูกต้อง กรุณาส่งเอกสารใหม่อีกครั้ง
                                        </p>
                                    @endif
                                    @if (Auth::guard('c_user')->user()->regis_doc4_status == 3)
                                        <p class="text-warning">
                                            - รอตรวจสอบเอกสาร บัญชีธนาคาร
                                        </p>
                                    @endif
                                    @if (Auth::guard('c_user')->user()->regis_doc4_status == 4)
                                        <p class="text-danger">
                                            - บัญชีธนาคารไม่ถูกต้อง กรุณาส่งเอกสารใหม่อีกครั้ง
                                        </p>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <span class="label-xs">{{ __('text.Business Opportunnity') }}</span>
                            @if(Auth::guard('c_user')->user()->introduce_id != 'AA')
                            <?php

                            $upline = \App\Http\Controllers\Frontend\FC\AllFunctionController::get_upline(Auth::guard('c_user')->user()->introduce_id);

                            ?>
                            <span class="badge bg-light text-dark fw-light">รหัส {{ @$upline->user_name }} |
                                {{ @$upline->name }} {{ @$upline->last_name }}</span>
                            @else

                            <span class="badge bg-light text-dark fw-light"> เป็นรหัสต้นสาย(ไม่มีผู้แนะนำ)


                            @endif



                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row gx-2 gx-md-3">
                        {{-- <div class="col-4 col-lg-6 d-none d-lg-block">

                            <a href="{{ route('tree') }}">
                                <div class="card cardL card-body borderR10 bg-pink bg-opacity-20 mb-2 mb-md-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="bg-pink bg-opacity-100 borderR8 iconFlex">
                                                <i class='fa fa-sitemap'></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5>แลกโปรโมชั่น</h5>
                                            <p class="fs-12 text-pink">แลกโปรโมชั่น</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div> --}}


                        <div class="col-4 col-lg-6">
                            <a href="{{ route('Workline') }}">


                                <div class="card cardL card-body borderR10 bg-primary bg-opacity-20 mb-2 mb-md-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="bg-primary borderR8 iconFlex">
                                                <i class='bx bx-group'></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5>สายงานสมาชิก</h5>
                                            <p class="fs-12 text-primary"> สายงานสมาชิก </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-4 col-lg-6">
                            <a href="#!">
                                {{-- <a href="{{ route('upgradePosition') }}"> --}}
                                <div class="card cardL card-body borderR10 bg-warning bg-opacity-20 mb-2 mb-md-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="bg-warning borderR8 iconFlex">
                                                <i class='bx bx-slider-alt'></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5>{{ __('text.Higher Position') }}</h5>
                                            <p class="fs-12 text-warning">{{ __('text.Repositioning Management') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-4 col-lg-6">
                            <a href="{{ route('register') }}">
                                {{-- <a href="#!"> --}}

                                <div class="card cardL card-body borderR10 bg-success bg-opacity-20 mb-2 mb-md-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success borderR8 iconFlex">
                                                <i class='bx bx-plus'></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5>{{ __('text.Register') }}</h5>
                                            <p class="fs-12 text-success">{{ __('text.Managing Add Members') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-4 col-lg-6 d-block d-lg-none">
                            <a href="{{ route('Order') }}">
                                <div class="card cardL card-body borderR10 bg-info bg-opacity-20 mb-2 mb-md-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="bg-info borderR8 iconFlex">
                                                <i class='bx bx-cart'></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5>{{ __('text.BuyProduct') }}</h5>
                                            <p class="fs-12 text-info">{{ __('text.Online ordering') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-4 col-lg-6 d-block d-lg-none">
                            <a href="{{ route('order_history') }}">
                                <div class="card cardL card-body borderR10 bg-info bg-opacity-20 mb-2 mb-md-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="bg-info borderR8 iconFlex">
                                                <i class='fa fa-history'></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5>{{ __('text.OrderHistory') }}</h5>
                                            <p class="fs-12 text-info">{{ __('text.OrderHistory') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-4 col-lg-6 d-block d-lg-none">
                            <a href="{{ route('Learning') }}">
                                <div class="card cardL card-body borderR10 bg-pink bg-opacity-20 mb-2 mb-md-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="bg-pink bg-opacity-100 borderR8 iconFlex">
                                                <i class='bx bx-book-open'></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5>{{ __('text.MdkLerning') }}</h5>
                                            <p class="fs-12 text-pink">{{ __('text.Learning/CT') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        {{-- <div class="col-4 col-lg-6 d-block d-lg-none">
                            <a href="{{ route('Contact') }}">
                                <div class="card cardL card-body borderR10 bg-danger bg-opacity-20 mb-2 mb-md-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="bg-danger borderR8 iconFlex">
                                                <i class='bx bx-buildings'></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5>{{ __('text.Contact') }}</h5>
                                            <p class="fs-12 text-danger">{{ __('text.Report') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="dropdown mb-3">
                        <button class="card card-boxDrp dropdown-toggle" href="#"  id="dropdownMenuLinkStock" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex w-100">
                                <div class="flex-shrink-0">
                                    <div class="bg-purple1 bg-opacity-20 borderR8 iconFlex">
                                        <i class='bx bx-box text-purple1 bg-opacity-100'></i>
                                    </div>
                                </div>
                                {{-- <div class="d-flex w-100 pe-4">
                                    <h4 class="mb-0 text-purple1 bg-opacity-100 fw-bold">
                                        <h5 class="mb-0"> MY STOCK </h5>
                                        </h4>
                                    <p class="fs-12 text-secondary mb-0"> คลังสินค้าส่วนตัว </p>
                                </div> --}}

                                <div class="flex-grow-1 ms-3 text-start">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="mb-0">  MY STOCK</h5>

                                    </div>
                                    <p class="fs-12 text-secondary mb-0">คลังสินค้าส่วนตัว</p>
                                </div>
                            </div>
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLinkStock">
                            <li><a class="dropdown-item" href="{{ route('eWallet_history') }}">คลังสินค้าส่วนตัว</a></li>

                            <li><a class="dropdown-item"
                                    href="{{ route('eWallet_history') }}"> รายการเคลื่อนไหวหลังสินค้า </a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="dropdown mb-3">
                        <button class="card card-boxDrp dropdown-toggle" href="#" role="button"
                            id="dropdownMenuLinkTp" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex w-100 pe-4">
                                <div class="flex-shrink-0">
                                    <div class="bg-purple2 bg-opacity-20 borderR8 iconFlex">
                                        <i class='bx bx-plus text-purple2 bg-opacity-100'></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3 text-start">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="mb-0"> TP ที่ใช้ได้ </h5>
                                        <h5 class="text-p1 text-end mb-0 fw-bold">
                                            {{ number_format(Auth::guard('c_user')->user()->pv) }}</h5>
                                    </div>
                                    <p class="fs-12 text-secondary mb-0"> TP ที่ใช้ได้ </p>
                                </div>
                            </div>
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLinkTp">
                            {{-- <li><a class="dropdown-item"
                                    href="{{ route('jp_clarify') }}">{{ __('text.Clarify PV.') }}</a></li> --}}
                            {{-- <li><a class="dropdown-item" href="{{ route('jp_transfer') }}">รับ-โอน PV.</a></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="dropdown mb-3">
                        <button class="card card-boxDrp dropdown-toggle" href="#" role="button"
                            id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex w-100 pe-4">
                                <div class="flex-shrink-0">
                                    <div class="bg-purple2 bg-opacity-20 borderR8 iconFlex">
                                        <i class='bx bxs-wallet text-purple2 bg-opacity-100'></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3 text-start">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="mb-0">eWallet</h5>
                                        <h5 class="text-p1 text-end mb-0 fw-bold">
                                            {{ number_format(Auth::guard('c_user')->user()->ewallet, 2) }}</h5>
                                    </div>
                                    <p class="fs-12 text-secondary mb-0">{{ __('text.Ewallet Mangament') }}</p>
                                </div>
                            </div>
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a onclick="resetForm()" class="dropdown-item" type="button" data-bs-toggle="modal"
                                    data-bs-target="#depositModal">{{ __('text.Depositewallet') }}</a></li>
                            {{-- <li><a class="dropdown-item" type="button" data-bs-toggle="modal"
                                    data-bs-target="#transferModal">{{ __('text.Transferewallet') }}</a></li> --}}
                            <li><a class="dropdown-item" type="button"
                                    id="withdraw">{{ __('text.Withdrawewallet') }}</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('eWallet_history') }}">{{ __('text.Historyewallet') }}</a></li>


                            <li><a class="dropdown-item"
                                href="{{ route('eWallet-TranferHistory') }}"> ประวัติการฝากเงิน eWallet </a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="dropdown mb-3">
                        <button class="card card-boxDrp dropdown-toggle" href="#" role="button"
                            id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex w-100 pe-4">
                                <div class="flex-shrink-0">
                                    <div class="bg-purple2 bg-opacity-20 borderR8 iconFlex">
                                        <i class='bx bxs-coin-stack text-purple2 bg-opacity-100'></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3 text-start">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="mb-0">{{ __('text.Income') }}</h5>
                                        <h5 class="text-p1 text-end mb-0 fw-bold">  {{ number_format(Auth::guard('c_user')->user()->bonus_total, 2) }} </h5>
                                    </div>
                                    <p class="fs-12 text-secondary mb-0">{{ __('text.Bonus Management') }}</p>
                                </div>
                            </div>
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('bonus_all') }}">กำไรส่วนต่าง</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('bonus_fastStart') }}">กำไรส่วนต่างทั้งทีม</a></li>
                            {{-- <li><a class="dropdown-item" href="{{ route('bonus_team') }}">โบนัสบริหารทีม</a></li>
                            <li><a class="dropdown-item" href="{{ route('bonus_discount') }}">โบนัสส่วนลด</a></li>
                            <li><a class="dropdown-item" href="{{ route('bonus_matching') }}">โบนัส Matching</a></li>
                            <li><a class="dropdown-item" href="{{ route('bonus_history') }}">ประวัติการโอนโบนัส</a></li> --}}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-box borderR10 mb-2 mb-md-0">
                        <div class="card-body">
                            <h4 class="card-title">{{ __('text.News Announcements') }}</h4>
                            <hr>
                            <div class="row">
                                @if (isset($News))
                                    @foreach ($News as $item => $value)
                                        @php
                                            $date = new DateTime();
                                            $date->setTimezone(new DateTimeZone('Asia/Bangkok'));
                                        @endphp
                                        @if ($value->end_date_news >= $date->format('Y-m-d'))
                                            <div class="col-md-6 col-xl-4">
                                                <div class="card cardNewsH mb-3">
                                                    <div class="row g-0">
                                                        <div class="col-md-4">
                                                            <div class="box-imageNews">
                                                                <img src="{{ isset($value->image_news) ? asset('local/public/upload/news/image/' . $value->image_news) : '' }}"
                                                                    class="img-fluid rounded-start" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="card-body">
                                                                <span
                                                                    class="badge rounded-pill bg-purple2 bg-opacity-20 text-p1 fw-light mb-1">
                                                                    {{ $value->start_date_news }} to
                                                                    {{ $value->end_date_news }}
                                                                </span>
                                                                <h5 class="card-title">{{ $value->title_news }}</h5>
                                                                <p class="card-text">
                                                                    {{ isset($value->detail_news) ? $value->detail_news : '' }}
                                                                </p>
                                                                <a href="{{ url('news_detail') }}/{{ $value->id }}"
                                                                    class="linkNews stretched-link"><span>อ่านเพิ่มเติม</span><i
                                                                        class='bx bxs-right-arrow-circle'></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <nav aria-label="...">
                                        <ul class="pagination justify-content-end">
                                            {{-- <li class="page-item disabled">
                                                <a class="page-link">Previous</a>
                                            </li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item" aria-current="page">
                                                <a class="page-link" href="#">2</a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li> --}}
                                            {{ $News->links() }}
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('frontend.modal.modal-deposit')
    @include('frontend.modal.modal-changePassword')
    @include('frontend.modal.modal-transfer')
    @include('frontend.modal.modal-withdraw')
@endsection


@section('script')
    <script>
        function printErrorMsg(msg) {
            console.log(msg);
            $('._err').text('');
            $.each(msg, function(key, value) {
                $('.' + key + '_err').text(`*${value}*`);
            });
        }
    </script>
    <script>
        $('#withdraw').click(function() {
            $('#withdrawModal').modal('hide')
            id = <?= Auth::guard('c_user')->user()->id ?>;
            $.ajax({
                type: "post",
                url: '{{ route('check_customerbank') }}',
                asyns: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(data) {
                    if (data == "fail") {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'กรุณากรอกข้อมูล ธนาคาร!',
                        }).then((result) => {
                            location.href = '{{ route('editprofile') }}';
                        });
                    } else {
                        $('#withdrawModal').modal('show')
                    }
                }
            });
        })
    </script>
    <script>
        $('#customers_id_receive').change(function() {

            user_name = '{{Auth::guard('c_user')->user()->user_name}}';
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
                    console.log(data)
                    if (data == "fail") {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'รหัสสมาชิกไม่ถูกต้อง!',
                        })
                        $('#customers_id_receive').val(" ")
                        $('#customers_name_receive').val(" ")
                    } else if (user_name == data.user_name) {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถทำรายการให้ตนเองได้',
                        })
                        $('#customers_id_receive').val(" ")
                        $('#customers_name_receive').val(" ")
                    } else {
                        $('#customers_name_receive').val(data['name'])

                    }
                }
            });
        });
        $('#amt').change(function() {
            amt = $(this).val();
            amount = <?= Auth::guard('c_user')->user()->ewallet ?>;
            if (amount < amt) {
                console.log(amount, amt)
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'eWallet ของท่านไม่เพียงพอ!',
                }).then((result) => {
                    location.reload();
                })
            }
        })
        $('#withdraw').change(function() {
            amt = $(this).val();
            amount = <?= Auth::guard('c_user')->user()->ewallet ?>;
            if (amount < amt) {
                console.log(amount, amt)
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'eWallet ของท่านไม่เพียงพอ!',
                }).then((result) => {
                    location.reload();
                })
            }
            // if (expire_date <= 0) {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'เกิดข้อผิดพลาด',
            //         text: 'วันที่รักษายอดไม่เพียงพอ!',
            //     }).then((result) => {
            //         location.reload();
            //     })
            // }
        })
    </script>
@endsection
