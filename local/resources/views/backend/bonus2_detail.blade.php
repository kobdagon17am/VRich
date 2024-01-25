@extends('layouts.backend.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/table/datatable/dt-global_style.css') }}">
    <link href="{{ asset('backend/assets/css/ui-elements/pagination.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/select2/select2.min.css') }}">
    <link href="{{ asset('backend/assets/css/pages/profile.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/forms/form-widgets.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-header')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">ระบบคอมมิสชั่น</li>
            <li class="breadcrumb-item active" aria-current="page"><span>ระบบคำนวน Cash Back </span></li>
            <li class="breadcrumb-item active" aria-current="page"><span>รายละเอียดสินค้า </span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow mb-4 mt-4">
            <div class="row mb-4 ml-2">
                <div class="col-lg-1 mt-2">
                    <label>Username</label>
                    <input type="taxt" class="form-control" id="username"   placeholder="Username" value="{{$user_name}}" >
                </div>


                {{-- <div class="col-lg-1 mt-2">
                    <label>รอบที่</label>
                    <select class="form-control" id="route" >
                        <option selected value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div> --}}

                <div class="col-lg-1 mt-2">
                    <label>เดือน</label>
                    <input type="taxt" class="form-control" id="month"   placeholder="month" value="{{date('m')}}">
                </div>


                <div class="col-lg-1 mt-2">
                    <label>ปี</label>
                    <input type="taxt" class="form-control" id="year"  placeholder="" value="{{date('Y')}}">
                </div>

                <div class="col-lg-2 mt-2">
                    <div class="button-list mt-4">
                        <button class="btn btn-sm btn-success btn-rounded" id="search-form" type="button">
                            <i class="las la-search font-20"></i>
                            ค้นหา</button>
                            {{-- <button class="btn  btn-sm btn-warning btn-rounded" type="submit" onclick="return confirm('Confirm Runbonus ?')"><i class="las la-plus-circle font-20"></i>
                                คำนวน</button> --}}
                    </div>

                </div>


            </div>



            <div class="table-responsive mt-2 mb-2">
                <h6>รายงาน Bonus CashBack</h6>
                <table id="table_orders" class="table table-hover" style="width:100%">

                </table>
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
                table_order = $('#table_orders').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['excel'],
                    searching: false,
                    ordering: false,
                    lengthChange: false,
                    responsive: true,
                    paging: false,
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
                        url: '{{ route('admin/datatable_casback_detail') }}',
                        data: function(d) {
                        d.username = $('#username').val();
                        d.route = 1;
                        d.month = $('#month').val();
                        d.year = $('#year').val();
                        // d.position = $('#position').val();
                        // d.type = $('#type').val();

                        },
                    },


                    columns: [
                        // {
                        //     data: "id",
                        //     title: "ลำดับ",
                        //     className: "w-10 text-center",
                        // },
                        {
                            data: "user_name",
                            title: "user_name",
                            className: "w-10",
                        },
                        {
                            data: "name",
                            title: "ชื่อ",
                            className: "w-10",
                        },

                        {
                            data: "last_name",
                            title: "นามสกุล",
                            className: "w-10",
                        },

                        {
                            data: "qualification",
                            title: "ตำแหน่ง",
                            className: "w-1",
                        },


                        {
                            data: "product_name",
                            title: "ชื่อสินค้า",
                            className: "w-1",

                        },

                        {
                            data: "amt",
                            title: "จำนวนการสั่งซื้อทั้งหมด",
                            className: "w-1",

                        },

                        {
                            data: "profit_usd",
                            title: "Profit Usd",
                            className: "w-1",

                        },

                        {
                            data: "bonus_total_usd",
                            title: "BonusTotal",
                            className: "w-1",

                        },

                        {
                            data: "type",
                            title: "Type",
                            className: "w-1",

                        },



                        {
                            data: "year",
                            title: "ปี",
                            className: "w-1",
                        },
                        {
                            data: "month",
                            title: "เดือน",
                            className: "w-1",

                        },
                        {
                            data: "route",
                            title: "รอบที่รันโบนัส",
                            className: "w-1",

                        },




                        {
                            data: "bonus_total_usd",
                            title: "ยอดที่ได้รับ USD",
                            className: "w-1",

                        },
                        {
                            data: "note",
                            title: "Note",
                            className: "w-1",

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
