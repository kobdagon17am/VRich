@extends('layouts.backend.app')
@section('css')
@endsection
@section('page-header')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">ระบบคลัง</li>
            <li class="breadcrumb-item active" aria-current="page"><span>รายงานคลังสินค้า</span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow mb-4">
                <div class="widget-content widget-content-area">

                    <div class="row mb-4">
                        <div class="col-lg-2 mb-2 text-left">
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
                        <div class="col-lg-2 mb-2 text-left">
                            <span class="form-label text-danger warehouse_id_fk_err _err"></span>
                            <select class="form-control warehouse_select" name="warehouse_id_fk" id="s_warehouse_id_fk">
                                <option selected disabled> เลือกคลังสินค้า
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
                        <div class="col-lg-2 mb-2 text-left">
                            <select class="form-control" name="lot_number" id="s_lot_number">
                                <option selected disabled> เลือกหมายเลขล๊อต
                                </option>
                                @foreach ($get_stock_lot as $val)
                                    <option value="{{ $val->lot_number }}">
                                        {{ $val->lot_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 mb-2 text-left" style="margin-top:25x">
                            <button type="button" class="btn btn-outline-success btn-rounded" id="search-form"><i
                                    class="las la-search font-15"></i>
                                สืบค้น</button>
                        </div>
                    </div>
                    <h6>รายงานการเคลื่อนไหวสต๊อกสินค้า</h6>
                    <div class="table-responsive mt-2 mb-2">
                        <table id="basic-dt" class="table table-hover" style="width:100%">

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
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
                    url: '{{ route('admin/Stock_report_datatable') }}',
                    data: function(d) {
                        d.s_branch_id_fk = $('#s_branch_id_fk').val();
                        d.s_warehouse_id_fk = $('#s_warehouse_id_fk').val();
                        d.s_product_name = $('#s_product_name').val();
                        d.s_lot_number = $('#s_lot_number').val();

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
                        data: "lot_number",
                        title: "หมายเลขล๊อต",
                        className: "w-10",
                    },

                    {
                        data: "amt",
                        title: "จำนวนสินค้า",
                        className: "w-10",

                    },

                    {
                        data: "lot_balance",
                        title: "จำนวนสินค้าคงเหลือ",
                        className: "w-10",

                    },


                    {
                        data: "product_unit_name",
                        title: "หน่วย",
                        className: "w-10",

                    },

                    {
                        data: "stock_type",
                        title: "รายการเคลื่อนไหวสินค้า",
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
