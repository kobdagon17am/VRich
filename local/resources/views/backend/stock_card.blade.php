@extends('layouts.backend.app')
@section('css')
@endsection
@section('page-header')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">ระบบคลัง</li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin/Stock_report') }}">รายงานคลังสินค้า</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><span>STOCK CARD</span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow mb-4">
                <div class="widget-content widget-content-area">
                    <div style="text-align: left;">
                        <h5><b>STOCK CARD : {{ $get_stock_movement->lot_number }}</b></h6>
                            <h6><b>ยอดคงเหลือ : {{ $get_stock_movement->lot_balance }}</b></h6>
                    </div>

                    <div class="table-responsive mt-4 mb-2">
                        <h6>รายงานการเคลื่อนไหวสต๊อกสินค้า</h6>
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
                    url: '{{ route('admin/Stock_card_datatable') }}',
                    data: function(d) {
                        d.s_branch_id_fk = {{$get_stock_movement->branch_id_fk}};
                        d.s_warehouse_id_fk = {{$get_stock_movement->warehouse_id_fk}};
                        d.s_product_id_fk = {{$get_stock_movement->product_id_fk}};
                        d.s_lot_number = '{{$get_stock_movement->lot_number}}';

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
                        data: "code_order",
                        title: "รหัสสั่งซื้อ",
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


                    // {
                    //     data: "action",
                    //     title: "Action",
                    //     className: "w-10",
                    // },



                ],



            });
            // $('#search-form').on('click', function(e) {
            //     table_order.draw();
            //     e.preventDefault();
            // });

        });
    </script>
@endsection

