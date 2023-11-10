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
            <li class="breadcrumb-item">ระบบคลัง</li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin/Stock_out') }}">คลังสินค้า</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>โอนย้ายสินค้า</span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="widget-content widget-content-area br-6">
        <form method="post" action="{{ route('admin/Stockout_insert') }}" enctype="multipart/form-data" id="msform">
            @csrf
            <div class="row">
                <div class="col-md-12 mx-0">
                    <div class="form-card">
                        <div class="w-100">
                            <div class="form-group row">
                                <input type="hidden" name="transaction_stock" value="{{ $code }}">
                                <input type="hidden" name="stock_id_fk" value="{{ $get_stock->id }}">

                                <div class="col-lg-4  mt-2 text-left">
                                    <label><b>สาขาต้นทาง:</b></label>
                                    <span class="form-label text-danger branch_id_fk_err _err"></span>
                                    <input type="text" name="branch_id_fk" class="form-control"
                                        value="{{ $get_stock->branch_name }}" disabled>
                                    <input type="hidden" name="branch_id_fk" value="{{ $get_stock->branch_id_fk }}">
                                </div>
                                <div class="col-lg-4  mt-2 text-left">
                                    <label><b>คลังสินค้าต้นทาง:</b></label>
                                    <span class="form-label text-danger warehouse_id_fk_err _err"></span>
                                    <input type="text" name="warehouse_id_fk" class="form-control"
                                        value="{{ $get_stock->warehouse_name }}" disabled>
                                    <input type="hidden" name="warehouse_id_fk" value="{{ $get_stock->warehouse_id_fk }}">
                                </div>
                                <div class="col-lg-4  mt-2 text-left">
                                    <label><b>สินค้าต้นทาง:</b></label>
                                    <span class="form-label text-danger product_id_fk_err _err"></span>
                                    <input type="text" name="product_id_fk" class="form-control"
                                        value="{{ $get_stock->product_name }}" disabled>
                                    <input type="hidden" name="product_id_fk" value="{{ $get_stock->product_id_fk }}">
                                </div>
                                <div class="col-lg-4  mt-2 text-left">
                                    <label><b>สาขาปลายทาง:</b></label>
                                    <span class="form-label text-danger branch_out_id_fk_err _err"></span>
                                    <select class="form-control branch_out_select" name="branch_out_id_fk"  required>
                                        <option selected disabled value=""> เลือกสาขาปลายทาง
                                        </option>
                                        @foreach ($get_branch as $val)
                                            <option value="{{ $val->id }}">
                                                {{ $val->branch_name }}
                                                ({{ $val->branch_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4  mt-2 text-left">
                                    <label><b>คลังสินค้าปลายทาง:</b></label>
                                    <span class="form-label text-danger warehouse_out_id_fk_err _err"></span>
                                    <select class="form-control warehouse_out_select" name="warehouse_out_id_fk" disabled required>
                                        <option selected disabled value=""> เลือกคลังปลายทาง
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-4  mt-2 text-left">
                                    <label><b>หมายเหตุ:</b></label>
                                    <textarea class="form-control" name="stock_out_remark" placeholder="รายละเอียดการโอนย้ายสินค้า"></textarea>
                                </div>
                                <div class="col-lg-4  mt-2 text-left">
                                    <input type="hidden" name="stock_type" value="transfer">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-2">
                        <h6><b>รายการล๊อตสินค้าจากสาขาต้นทาง</b></h6>
                        <table id="ordertable" class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>หมายเลขล๊อต</th>
                                    {{-- <th>วันที่รับเข้า</th> --}}
                                    <th>วันที่หมดอายุ</th>
                                    <th>จำนวนสินค้าคงเหลือ</th>
                                    <th>จำนวนสินค้าโอนย้าย</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($get_stock_lot as $value)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $value->lot_number }}
                                            <input name="lot_number[{{$i}}]"
                                                value="{{ $value->lot_number }}" type="hidden">
                                        </td>

                                        <td>{{ $value->lot_expired_date }}</td>
                                        <td>{{ $value->lot_balance }}</td>
                                        <td>
                                            <input type="number" max="{{ $value->lot_balance }}" min="0"
                                                name="amt[{{$i}}]" class="amt_input form-control"
                                                style="max-width: 100px; max-height: 40px; border-radius: 5px;"
                                                value="0">
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- เพิ่มแถวสุดท้ายเพื่อแสดงผลรวมจำนวนสินค้าจำนวนที่โอนย้ายสินค้า -->
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-left"><b>รวมจำนวนสินค้าโอนย้ายทั้งหมด</b></td>
                                    <td>
                                        <h6><b><span class="total_amt_out"></span></b></h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if(count($get_stock_lot) > 0)
                    <div class="info-area col-md-12 text-center mt-2 mb-4">
                        <button type="submit" class="btn btn-info btn-rounded" name="stock_out_add" value="success">
                            <i class="las la-plus-circle"></i> โอนย้ายสินค้า</button>
                    </div>
                    @endif
                </div>
            </div>
        </form>
        <div class="modal fade bd-example-modal-lg" id="edit" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header ml-4">
                        <h5 class="modal-title" id="myLargeModalLabel"><b>โอนย้ายสินค้า</b></h5>
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
                                        <form method="post" action="{{ route('admin/update_stock_out') }}"
                                            enctype="multipart/form-data" id="msform">
                                            @csrf
                                            <input type="hidden" name="stock_id_fk" value="{{ $get_stock->id }}">
                                            <div class="row">
                                                <div class="col-md-12 mx-0">
                                                    <div class="form-card">
                                                        <div class="w-100">
                                                            <div class="form-group row">
                                                                <input type="hidden" name="id" id="id">
                                                                <input type="hidden" name="transaction_stock"
                                                                    id="transaction_stock" value="{{ $code }}">
                                                                <div class="col-lg-4  mt-2 text-left">
                                                                    <label><b>สาขาต้นทาง:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        id="branch_name" name="branch_name"
                                                                        placeholder="สาขาต้นทาง" disabled>
                                                                </div>
                                                                <div class="col-lg-4  mt-2 text-left">
                                                                    <label><b>คลังสินค้าต้นทาง:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        id="warehouse_name" name="warehouse_name"
                                                                        placeholder="คลังสินค้าต้นทาง" disabled>
                                                                </div>
                                                                <div class="col-lg-4  mt-2 text-left">
                                                                    <label><b>สินค้าต้นทาง:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        id="product_name" name="product_name"
                                                                        placeholder="สินค้าต้นทาง" disabled>
                                                                </div>

                                                                <div class="col-lg-4  mt-2 text-left">
                                                                    <label><b>สาขาปลายทาง:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        id="branch_name_out" name="branch_name_out"
                                                                        placeholder="สาขาปลายทาง" disabled>
                                                                </div>
                                                                <div class="col-lg-4  mt-2 text-left">
                                                                    <label><b>คลังสินค้าปลายทาง:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        id="warehouse_name_out"
                                                                        name="warehouse_name_out"
                                                                        placeholder="คลังสินค้าปลายทาง" disabled>
                                                                </div>
                                                                <div class="col-lg-4  mt-2 text-left">
                                                                    <label><b>จำนวนสินค้าโอนย้าย:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        id="total_amt_out" name="total_amt_out"
                                                                        placeholder="จำนวนสินค้าโอนย้าย" disabled>
                                                                </div>
                                                                <div class="col-lg-12  mt-2 text-left">
                                                                    <label><b>หมายเหตุ:</b></label>
                                                                    <textarea class="form-control" id="stock_out_remark" name="stock_out_remark"
                                                                        placeholder="รายละเอียดการโอนย้ายสินค้า" disabled></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="info-area col-md-12 text-center">
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

    <div class="widget-content widget-content-area mt-4 br-6">

        <div class="table-responsive mt-2 mb-4">
            <h6>รายการโอนย้ายสินค้ารออนุมัติและยกเลิก</h6>
            <table id="ordertable" class="table table-hover table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>สาขาต้นทาง</th>
                        <th>คลังต้นทาง</th>
                        <th>สาขาปลายทาง</th>
                        <th>คลังปลายทาง</th>
                        <th>สินค้า</th>
                        <th>จำนวนโอนย้ายสินค้า</th>
                        <th>หน่วย</th>
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
                    @foreach ($get_stock_out as $value)
                        @if ($value->stock_status != 'confirm')
                            <tr>
                                <td>{{ $value->branch_name }}</td>
                                <td>{{ $value->warehouse_name }}</td>
                                <td>{{ $value->branch_name_out }}</td>
                                <td>{{ $value->warehouse_name_out }}</td>
                                <td>{{ $value->product_name }}</td>
                                <td>{{ $value->total_amt_out }}</td>
                                <td>{{ $value->product_unit_name }}</td>
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
                                <td>{{ $value->stock_out_remark }}</td>
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

        <h6>รายการโอนย้ายสินค้าอนุมัติแล้ว</h6>
        <div class="row">
            <div class="col-lg-2 mb-2 text-left">
                <span class="form-label text-danger branch_id_fk_err _err"></span>
                <select class="form-control branch_select" name="branch_id_fk" id="s_branch_id_fk">
                    <option selected disabled> เลือกสาขาต้นทาง
                    </option>
                    @foreach ($get_branch as $val)
                        <option value="{{ $val->id }}">
                            {{ $val->branch_name }}
                            ({{ $val->branch_code }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 mb-2 text-left">
                <span class="form-label text-danger warehouse_id_fk_err _err"></span>
                <select class="form-control warehouse_select" name="warehouse_id_fk" id="s_warehouse_id_fk">
                    <option selected disabled> เลือกคลังต้นทาง
                    </option>
                    @foreach ($get_warehouse as $val)
                        <option value="{{ $val->id }}">
                            {{ $val->warehouse_name }}
                            ({{ $val->warehouse_code }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 mb-2 text-left">
                <span class="form-label text-danger branch_out_id_fk_err _err"></span>
                <select class="form-control branch_select" name="branch_out_id_fk" id="out_branch_id_fk">
                    <option selected disabled> เลือกสาขาปลายทาง
                    </option>
                    @foreach ($get_branch as $val)
                        <option value="{{ $val->id }}">
                            {{ $val->branch_name }}
                            ({{ $val->branch_code }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 mb-2 text-left">
                <span class="form-label text-danger warehouse_out_id_fk_err _err"></span>
                <select class="form-control warehouse_select" name="warehouse_out_id_fk" id="out_warehouse_id_fk">
                    <option selected disabled> เลือกคลังต้นทาง
                    </option>
                    @foreach ($get_warehouse as $val)
                        <option value="{{ $val->id }}">
                            {{ $val->warehouse_name }}
                            ({{ $val->warehouse_code }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 mb-2 text-left">
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
            <div class="col-lg-2 mb-2 text-left" style="margin-top:23x">
                <button type="button" class="btn btn-outline-success btn-rounded" id="search-form"><i
                        class="las la-search font-15"></i>
                    สืบค้น</button>
            </div>
        </div>
        <div class="table-responsive mt-2 mb-2">
            <table id="basic-dt" class="table table-hover" style="width:100%">

            </table>
        </div>
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
        function edit(id) {
            $.ajax({
                    url: '{{ route('admin/view_stock_out') }}',
                    type: 'GET',
                    data: {
                        id
                    }
                })
                .done(function(data) {
                    // console.log(data);
                    $("#edit").modal();
                    $("#id").val(data['data']['id']);
                    $("#branch_name").val(data['data']['branch_name']);
                    $("#warehouse_name").val(data['data']['warehouse_name']);
                    $("#branch_name_out").val(data['data']['branch_name_out']);
                    $("#warehouse_name_out").val(data['data']['warehouse_name_out']);
                    $("#product_name").val(data['data']['product_name']);
                    $("#product_unit_id_fk").val(data['data']['product_unit_id_fk']);
                    $("#total_amt_out").val(data['data']['total_amt_out']);
                    $("#stock_out_remark").val(data['data']['stock_out_remark']);


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

        //เลือกสาขาปลายทางแล้วเปิดคลังปลายทาง
        $('.branch_out_select').change(function() {
            $('.warehouse_out_select').prop('disabled', false);

            const id = $(this).val();
            $.ajax({
                url: '{{ route('admin/get_data_warehouse_out_select') }}',
                type: 'GET',
                dataType: 'json',
                async: false,
                data: {
                    id: id,
                },
                success: function(data) {
                    append_warehouse_out_select(data);
                },
            });
        });

        function append_warehouse_out_select(data) {
            $('.warehouse_out_select').empty();
            $('.warehouse_out_select').append(`
                <option disabled selected value=""> เลือกคลัง </option>
                `);
            data.forEach((val, key) => {

                $('.warehouse_out_select').append(`
                <option value="${val.id}">${val.warehouse_name} (${val.warehouse_code})</option>
                `);
            });
        }


        //คำนวนจันสินค้าโอนย้ายสินค้า
        $(document).ready(function() {
            // สร้างตัวแปรสำหรับเก็บรวมจำนวนสินค้าจำนวนที่โอนย้ายสินค้า
            let totalAmtOut = 0;

            // คำนวณและแสดงผลรวมจำนวนสินค้าจำนวนที่โอนย้ายสินค้า
            function calculateTotalAmtOut() {
                totalAmtOut = 0;
                $('.amt_input').each(function() {
                    const val = parseFloat($(this).val());
                    if (!isNaN(val)) {
                        totalAmtOut += val;
                    }
                });
                $('.amt_total').text(totalAmtOut.toFixed(0));
                $('.total_amt_out').text(totalAmtOut.toFixed(0));
            }

            // เมื่อมีการเปลี่ยนแปลงข้อมูลในช่อง input จำนวนสินค้าจำนวนที่โอนย้ายสินค้า
            $('.amt_input').on('keyup', function() {
                calculateTotalAmtOut();
            });

            // เมื่อโหลดหน้าใหม่ให้คำนวณแสดงผลรวมตั้งแต่เริ่มต้น
            calculateTotalAmtOut();
        });

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
                    "lengthMenu": "Show _MENU_ Raw",
                    "zeroRecords": "No information",
                    "info": "Show page _PAGE_ From _PAGES_ Page",
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
                    url: '{{ route('admin/Stock_out_confirm_datatable') }}',
                    data: function(d) {
                        d.s_branch_id_fk = $('#s_branch_id_fk').val();
                        d.s_warehouse_id_fk = $('#s_warehouse_id_fk').val();
                        d.out_branch_id_fk = $('#out_branch_id_fk').val();
                        d.out_warehouse_id_fk = $('#out_warehouse_id_fk').val();
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
                        title: "สาขาต้นทาง",
                        className: "w-10 ",
                    },
                    {
                        data: "warehouse_name",
                        title: "คลังต้นทาง",
                        className: "w-10",
                    },
                    {
                        data: "branch_out_name",
                        title: "สาขาปลายทาง",
                        className: "w-10 ",
                    },
                    {
                        data: "warehouse_out_name",
                        title: "คลังปลายทาง",
                        className: "w-10",
                    },

                    {
                        data: "product_name",
                        title: "สินค้า",
                        className: "w-10",
                    },

                    {
                        data: "total_amt_out",
                        title: "จำนวนสินค้าโอนย้าย",
                        className: "w-10",

                    },

                    {
                        data: "product_unit_name",
                        title: "หน่วย",
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
