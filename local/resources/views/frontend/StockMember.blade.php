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
                                    <th>Price</th>
                                    {{-- <th>Total price</th> --}}
                                    <th>PT</th>
                                    {{-- <th>PT total</th> --}}
                                    <th>Tranfer</th>
                                    <th>Recive</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $arr_pv = [];
                                $arr_pri = [];

                                ?>
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
                                        <td class="text-center">{{ number_format($value->price, 2) }}</td>


                                        <td class="text-center">{{ number_format($value->pv) }}</td>

                                        <td class="text-center">


                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#transferstockModal_{{ $value->id }}"
                                                class="btn btn-p2 rounded-pill"> <i class="fa fa-retweet"></i></button>

                                        </td>
                                        <td class="text-center">
                                        </td>
                                        <?php
                                        $arr_pv[] = $value->pv * $value->amt;
                                        $arr_pri[] = $value->price_total;
                                        ?>

                                    </tr>

                                    <div class="modal fade" id="transferstockModal_{{ $value->id }}" tabindex="-1"
                                        aria-labelledby="transferstockModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                            <form method="post" action="{{route('stock_tranfer')}}">
                                                @csrf
                                                <div class="modal-content borderR25">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="transferstockModalLabel">Tranfer Stock
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
                                                                    <h5 class="text-center">Transfer Stock </h5>
                                                                    <input type="hidden" name="stock_id" value="{{$value->id}}">
                                                                    <div class="row gx-3">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for=""
                                                                                class="form-label">UserName <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="username_receive"
                                                                                class="form-control username_receive" required>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for=""
                                                                                class="form-label">Name</label>
                                                                            <input type="text" readonly
                                                                                name="name_receive"  class="form-control name_receive">
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
                                                        <button type="submit"
                                                            class="btn btn-p1 rounded-pill d-flex align-items-center confirm"><i
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
                    console.log(data)
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
@endsection
