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
            <li class="breadcrumb-item">จัดการการขาย</li>
            <li class="breadcrumb-item active" aria-current="page"><span>รายการคำสั่งซื้อ</span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow mb-4 mt-4">

            <div class="row mb-4 ml-2">
                <div class="col-lg-2 mt-2">
                    <label>วันที่เริ่มต้น</label>
                    <input type="date" class="form-control  myCustom date_start" name="date_start" placeholder="วันที่เริ่มต้น" value="{{date('Y-m-d')}}">
                </div>

                <div class="col-lg-2 mt-2">
                    <label>วันที่สิ้นสุด</label>
                    <input type="date" class="form-control  myCustom date_end" name="date_end" placeholder="วันที่สิ้นสุด" value="{{date('Y-m-d')}}">
                </div>

                <div class="col-lg-2 mt-2">
                    <label>Code Order</label>
                    <input type="taxt" class="form-control  myCustom code_order" name="code_order" placeholder="Code Order">
                </div>

                <div class="col-lg-2 mt-2">
                    <label>ประเภทการสั่งซื้อ</label>
                    <select class="form-control myWhere type" name="type" id="type">
                        <option selected="" value=""> ทั้งหมด </option>
                        <option value="other">ทั่วไป</option>
                        <option value="promotion">โปรโมชั่น</option>
                        <option value="send_stock">StockMember</option>
                    </select>
                </div>

                <div class="col-lg-4 mb-2 " style="margin-top: 42px">
                    {{-- <button type="button" class="btn btn-outline-success btn-rounded" id="search-form"><i class="las la-search font-15"></i>
                        สืบค้น</button> --}}

                        {{-- <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary btn-rounded btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ออกใบปะหน้า <i class="las la-angle-down"></i></button>
                            <div class="dropdown-menu" style="will-change: transform;">
                                <a class="dropdown-item report_pdf" data-type="all" href="#">All</a>

                            </div>

                        </div>
                        <div class="btn-group">
                        <a type="button" class="btn btn-outline-primary btn-rounded btn-sm all_bill " target="_blank" >ใบรายละเอียดสินค้าหลายใบ </a>

                        </div> --}}

                </div>



                   {{-- <div class="col-lg-2 mb-2 mt-2" style="margin-top:15px">
                    <select class="form-control myWhere" name="status">
                        <option value="0">ทั้งหมด</option>
                        <option selected value="1">รออนุมัติ</option>
                        <option value="2">อนุมัติ</option>
                        <option value="3">ไม่อนุมัติ</option>
                    </select>


                </div> --}}
            </div>


         <div class="modal fade bd-example-modal-lg" id="updatestatus" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form method="post" action="{{ route('admin/orders/tracking_no') }}">
                        @csrf
                        <div class="modal-content">
                            <!-- BEGIN: Modal Header -->
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">อัพเดทรหัสจัดส่งสินค้า</h2>
                            </div>
                            <!-- END: Modal Header -->
                            <!-- BEGIN: Modal Body -->

                            <div class="modal-body">
                                <div class="row col-md-12">
                                    <div class="col-md-4 col-lg-4">
                                        <label for="modal-form-1" class="form-label">รหัส</label>
                                        <input id="code_order" name="code_order" readonly type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <label for="modal-form-2" class="form-label">รหัสจัดส่งสินค้า</label>
                                        <input id="tracking_no" name="tracking_no" type="text" required class="form-control">
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <label for="modal-form-6" class="form-label">ขนส่ง</label>

                                        <select class="form-control" name="tracking_type"
                                        id="tracking_type">
                                        <option value="EMS">EMS</option>
                                        <option value="Kerry">Kerry</option>
                                    </select>
                                    </div>
                                    <input type="hidden" name="page_type" value="success">

                                </div>

                            </div>



                            <!-- END: Modal Body -->
                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" data-tw-dismiss="modal"
                                    class="btn btn-outline-secondary w-20 mr-1" data-dismiss="modal">ยกเลิก</button>
                                <button type="submit" class="btn btn-primary w-20">บันทึก</button>
                            </div>
                            <!-- END: Modal Footer -->
                        </div>
                    </form>
                </div>
            </div>


            <div class="table-responsive mt-2 mb-2">
                <h6>รายการคำสั่งซื้อ</h6>
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
        function printErrorMsg(msg) {
            console.log(msg);
            $('._err').text('');
            $.each(msg, function(key, value) {
                $('.' + key + '_err').text(`*${value}*`);
            });
        }
    </script>


    <script>
        $('.report_pdf').click(function() {
            let type = $(this).data('type');
            let date_start = $('.date_start').val();
            let date_end = $('.date_end').val();



            if (date_start == '' && date_end == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณาเลือก',
                    text: 'วันที่เริ่มต้น วันที่สิ้นสุด',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ปิด',
                })
            } else {



                // บน serve ใช้อันนี้
                // let path = `/demo/admin/orders/report_order_pdf/${type}/${date_start}/${date_end}`

                // local
                var url = '{{ asset('') }}';
                let full_url = url+`admin/orders/report_order_pdf/${type}/${date_start}/${date_end}`


                window.open(`${full_url}`);
            }



        });
    </script>




    <script>
        $('.tracking_no_sort').click(function() {
            let date_start = $('.date_start').val();
            let date_end = $('.date_end').val();

            if (date_start == '' && date_end == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณาเลือก',
                    text: 'วันที่เริ่มต้น วันที่สิ้นสุด',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ปิด',
                })
            } else {

                Swal.fire({
                        title: 'รอสักครู่...',
                        html: 'ระบบกำลังประมวลผล',
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    }),

                    $.ajax({
                        url: "{{ route('admin/orders/tracking_no_sort') }}",
                        type: 'post',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'date_start': date_start,
                            'date_end': date_end
                        },
                        success: function(data) {
                            Swal.close();
                            Swal.fire({
                                icon: 'success',
                                title: 'ทำรายการสำเร็จ',
                                text: '',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'ปิด',
                            })
                        }

                    });
            }
        });
    </script>


    <script>
        $('.all_bill').click(function() {


            let date_start = $('.date_start').val();
            let date_end = $('.date_end').val();

            if (date_start == '' && date_end == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณาเลือก',
                    text: 'วันที่เริ่มต้น วันที่สิ้นสุด',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ปิด',
                })
            } else {
                Swal.fire({
                        title: 'รอสักครู่...',
                        html: 'ระบบกำลังเตรียมไฟล์ PDF...',
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    }),

                    $.ajax({
                        url: "{{ route('admin/orders/view_detail_oeder_pdf') }}",
                        type: 'post',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'date_start': date_start,
                            'date_end': date_end
                        },
                        success: function(data) {
                            Swal.close();
                            var url = '{{ asset('') }}';
                            const path = url+'local/public/pdf/result.pdf';
                            window.open(path, "_blank");


                        }
                    });
            }

        });
    </script>



    <script>
        $('.orderexport').click(function() {

            let date_start = $('.date_start').val();
            let date_end = $('.date_end').val();


            if (date_start == '' && date_end == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณาเลือก',
                    text: 'วันที่เริ่มต้น วันที่สิ้นสุด',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ปิด',
                })
            } else {
                // บน Demo
                const path = '/demo/admin/orderexport' + '/' + date_start + '/' + date_end;
                // const path = '/mlm/admin/orderexport' + '/' + date_start + '/' + date_end;
                window.open(path, "_blank");
            }

        });
    </script>


    <script>
        $('#importorder').submit(function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);

            Swal.fire({
                    title: 'รอสักครู่...',
                    html: 'ระบบกำลังประมวลผล',
                    didOpen: () => {
                        Swal.showLoading()
                    },
                }),

                $.ajax({
                    url: '{{ route('admin/orders/importorder') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {

                        var error_excel = data.error_excel;
                        var error_msg = data.error;

                        if (data.status == "success") {
                            Swal.close();
                            Swal.fire({
                                icon: 'success',
                                title: `บันทึกข้อมูลเรียบร้อย`,
                                confirmButtonColor: '#84CC18',
                                confirmButtonText: 'ยืนยัน',
                                timer: 3000,
                            }).then((result) => {
                                if (result.value) {
                                    window.location.reload();
                                }
                            });
                        }

                        if (error_msg) {
                            Swal.close();
                            printErrorMsg(data.error);
                        }
                        if (error_excel) {
                            error_modal(error_excel);

                        }

                    }
                });
        });
    </script>



    <script>
        function error_modal(data) {
            var ms = [];
            data.forEach((val, key) => {
                ms += `<p class="text-left ml-5" >แถวที่ ${val.row} : ${val.error}</p>`
            });

            Swal.fire({
                icon: 'error',
                title: `ข้อมูลไม่ครบถ้วน`,
                html: `${ms}`,
                confirmButtonColor: '#84CC18',
                confirmButtonText: 'ยืนยัน',
            }).then((result) => {
                if (result.value) {
                    window.location.reload();
                }
            });
        }
    </script>

<script>
    $(function() {
        table_orders = $('#table_orders').DataTable({
            searching: false,
            ordering: false,
            lengthChange: false,
            pageLength: 10,
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
                url: '{{ route('admin/orders/get_data_order_list_success') }}',
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
                    className: "table-report__action w-10 text-center",
                },
                {
                    data: "code_order",
                    title: "รหัส",
                    className: "table-report__action w-10 text-center whitespace-nowrap",
                },
                {
                    data: "customers_user_name",
                    title: "รหัสผู้สั่งซื้อ",
                    className: "table-report__action w-10 text-center whitespace-nowrap",
                },
                {
                    data: "name",
                    title: "ผู้สั่งซื้อ",
                    className: "table-report__action  text-center whitespace-nowrap",
                },
                {
                    data: "pay_type",
                    title: "รูปแบบการชำระเงิน",
                    className: "table-report__action  text-center whitespace-nowrap",
                },
                {
                    data: "total_price",
                    title: "จำนวนเงิน",
                    className: "table-report__action  text-right whitespace-nowrap",
                },
                {
                    data: "created_at",
                    title: "วันที่สั่งซื้อ",
                    className: "table-report__action  text-center whitespace-nowrap",
                },
                {
                    data: "detail",
                    title: "สถานะ",
                    className: "table-report__action  text-center whitespace-nowrap",
                },
                {
                    data: "type",
                    title: "ประเภท",
                    className: "table-report__action  text-center whitespace-nowrap",
                },
                {
                    data: "id",
                    title: "Tracking no",
                    className: "table-report__action text-center",
                },

                {
                    data: "id",
                    title: "",
                    className: "table-report__action text-center",
                },


            ],
            rowCallback: function(nRow, aData, dataIndex) {

                //คำนวนลำดับของ รายการที่แสดง
                var info = table_orders.page.info();
                var page = info.page;
                var length = info.length;
                var index = (page * length + (dataIndex + 1));

                var id = aData['id'];

                //แสดงเลขลำดับ
                $('td:nth-child(1)', nRow).html(`${index}`);


                //แสดงสถานะ
                var status = aData['detail'];
                var css_class = aData['css_class'];
                $('td:nth-last-child(4)', nRow).html(
                    ` <p class="text-${css_class}"> ${status} </p> `);

                // Action
                var code_order = aData['code_order'];
                var tracking_no = aData['tracking_no'];
                $('td:nth-last-child(2)', nRow).html(
                    `<a   onclick="updatestatus('${code_order}')" class="btn btn-sm btn-success mr-2"> ${tracking_no} </a>`
                );
                // $('td:nth-last-child(2)', nRow).html(
                //     `<a  onclick="view_detail_oeder('${code_order}')" class="btn btn-sm btn-warning mr-2 "> Print </a>`
                // );
                $('td:nth-last-child(1)', nRow).html(
                    `<a  onclick="view_detail_oeder_pdf('${code_order}')" class="btn btn-sm btn-success mr-2"> Print </a>`
                );


            },
        });
        $('.myWhere,.myLike,.datepicker,.iSort,.myCustom').on('change', function(e) {
            table_orders.draw();
        });
    });



    function view_detail_oeder(code_order) {

        window.open(`view_detail_oeder/${code_order}`)
    }

    function updatestatus(code_order) {
        $('#code_order').val(code_order);
        $('#tracking_no').val('');

        $("#updatestatus").modal();


    }




    function view_detail_oeder_pdf(code_order) {

        // table_orders.draw();
        Swal.fire({
                title: 'รอสักครู่...',
                html: 'ระบบกำลังเตรียมไฟล์ PDF...',
                didOpen: () => {
                    Swal.showLoading()
                },
            }),

            $.ajax({
                url: "{{ route('admin/orders/view_detail_oeder_pdf_success') }}",
                type: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'code_order': code_order
                },
                success: function(data) {
                    Swal.close();
                    // บน serve ใช้อันนี้
                    var url = '{{ asset('') }}';
                    let full_url = url + 'local/public/pdf/result.pdf';

                    console.log(full_url);
                    // local
                    // let full_url = '/mlm/local/public/pdf/result.pdf';

                    window.open(full_url);


                }

            });




    }
</script>

@endsection
