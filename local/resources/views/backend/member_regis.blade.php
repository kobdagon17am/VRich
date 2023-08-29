@extends('layouts.backend.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/table/datatable/dt-global_style.css') }}">
    <link href="{{ asset('backend/assets/css/ui-elements/pagination.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/select2/select2.min.css') }}">
    <link href="{{ asset('backend/assets/css/forms/form-widgets.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('page-header')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">ระบบบริการสมาชิก</li>
            <li class="breadcrumb-item active" aria-current="page"><span>ระบบบริการสมาชิก</span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow mb-4 mt-4">
            <div class="row mb-4 ml-2">
                <div class="col-lg-1 mt-2">
                    <input type="text" class="form-control" name="upline_id" id="s_upline_id" placeholder="UPLINE">
                </div>
                <div class="col-lg-1 mt-2">
                    <span class="form-label text-danger introduce_id_err _err"></span>
                    <input type="text" class="form-control" name="introduce_id" id="s_introduce_id"
                        placeholder="ผู้แนะนำ">
                </div>
                <div class="col-lg-2 mt-2">
                    <input type="text" class="form-control" name="username" id="s_username" placeholder="รหัสสมาชิก">
                </div>
                <div class="col-lg-2 mt-2">
                    <input type="text" class="form-control" name="first_name" id="s_first_name" placeholder="ชื่อสมาชิก">
                </div>
                <div class="col-lg-2 mt-2">
                    <input type="text" class="form-control" name="id_card" id="s_id_card"
                        placeholder="หมายเลขบัตรประชาชน">
                </div>
                <div class="col-lg-2 mt-2">
                    <input type="date" class="form-control" name="regis_date_doc" id="s_regis_date_doc"
                        placeholder="วันที่อนุมัติ">
                </div>
                <div class="col-lg-2 mb-2 mt-2" style="margin-top:15px">
                    <button type="button" class="btn btn-outline-success btn-rounded" id="search-form"><i
                            class="las la-search font-15"></i>
                        สืบค้น</button>
                </div>
            </div>

            <div class="row">
                <div class="modal fade bd-example-modal-lg" id="edit" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header ml-4">
                                <h5 class="modal-title" id="myLargeModalLabel"><b>แก้ไขรหัสผ่าน</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="modal-text">
                                <div class="widget-content widget-content-area">
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="post" action="{{ route('admin/edit_password') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-6 mt-2">
                                                        <label><b>รหัสสมาชิก:</b></label>
                                                        <input type="hidden" name="id" id="id">
                                                        <input type="text" name="username" id="username"
                                                            class="form-control" placeholder="รหัสสมาชิก" disabled>
                                                    </div>
                                                    <div class="col-lg-6  mt-2">
                                                        <label><b>ชื่อ:</b></label>
                                                        <input type="text" name="fisrt_name" id="fisrt_name"
                                                            class="form-control" placeholder="ชื่อ" disabled>
                                                    </div>
                                                    <div class="col-lg-6  mt-2">
                                                        <label><b>นามสกุล:</b></label>
                                                        <input type="text" name="last_name" id="last_name"
                                                            class="form-control" placeholder="นามสกุล" disabled>
                                                    </div>
                                                    <div class="col-lg-6  mt-2">
                                                        <label><b>หมายเลขบัตรประชาชน:</b></label>
                                                        <input type="text" name="id_card" id="id_card"
                                                            class="form-control" placeholder="หมายเลขบัตรประชาชน"
                                                            disabled>
                                                    </div>
                                                    <div class="col-lg-6  mt-2">
                                                        <label><b>รหัสผ่านใหม่:</b></label>
                                                        <input type="text" name="password_new" id="password_new"
                                                            class="form-control" placeholder="รหัสผ่านใหม่" required>
                                                    </div>
                                                    <div class="col-lg-6  mt-2">
                                                        <label><b>ยืนยันรหัสผ่านใหม่:</b></label>
                                                        <input type="text" name="password_new_confirm"
                                                            id="password_new_confirm" class="form-control"
                                                            placeholder="ยืนยันรหัสผ่านใหม่" required>
                                                    </div>
                                                    <div class="info-area col-md-12 text-center mt-4 ">
                                                        <button type="submit" class="btn btn-info btn-rounded">
                                                            <i class="las la-save"></i>
                                                            แก้ไขรหัสผ่าน</button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="modal fade bd-example-modal-lg" id="cancel_member" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header ml-4">
                                <h5 class="modal-title" id="myLargeModalLabel"><b>ยกเลิกรหัสสมาชิก</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="modal-text">
                                <div class="widget-content widget-content-area">
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="post" action="{{ route('admin/cancel_member') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-6 mt-2">
                                                        <label><b>รหัสสมาชิก:</b></label>
                                                        <input type="hidden" name="id" id="id_cancel">
                                                        <input type="text" name="username" id="username_cancel"
                                                            class="form-control" placeholder="รหัสสมาชิก" disabled>
                                                    </div>
                                                    <div class="col-lg-6  mt-2">
                                                        <label><b>ชื่อ:</b></label>
                                                        <input type="text" name="fisrt_name" id="fisrt_name_cancel"
                                                            class="form-control" placeholder="ชื่อ" disabled>
                                                    </div>
                                                    <div class="col-lg-6  mt-2">
                                                        <label><b>นามสกุล:</b></label>
                                                        <input type="text" name="last_name" id="last_name_cancel"
                                                            class="form-control" placeholder="นามสกุล" disabled>
                                                    </div>
                                                    <div class="col-lg-6  mt-2">
                                                        <label><b>หมายเลขบัตรประชาชน:</b></label>
                                                        <input type="text" name="id_card" id="id_card_cancel"
                                                            class="form-control" placeholder="หมายเลขบัตรประชาชน"
                                                            disabled>
                                                    </div>
                                                    <div class="info-area col-md-12 text-center mt-4 ">
                                                        <button type="submit" class="btn btn-info btn-rounded"
                                                            name="cencel_member" value="confirm">
                                                            <i class="las la-save"></i>
                                                            ยกเลิกรหัสสมาชิก</button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive mt-2 mb-2">
        <table id="basic-dt" class="table table-hover" style="width:100%">
        </table>
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

    <script src="{{ asset('frontend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/forms/custom-select2.js') }}"></script>
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
                    url: '{{ route('admin/MemberRegister_datatable') }}',
                    data: function(d) {
                        d.s_username = $('#s_username').val();
                        // console.log(s_username);
                        d.s_first_name = $('#s_first_name').val();
                        d.s_id_card = $('#s_id_card').val();
                        d.s_upline_id = $('#s_upline_id').val();
                        d.s_introduce_id = $('#s_introduce_id').val();
                        d.s_regis_date_doc = $('#s_regis_date_doc').val();

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
                        data: "username",
                        title: "รหัสสมาชิก",
                        className: "w-10 ",
                    },

                    {
                        data: "first_name",
                        title: "ชื่อ",
                        className: "w-10",
                    },

                    {
                        data: "last_name",
                        title: "นามสกุล",
                        className: "w-10",
                    },

                    {
                        data: "id_card",
                        title: "หมายเลขบัตรประชาชน",
                        className: "w-10",
                    },

                    {
                        data: "pv_all",
                        title: "คะแนน PV",
                        className: "w-10",
                    },

                    {
                        data: "upline_id",
                        title: "Upline",
                        className: "w-10",
                    },

                    {
                        data: "line_type",
                        title: "สายงาน",
                        className: "w-10",
                    },

                    {
                        data: "introduce_id",
                        title: "ผู้แนะนำ",
                        className: "w-10",
                    },

                    {
                        data: "regis_date_doc",
                        title: "วันที่อนุมัติ",
                        className: "w-10",

                    },

                    {
                        data: "customer_status",
                        title: "สถานะสมาชิก",
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

        function edit(id) {

            $.ajax({
                    url: '{{ route('admin/view_password') }}',
                    type: 'GET',
                    data: {
                        id
                    }
                })
                .done(function(data) {
                    console.log(data);
                    $("#edit").modal();
                    $("#id").val(data['data']['id']);
                    $("#username").val(data['data']['username']);
                    $("#first_name").val(data['data']['first_name']);
                    $("#last_name").val(data['data']['last_name']);
                    $("#id_card").val(data['data']['id_card']);

                })
                .fail(function() {
                    console.log("error");
                })
        }

        function cancel_member(id) {

            $.ajax({
                    url: '{{ route('admin/view_member_data') }}',
                    type: 'GET',
                    data: {
                        id
                    }
                })
                .done(function(data) {
                    console.log(data);
                    $("#cancel_member").modal();
                    $("#id_cancel").val(data['data']['id']);
                    $("#username_cancel").val(data['data']['username']);
                    $("#fisrt_name_cancel").val(data['data']['first_name']);
                    $("#last_name_cancel").val(data['data']['last_name']);
                    $("#id_card_cancel").val(data['data']['id_card']);

                })
                .fail(function() {
                    console.log("error");
                })
        }
    </script>
@endsection
