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
    <link href="{{ asset('backend/assets/css/forms/form-widgets.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/forms/file-upload.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-header')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">ระบบคลังบริษัท</li>
            <li class="breadcrumb-item active" aria-current="page"><span>รับเข้าสินค้า</span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="widget-content widget-content-area br-6">
        <div class="row">
            <div class="col-md-12 text-right">
                <div class="input-group-prepend">
                    <button class="btn btn-success btn-rounded " data-toggle="modal" data-target="#add" type="button"><i
                            class="las la-plus-circle font-20"></i>
                        รับเข้าสินค้า</button>
                </div>
            </div>
            <div class="modal fade bd-example-modal-lg" id="add" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header ml-4">
                            <h5 class="modal-title" id="myLargeModalLabel"><b>รับเข้าสินค้า</b></h5>
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
                                            <form method="post" action="{{ route('admin/Stockin_insert') }}"
                                                enctype="multipart/form-data" id="msform">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 mx-0">
                                                        <div class="form-card">
                                                            <div class="w-100">
                                                                <div class="form-group row">
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>สาขา:</b></label>
                                                                        <span
                                                                            class="form-label text-danger branch_id_fk_err _err"></span>
                                                                        <select class="form-control branch_select"
                                                                            name="branch_id_fk">
                                                                            <option selected disabled> เลือกสาขา
                                                                            </option>
                                                                            @foreach ($get_branch as $val)
                                                                                <option value="{{ $val->id }}">
                                                                                    {{ $val->branch_name }}
                                                                                    ({{ $val->branch_code }})
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>คลังสินค้า:</b></label>
                                                                        <span
                                                                            class="form-label text-danger warehouse_id_fk_err _err"></span>
                                                                        <select class="form-control warehouse_select"
                                                                            name="warehouse_id_fk" disabled>
                                                                            <option selected disabled> เลือกคลัง
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>สินค้า:</b></label>
                                                                        <span
                                                                            class="form-label text-danger product_id_fk_err _err"></span>
                                                                        <select class="form-control product_select"
                                                                            name="product_id_fk">
                                                                            <option selected disabled> เลือกสินค้า
                                                                            </option>
                                                                            @foreach ($get_product as $key => $val)
                                                                                <option value="{{ $val->id }}"
                                                                                    data-name_unit="{{ $val->product_unit_name }}">
                                                                                    {{-- {{ $key + 1 }} . --}}
                                                                                    {{ $val->product_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>หมายเลขล๊อตสินค้า:</b></label>
                                                                        <input type="hidden" name="lot_number"
                                                                            id="lot_number" value="{{ $code }}">
                                                                        <span
                                                                            class="form-label text-danger lot_number_err _err"></span>
                                                                        <input type="text" name="lot_number"
                                                                            class="form-control"
                                                                            placeholder="หมายเลขล๊อตสินค้า"
                                                                            value="{{ $code }}" disabled>
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>จำนวนสินค้า:</b></label>
                                                                        <span
                                                                            class="form-label text-danger product_amount_err _err"></span>
                                                                        <input type="number" min="1"
                                                                            name="product_amount" class="form-control"
                                                                            placeholder="จำนวนสินค้า">
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>หน่วยสินค้า:</b></label>
                                                                        <span
                                                                            class="form-label text-danger product_unit_id_fk_err _err"></span>
                                                                        <select class="form-control product_unit_select"
                                                                            name="product_unit_id_fk" disabled>
                                                                            <option selected disabled> เลือกหน่วยสินค้า
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    {{-- <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>เลขที่เอกสาร:</b></label>
                                                                        <span
                                                                            class="form-label text-danger doc_no_err _err"></span>
                                                                        <input type="text" name="doc_no"
                                                                            class="form-control"
                                                                            placeholder="เลขที่เอกสาร">
                                                                    </div> --}}
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>วันที่รับเข้าสินค้า:</b></label>
                                                                        <span
                                                                            class="form-label text-danger date_stock-in_err _err"></span>
                                                                        <input class="form-control" type="date"
                                                                            value="yyyy-mm-dd" name="date_stock_in">
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>วันที่หมดอายุ:</b></label>
                                                                        <span
                                                                            class="form-label text-danger expire_stock-in_err _err"></span>
                                                                        <input class="form-control" type="date"
                                                                            value="yyyy-mm-dd" name="expire_stock_in">
                                                                    </div>
                                                                    <div class="col-lg-6 mt-2 text-left">
                                                                        <label><b>ไฟล์เอกสารแนบ:</b></label>
                                                                        <div class="upload text-center img-thumbnail">
                                                                            <input type="file" name="doc_name"
                                                                                class="dropify">
                                                                        </div>
                                                                        {{-- <div id="dropzone">
                                                                            <form action="/upload" class="dropzone needsclick dz-clickable" id="demo-upload">
                                                                                <div class="dz-message needsclick">
                                                                                <button type="button" class="dz-button" name="doc_name">Drop files here or click to upload.</button>
                                                                                <br>
                                                                                <span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
                                                                                </div>
                                                                            </form>
                                                                        </div> --}}
                                                                    </div>
                                                                    <div class="col-lg-6 mt-2 text-left">
                                                                        <label><b>หมายเหตุ:</b></label>
                                                                        <textarea class="form-control" rows="9" name="stock_remark" placeholder="รายละเอียดการรับเข้าสินค้า"></textarea>
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <input type="hidden" name="stock_type"
                                                                            value="in">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="info-area col-md-12 text-center mt-4 ">
                                                            <button type="submit" class="btn btn-info btn-rounded"
                                                                name="stock_in_add" value="success">
                                                                <i class="las la-plus-circle"></i> รับเข้าสินค้า</button>

                                                        </div>

                                                    </div>
                                                </div>
                                            </form>
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
                            <h5 class="modal-title" id="myLargeModalLabel"><b>รับเข้าสินค้า</b></h5>
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
                                            <form method="post" action="{{ route('admin/update_stock_in') }}"
                                                enctype="multipart/form-data" id="msform">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 mx-0">
                                                        <div class="form-card">
                                                            <div class="w-100">
                                                                <div class="form-group row">
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <input type="hidden" name="id"
                                                                            id="id">
                                                                        <label><b>สาขา:</b></label>
                                                                        <input type="text" class="form-control"
                                                                            id="branch_id_fk" name="branch_id_fk"
                                                                            placeholder="สาขา" disabled>

                                                                    </div>
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>คลังสินค้า:</b></label>
                                                                        <input type="text" class="form-control"
                                                                            id="warehouse_id_fk" name="warehouse_id_fk"
                                                                            placeholder="คลังสินค้า" disabled>
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>สินค้า:</b></label>
                                                                        <input type="text" class="form-control"
                                                                            id="product_id_fk" name="product_id_fk"
                                                                            placeholder="สินค้า" disabled>

                                                                    </div>
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>หมายเลขล๊อตสินค้า:</b></label>
                                                                        <input type="text" class="form-control"
                                                                            id="lot_number" name="lot_number"
                                                                            placeholder="หมายเลขล๊อตสินค้า"
                                                                            value="{{ $code }}" disabled>

                                                                    </div>
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>จำนวนสินค้า:</b></label>
                                                                        <input type="text" class="form-control"
                                                                            id="product_amount" name="product_amount"
                                                                            placeholder="จำนวนสินค้า" disabled>

                                                                    </div>
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>หน่วยสินค้า:</b></label>
                                                                        <input type="text" class="form-control"
                                                                            id="product_unit_id_fk"
                                                                            name="product_unit_id_fk"
                                                                            placeholder="หน่วยสินค้า" disabled>

                                                                    </div>
                                                                    {{-- <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>เลขที่เอกสาร:</b></label>
                                                                        <input type="text" class="form-control"
                                                                            id="doc_no" name="doc_no"
                                                                            placeholder="เลขที่เอกสาร" disabled>

                                                                    </div> --}}
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>วันที่รับเข้าสินค้า:</b></label>
                                                                        <input type="date" class="form-control"
                                                                            id="date_stock_in" name="date_stock_in"
                                                                            placeholder="วันที่รับเข้าสินค้า" disabled>
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2 text-left">
                                                                        <label><b>วันที่หมดอายุ:</b></label>
                                                                        <input type="date" class="form-control"
                                                                            id="expire_stock_in" name="expire_stock_in"
                                                                            placeholder="วันที่หมดอายุ" disabled>
                                                                    </div>
                                                                    <div class="col-lg-6 mt-2 text-left">
                                                                        <label><b>ไฟล์เอกสารแนบ:</b></label>
                                                                        <div id="img"></div>
                                                                    </div>
                                                                    <div class="col-lg-6 mt-2 text-left">
                                                                        <label><b>หมายเหตุ:</b></label>
                                                                        <textarea class="form-control" rows="4" id="stock_remark" name="stock_remark"
                                                                            placeholder="รายละเอียดการรับเข้าสินค้า"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="info-area col-md-12 text-center mt-4">
                                                            <div id="stock_button">
                                                                <button type="submit" class="btn btn-success btn-rounded"
                                                                    name="stock_status" value="confirm">
                                                                    <i class="las la-check-circle"></i>
                                                                    ยืนยัน
                                                                </button>

                                                                <button type="submit" class="btn btn-danger btn-rounded"
                                                                    name="stock_status" value="cancel">
                                                                    <i class="las la-times-circle"></i>
                                                                    ยกเลิก
                                                                </button>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </form>
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


        <h6>รายการรับเข้าสินค้ารออนุมัติและยกเลิก</h6>
        <div class="table-responsive mb-4">
            <table id="" class="table table-hover table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>สาขา</th>
                        <th>คลัง</th>
                        <th>สินค้า</th>
                        <th>จำนวน</th>
                        <th>หน่วย</th>
                        <th>หมายเลขล๊อต</th>
                        <th>วันที่รับเข้า</th>
                        <th>วันที่หมดอายุ</th>
                        <th>ผู้ทำรายการ</th>
                        <th>ผู้อนุมัติ</th>
                        <th>วันที่อนุมัติ</th>
                        <th>สถานะ</th>
                        <th>หมายเหตุ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($get_stock_in as $value)
                        @if (
                            ($value->stock_type == 'in' && $value->stock_status != 'confirm') ||
                                ($value->stock_type == 'in_transfer' && $value->stock_status != 'confirm'))
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $value->branch_name }}</td>
                                <td>{{ $value->warehouse_name }}</td>
                                <td>{{ $value->product_name }}</td>
                                <td>{{ $value->amt }}</td>
                                <td>{{ $value->product_unit_name }}</td>
                                <td>{{ $value->lot_number }}</td>
                                <td>{{ $value->date_in_stock }}</td>
                                <td>{{ $value->lot_expired_date }}</td>
                                <td>{{ $value->create_name }}</td>
                                <td>{{ $value->approve_name }}</td>
                                <td>{{ $value->approve_date }}</td>
                                <td>
                                    @if ($value->stock_status == 'pending')
                                        <span class="badge badge-pill badge-warning light">รออนุมัติ</span>
                                    @endif
                                    @if ($value->stock_status == 'confirm')
                                        <span class="badge badge-pill badge-success light">สำเร็จ</span>
                                    @endif
                                    @if ($value->stock_status == 'cancel')
                                        <span class="badge badge-pill badge-danger light">ยกเลิก</span>
                                    @endif
                                </td>
                                <td>{{ $value->stock_remark }}</td>
                                <td>
                                    <a href="#!" onclick="edit({{ $value->id }})" class="p-2">
                                        <i class="lab la-whmcs font-25 text-warning"></i></a>
                                </td>
                            </tr>
                        @endif
                    @endforeach

                </tbody>
            </table>
        </div>
        
        <h6>รายการรับเข้าสินค้าอนุมัติแล้ว</h6>
        <hr>
        <div class="row">
            <div class="col-lg-3 mb-2 text-left">
                <span class="form-label text-danger branch_id_fk_err _err"></span>
                <select class="form-control branch_select" name="branch_id_fk" id="s_branch_id_fk">
                    <option selected disabled> เลือกสาขา
                    </option>
                    @foreach ($get_branch as $val)
                        <option value="{{ $val->id }}">
                            {{ $val->branch_name }}
                            ({{ $val->branch_code }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3 mb-2 text-left">
                <span class="form-label text-danger warehouse_id_fk_err _err"></span>
                <select class="form-control warehouse_select" name="warehouse_id_fk" id="s_warehouse_id_fk" disabled>
                    <option selected disabled> เลือกคลัง
                    </option>
                </select>
            </div>
            <div class="col-lg-3 mb-2 text-left">
                <select class="form-control" name="product_name" id="s_product_name">
                    <option selected disabled> เลือกสินค้า
                    </option>
                    @foreach ($get_product as $key => $val)
                        <option value="{{ $val->id }}" data-name_unit="{{ $val->product_unit_name }}">
                            {{-- {{ $key + 1 }} . --}}
                            {{ $val->product_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- <div class="col-lg-3  mt-2">
                <label><b>หมายเลขล๊อต:</b></label>
                <select class="form-control" name="lot_number">
                </select>
            </div> --}}
            <div class="col-lg-3 mb-2 text-left" style="margin-top:20x">
                <button type="button" class="btn btn-outline-success btn-rounded" id="search-form"><i class="las la-search font-15"></i>
                    สืบค้น</button>
            </div>
        </div>
        <div class="table-responsive mt-2 mb-2">
            <table id="basic-dt" class="table table-hover" style="width:100%">

            </table>
        </div>


    </div>
@endsection
@section('js')
    <script src="{{ asset('backend/plugins/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/profile_edit.js') }}"></script>
    <script src="{{ asset('backend/assets/js/forms/file-upload.js') }}"></script>
    <script src="{{ asset('backend/plugins/dropzone/dropzone.min.js') }}"></script>


    <script src="{{ asset('backend/plugins/table/datatable/datatables.js') }}"></script>
    <!--  The following JS library files are loaded to use Copy CSV Excel Print Options-->
    <script src="{{ asset('backend/plugins/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/table/datatable/button-ext/jszip.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/table/datatable/button-ext/buttons.print.min.js') }}"></script>
    <!-- The following JS library files are loaded to use PDF Options-->
    <script src="{{ asset('backend/plugins/table/datatable/button-ext/pdfmake.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/table/datatable/button-ext/vfs_fonts.js') }}"></script>


    <script>
        $('.branch_select').change(function() {
            $('.warehouse_select').prop('disabled', false);

            const id = $(this).val();
            $.ajax({
                url: '{{ route('get_data_warehouse_select') }}',
                type: 'GET',
                dataType: 'json',
                async: false,
                data: {
                    id: id,
                },
                success: function(data) {
                    append_warehouse_select(data);
                },
            });
        });

        function append_warehouse_select(data) {
            $('.warehouse_select').empty();
            $('.warehouse_select').append(`
                <option disabled selected value=""> เลือกคลัง </option>
                `);
            data.forEach((val, key) => {

                $('.warehouse_select').append(`
                <option value="${val.id}">${val.warehouse_name} (${val.warehouse_code})</option>
                `);
            });
        }



        $('.product_select').change(function() {
            $('.product_unit_select').prop('disabled', false);

            const id = $(this).val();
            const name = $(this).find(':selected').data('name_unit');

            $('.product_unit_select').empty();

            $('.product_unit_select').append(`
        <option value="${id}">${name}</option>
    `);
        });



        function edit(id) {
            $.ajax({
                    url: '{{ route('admin/view_stock_in') }}',
                    type: 'GET',
                    data: {
                        id
                    }
                })
                .done(function(data) {
                    // console.log(data);
                    $("#edit").modal();
                    $("#id").val(data['data']['id']);
                    $("#branch_id_fk").val(data['data']['branch_name']);
                    $("#warehouse_id_fk").val(data['data']['warehouse_name']);
                    $("#product_id_fk").val(data['data']['product_name']);
                    $("#lot_number").val(data['data']['lot_number']);
                    $("#product_amount").val(data['data']['amt']);
                    $("#product_unit_id_fk").val(data['data']['product_unit_name']);
                    // $("#doc_no").val(data['data']['doc_no']);
                    $("#date_stock_in").val(data['data']['date_in_stock']);
                    $("#expire_stock_in").val(data['data']['lot_expired_date']);
                    $("#stock_remark").val(data['data']['stock_remark']);


                    var img = '{{ asset('') }}';
                    var img_url = img + data['data']['url'] + '/' + data['data']['doc_name'];

                    var htmlContent = '<img src="' + img_url +
                        '"class="img-fluid" id="doc_name" name="doc_name" alt="Document Image">';
                    $("#img").html(htmlContent);



                    if (data['data']['stock_status'] == 'cancel' || data['data']['stock_status'] == 'confirm') {
                        stock_button.style.display = "none";

                        // console.log('ปิด');

                    } else {
                        stock_button.style.display = "block";
                        // console.log(data['data']['stock_status']);
                    }


                })
                .fail(function() {
                    console.log("error");
                })
        }

        $(function() {
            table_order = $('#basic-dt').DataTable({
                // dom: 'Bfrtip',
                // buttons: ['excel'],
                searching: false,
                ordering: true,
                lengthChange: false,
                responsive: true,
                // paging: true,
                pageLength: 20,
                processing: true,
                serverSide: true,
                "language": {
                    "lengthMenu": "แสดง _MENU_ แถว",
                    "zeroRecords": "ไม่พบข้อมูล",
                    "info": "แสดงหน้า _PAGE_ จาก _PAGES_ หน้า",
                    "search": "ค้นหา",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "paginate": {
                        "first": "หน้าแรก",
                        "previous": "ย้อนกลับ",
                        "next": "ถัดไป",
                        "last": "หน้าสุดท้าย"
                    },
                    'processing': "กำลังโหลดข้อมูล",
                },
                ajax: {
                    url: '{{ route('admin/Stock_in_confirm_datatable') }}',
                    data: function(d) {
                        d.s_branch_id_fk = $('#s_branch_id_fk').val();
                        d.s_warehouse_id_fk = $('#s_warehouse_id_fk').val();
                        d.s_product_name = $('#s_product_name').val();
 
                        // d.position = $('#type').val();
                        // d.id_card = $('#id_card').val();

                    },
                },


                columns: [
                    // {
                    //     data: "id",
                    //     title: "ลำดับ",
                    //     className: "w-10 text-center",
                    // },


                    {
                        data: "branch_name",
                        title: "สาขา",
                        className: "w-10 ",
                    },
                    {
                        data: "warehouse_name",
                        title: "คลัง",
                        className: "w-10",
                    },

                    {
                        data: "product_name",
                        title: "สินค้า",
                        className: "w-10",
                    },

                    {
                        data: "amt",
                        title: "จำนวน",
                        className: "w-10",

                    },

                    {
                        data: "product_unit_name",
                        title: "หน่วย",
                        className: "w-10",

                    },




                    {
                        data: "lot_number",
                        title: "หมายเลขล๊อต",
                        className: "w-10",
                    },

                    {
                        data: "date_in_stock",
                        title: "วันที่รับเข้า",
                        className: "w-10",
                    },

                    {
                        data: "lot_expired_date",
                        title: "วันที่หมดอายุ",
                        className: "w-10",
                    },

                    {
                        data: "create_name",
                        title: "ผู้ทำรายการ",
                        className: "w-10",
                    },

                    {
                        data: "approve_name",
                        title: "ผู้อนุมัติ",
                        className: "w-10",
                    },
                    {
                        data: "approve_date",
                        title: "วันที่อนุมัติ",
                        className: "w-10",
                    },

                    {
                        data: "stock_status",
                        title: "สถานะ",
                        className: "w-10",
                    },

                    {
                        data: "stock_remark",
                        title: "หมายเหตุ",
                        className: "w-10",
                    },


                    {
                        data: "action",
                        title: "Action",
                        className: "w-10",
                    },



                ],



            });
            $('#search-form').on('click', function(e) {
                table_order.draw();
                e.preventDefault();
            });

        });
    </script>
@endsection
