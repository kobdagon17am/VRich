@extends('layouts.backend.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/table/datatable/dt-global_style.css') }}">
    <link href="{{ asset('backend/assets/css/ui-elements/pagination.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/select2/select2.min.css') }}">
    <link href="{{ asset('backend/assets/css/forms/form-widgets.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/forms/radio-theme.css') }}" rel="stylesheet" type="text/css">

@endsection
@section('page-header')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            กระเป๋าเงิน

            <li class="breadcrumb-item">กระเป๋าเงิน</li>
            <li class="breadcrumb-item active" aria-current="page"><span>รายการฝากเงิน</span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow mb-4 mt-4">
            <div class="row mb-4 ml-2">
                <div class="col-lg-1 mt-2">
                    <input type="text" class="form-control" name="transaction_code" placeholder="รหัสรายการ">
                </div>
                <div class="col-lg-1 mt-2">
                    <span class="form-label text-danger introduce_id_err _err"></span>
                    <input type="text" class="form-control" name="introduce_id" id="s_introduce_id"
                        placeholder="ผู้แนะนำ">
                </div>
                <div class="col-lg-2 mt-2">
                    <input type="text" class="form-control" name="user_name" placeholder="รหัสสมาชิก">
                </div>
                <div class="col-lg-2 mt-2">
                    <input type="text" class="form-control" name="customers.name" placeholder="ชื่อสมาชิก">
                </div>


                <div class="col-lg-2 mb-2 mt-2" style="margin-top:15px">
                    <select class="form-control myWhere" name="status">
                        <option value="0">ทั้งหมด</option>
                        <option selected value="1">รออนุมัติ</option>
                        <option value="2">อนุมัติ</option>
                        <option value="3">ไม่อนุมัติ</option>
                    </select>


                </div>
            </div>

            <div class="row">
                <div class="modal fade bd-example-modal-lg" id="info_ewallet" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header ml-4">
                                <h5 class="modal-title" id="myLargeModalLabel"><b> รายการ ฝากเงิน</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="modal-text">
                                <div class="widget-content widget-content-area">

                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">

                                            <div class="row">
                                                <div class="col-lg-6 mt-2">

                                                    <p class="mt-2 text-left">รหัสรายการ <span id="transaction_code"></span>
                                                    </p>
                                                    <p class="mt-2 text-left">วันที่ทำรายการ <span
                                                            id="ewallet_created_at"></span>
                                                    </p>
                                                    <P class="mt-2 text-left">สมาชิก <span id="name"></span> </P>
                                                    <p class="text-xl mt-2 type"> จำนวนเงินฝาก <span
                                                            class="text-danger amt"></span>
                                                        บาท</p>
                                                    <img src="..." class="img-fluid img_doc_info"
                                                        alt="Responsive image">
                                                </div>
                                                <div class="col-lg-6 mt-2 box_info">
                                                    <form id="form_approve" action="{{route('admin/approve_update_ewallet')}}" method='POST'>

                                                        @csrf
                                                        <input type="hidden" class="ewallet_id" name="ewallet_id"
                                                            value="">
                                                        <input type="hidden" id="amt" name="amt" value="">
                                                        <input type="hidden" id="customers_id_fk" name="customers_id_fk"
                                                            value="">


                                                        <div class="col-lg-12  mt-2">

                                                            <label><b>วันที่โอน:</b></label>
                                                            <input class="form-control" type="date" id="date"
                                                                name="date" required>
                                                            <span class="text-danger date_err _err"></span>
                                                        </div>

                                                        <div class="col-lg-12  mt-2">

                                                            <label><b>เวลาโอน:</b></label>
                                                            <input class="form-control" type="time" id="time"
                                                                name="time" required>
                                                            <span class="text-danger time_err _err"></span>
                                                        </div>

                                                        <div class="col-lg-12  mt-2">

                                                            <label><b>เลขที่อ้างอิง:</b></label>
                                                            <input class="form-control" type="text"
                                                                placeholder="เลขที่อ้างอิง" id="code_refer"
                                                                name="code_refer" required>

                                                        </div>

                                                        <div class="col-lg-12  mt-2">

                                                            <label><b>แก้ไขยอดเงิน:</b></label>
                                                            <input class="form-control" type="text" id="edit_amt"
                                                                placeholder="แก้ไขยอดเงิน" name="edit_amt">
                                                        </div>
                                                        <div class="col-lg-12  mt-2 text-center">

                                                            <button type="submit" class="btn btn-info btn-rounded">
                                                                <i class="las la-save"></i> อนุมัติ eWallet</ิ>
                                                        </div>


                                                    </form>
                                                    <div class="col-lg-12   mt-2">
                                                    <form id="form_disapproved" action="{{route('admin/disapproved_update_ewallet')}}" method='POST' class="form">
                                                        @csrf
                                                        <input type="hidden" class="ewallet_id" name="ewallet_id"
                                                            value="">

                                                            <div class="col-md-12 col-lg-12">


                                                                <div class="form-group mb-4">
                                                                    <label>ยกเลิกรายการ</label>
                                                                    <div class="radio-inline">
                                                                        <label class="radio">
                                                                        <input type="radio" name="vertical_radio_button" value="ใช้ Slip ซ้ำ">
                                                                        <span></span>ใช้ Slip ซ้ำ</label>
                                                                        <label class="radio">
                                                                        <input type="radio" name="vertical_radio_button" value="ไม่ใช่บัญชีบริษัท">
                                                                        <span></span> ไม่ใช่บัญชีบริษัท</label>
                                                                        <label class="radio">
                                                                        <input type="radio" name="vertical_radio_button" value="ภาพไม่ชัด">
                                                                        <span></span> ภาพไม่ชัด</label>

                                                                        <label class="radio">
                                                                        <input type="radio" name="vertical_radio_button" value="ไม่ใช้ภาพ Slip">
                                                                        <span></span> ไม่ใช้ภาพ Slip</label>

                                                                        <label class="radio">
                                                                        <input type="radio" name="vertical_radio_button" value="อื่นๆ">
                                                                        <span></span>อื่นๆ</label>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="exampleTextarea">รายละเอียด</label>
                                                                    <textarea class="form-control" name="info_other" id="info_other" placeholder="รายละเอียด..." rows="3"></textarea>
                                                                </div>



                                                            </div>


                                                            <div class="col-lg-12  mt-2 text-center">

                                                                <button type="submit"  class="btn btn-danger btn-rounded">
                                                                    <i class="las la-save"></i>ไม่อนุมัติ</button>
                                                            </div>



                                                    </form>
                                                    </div>

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

                <div class="table-responsive mt-2 mb-2">
                    <table id="table_ewallet" class="table table-hover" style="width:100%">
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

        <script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/forms/custom-select2.js') }}"></script>
        <script>
            function get_data_info_ewallet(id) {
                $.ajax({
                    url: '{{ route('admin/get_info_ewallet') }}',
                    method: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id
                    },
                    success: function(data) {
                        create_info_modal(data)
                    }
                });
            }

            function create_info_modal(data) {


                $('#date').val('');
                $('#time').val('');
                $('#code_refer').val('');
                $('#edit_amt').val('');

                $('#info_ewallet').find('.box_info').show();
                data.data.forEach((val, key) => {

                    if (val.type == 1) {
                        $('#img_doc').show()
                        $('.h2').html('รายการ ฝากเงิน')
                        $('.type').html('จำนวนเงินฝาก <span class="text-danger amt"></span> บาท')
                        $('.ewallet_id').val(val.ewallet_id);
                        $('#customers_id_fk').val(val.customers_id_fk);
                        $('#amt').val(val.amt);

                        $('#transaction_code').text(val.transaction_code);
                        $('#ewallet_created_at').text(val.ewallet_created_at);
                        $('#name').text(val.name);
                        $('.amt').text(data.data_amt);
                        $(".img_doc_info").attr("src", `{{ asset('') }}/${val.url}/${val.file_ewllet}`);


                        if (val.status != 1) {
                            $('#info_ewallet').find('.box_info').hide();
                        }
                    } else if (val.type == 2) {
                        $('#img_doc').hide()
                        $('.h2').html('รายการ โอนเงิน')
                        $('.type').html('จำนวนเงินโอน <span class="text-danger amt"></span> บาท')
                        $('.ewallet_id').val(val.ewallet_id);
                        $('#customers_id_fk').val(val.customers_id_fk);
                        $('#amt').val(val.amt);

                        $('#transaction_code').text(val.transaction_code);
                        $('#ewallet_created_at').text(val.ewallet_created_at);
                        $('#name').text(val.name);
                        $('.amt').text(data.data_amt);
                        $(".img_doc_info").attr("src", `{{ asset('') }}/${val.url}/${val.file_ewllet}`);
                        if (val.status != 1) {
                            $('#info_ewallet').find('.box_info').hide();
                        }
                    } else if (val.type == 3) {
                        $('#img_doc').hide()
                        $('.h2').html('รายการ ถอนเงิน')
                        $('.type').html('จำนวนเงินถอน <span class="text-danger amt"></span> บาท')
                        $('.ewallet_id').val(val.ewallet_id);
                        $('#customers_id_fk').val(val.customers_id_fk);
                        $('#amt').val(val.amt);

                        $('#transaction_code').text(val.transaction_code);
                        $('#ewallet_created_at').text(val.ewallet_created_at);
                        $('#name').text(val.name);
                        $('.amt').text(data.data_amt);
                        $(".img_doc_info").attr("src", `{{ asset('') }}/${val.url}/${val.file_ewllet}`);
                        if (val.status != 1) {
                            $('#info_ewallet').find('.box_info').hide();
                        }
                    }
                });
            }
        </script>



        <script>
            function printErrorMsg(msg) {
                $('._err').text('');
                $.each(msg, function(key, value) {
                    let class_name = key.split(".").join("_");
                    $('.' + class_name + '_err').text(`*${value}*`);
                });
            }
        </script>




        <script>
            $(function() {
                table_ewallet = $('#table_ewallet').DataTable({
                    searching: false,

                    lengthChange: false,
                    responsive: true,
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
                        url: '{{ route('admin/get_ewallet') }}',
                        data: function(d) {
                            d.Where = {};

                            $('.myWhere').each(function() {
                                if ($.trim($(this).val()) && $.trim($(this).val()) != '0') {
                                    d.Where[$(this).attr('name')] = $.trim($(this).val());
                                    if ($('#Search').val() == '') $('#btn-Excel').css("display",
                                        "initial");
                                }
                            });
                            d.Like = {};
                            $('.myLike').each(function() {
                                if ($.trim($(this).val()) && $.trim($(this).val()) != '0') {
                                    d.Like[$(this).attr('name')] = $.trim($(this).val());
                                }
                            });
                            d.Custom = {};
                            $('.myCustom').each(function() {
                                if ($.trim($(this).val()) && $.trim($(this).val()) != '0' && $(this)
                                    .attr('type') != 'checkbox') {
                                    d.Custom[$(this).attr('name')] = $.trim($(this).val());
                                }
                                if ($.trim($(this).val()) && $.trim($(this).val()) != '0' && $(this)
                                    .is(':checked')) {
                                    d.Custom[$(this).attr('name')] = $.trim($(this).val());
                                }
                            });
                        },
                    },
                    columns: [{
                            data: "id",
                            title: "ลำดับ",
                            className: "table-report__action text-center",
                        },
                        {
                            data: "transaction_code",
                            title: "รหัสรายการ",
                            className: "table-report__action whitespace-nowrap",
                        },
                        {
                            data: "created_at",
                            title: "วันที่ทำรายการ",
                            className: "table-report__action text-center whitespace-nowrap",
                        },
                        {
                            data: "user_name",
                            title: "รหัสสมาชิก",
                            className: "table-report__action whitespace-nowrap",
                        },

                        {
                            data: "customers_name",
                            title: "ชื่อสมาชิก",
                            className: "table-report__action whitespace-nowrap",
                        },
                        {
                            data: "amt",
                            title: "จำนวนเงิน",
                            className: "table-report__action text-right whitespace-nowrap",
                        },
                        {
                            data: "edit_amt",
                            title: "จำนวนเงินที่แก้ไข",
                            className: "table-report__action text-right whitespace-nowrap",
                        },
                        {
                            data: "note_orther",
                            title: "รายละเอียด",
                            className: "table-report__action",
                        },
                        {
                            data: "type",
                            title: "ประเภท",
                            className: "table-report__action text-center",
                        },
                        {
                            data: "status",
                            title: "สถานะ",
                            className: "table-report__action text-center whitespace-nowrap",
                        },
                        {
                            data: "date_mark",
                            title: "วันที่อนุมัติ",
                            className: "table-report__action text-center whitespace-nowrap",
                        },
                        {
                            data: "ew_mark",
                            title: "ผู้อนุมัติ",
                            className: "table-report__action text-center whitespace-nowrap",
                        },
                        {
                            data: "id",
                            title: "",
                            className: "table-report__action text-center",
                        },


                    ],
                    order: [
                        [1, 'DESC']
                    ],
                    rowCallback: function(nRow, aData, dataIndex) {
                        //คำนวนลำดับของ รายการที่แสดง
                        var info = table_ewallet.page.info();
                        var page = info.page;
                        var length = info.length;
                        var index = (page * length + (dataIndex + 1));
                        var id = aData['id'];

                        // แสดงเลขลำดับ
                        $('td:nth-child(1)', nRow).html(`${index}`);


                        //สถานะ

                        var status = aData['status'];
                        var text_status = "";
                        var status_bg = "";



                        if (status == 1) {
                            text_status = "รออนุมัติ"
                            status_bg = "text-warning"

                        }
                        if (status == 2) {
                            text_status = "อนุมัติ"
                            status_bg = "text-success"

                        }
                        if (status == 3) {
                            text_status = "ไม่อนุมัติ"
                            status_bg = "text-danger"
                        }


                        var edit_amt = aData['edit_amt'];
                        $('td:nth-child(8)', nRow).html(
                            ` <div class="text-warning">${edit_amt} </div> `
                        );
                        var type_note = aData['type_note'];
                        $('td:nth-child(10)', nRow).html(
                            ` <div class="${status_bg}"> ${text_status} ${type_note == null ? '': `(${type_note})` } </div> `
                        );

                        //Action
                        $('td:nth-last-child(1)', nRow).html(
                            `
                                <a  data-toggle="modal" data-target="#info_ewallet"  onclick="get_data_info_ewallet(${id})" class="p-2">
                                    <i class="lab la-whmcs font-25 text-warning"></i></a>
                                `
                        );
                    },
                });
                $('.myWhere,.myLike,.datepicker,.iSort,.myCustom').on('change', function(e) {
                    table_ewallet.draw();
                });
            });
        </script>
    @endsection
