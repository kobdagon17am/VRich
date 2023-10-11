<style>
    .img_doc_info {
        width: 90%;
        height: 90%;
    }
</style>

@extends('layouts.frontend.app')
@section('conten')
    <div class="bg-whiteLight page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active text-truncate" aria-current="page">History Stock</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{-- <div class="card card-box borderR10 mb-3">
                        <div class="card-body">
                            <h4 class="card-title">ค้นหา</h4>
                            <hr>
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-3">
                                    <label for="" class="form-label">รหัสการดำเนินการ</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6 col-lg-2">
                                    <label for="" class="form-label">สถานะ</label>
                                    <select class="form-select" id="">
                                        <option>ทั้งหมด</option>
                                        <option>รออนุมัติ</option>
                                        <option>อนุมัติ</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-2">
                                    <label for="" class="form-label">วันที่เริ่มต้น</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-6 col-lg-2">
                                    <label for="" class="form-label">วันที่สิ้นสุด</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-6 col-lg-2">
                                    <label for="" class="form-label">ประเถทการดำเนินการ</label>
                                    <select class="form-select" id="">
                                        <option>ทั้งหมด</option>
                                        <option>ฝากเงิน</option>
                                        <option>โอนเงิน</option>
                                        <option>ถอนเงิน</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-lg-1">
                                    <label for="" class="form-label d-none d-md-block">&nbsp;</label>
                                    <button type="button" class="btn btn-dark rounded-circle btn-icon"><i
                                            class="bx bx-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="card card-box borderR10 mb-2 mb-md-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="card-title mb-0">History Stock </h4>
                                </div>
                                {{-- <div class="col-sm-6 text-md-end">
                                    <button type="button" class="btn btn-info rounded-pill"><i
                                            class='bx bxs-file me-1'></i> Report</button>
                                </div> --}}
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table id="workL" class="table table-bordered"></table>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('script')
    <script>
        $('.page-content').css({
            'min-height': $(window).height() - $('.navbar').height()
        });
    </script>
    <script>
        $(document).ready(function() {
            $(function() {
                table_ewallet = $('#workL').DataTable({
                    lengthChange: false,
                    pageLength: 20,
                    processing: true,
                    serverSide: true,
                    responsive: true,

                    "language": {
                        "lengthMenu": "แสดง _MENU_ แถว",
                        "zeroRecords": "ไม่พบข้อมูล",
                        "info": "แสดงหน้า _PAGE_ จาก _PAGES_ หน้า",
                        "search": "Search",
                        "infoEmpty": "",
                        "infoFiltered": "",
                        "paginate": {
                            "first": "First",
                            "previous": "Previous",
                            "next": "Next",
                            "last": "Last"
                        },
                        'processing': "Loading",
                    },
                    ajax: {
                        url: '{{ route('Stock-history-datatable') }}',
                        data: function(d) {
                            d.Where = {};

                            $('.myWhere').each(function() {
                                if ($.trim($(this).val()) && $.trim($(this).val()) !=
                                    '0') {
                                    d.Where[$(this).attr('name')] = $.trim($(this)
                                        .val());
                                    if ($('#Search').val() == '') $('#btn-Excel').css(
                                        "display",
                                        "initial");
                                }
                            });
                            d.Like = {};
                            $('.myLike').each(function() {
                                if ($.trim($(this).val()) && $.trim($(this).val()) !=
                                    '0') {
                                    d.Like[$(this).attr('name')] = $.trim($(this)
                                        .val());
                                }
                            });
                            d.Custom = {};
                            $('.myCustom').each(function() {
                                if ($.trim($(this).val()) && $.trim($(this).val()) !=
                                    '0' && $(this)
                                    .attr('type') != 'checkbox') {
                                    d.Custom[$(this).attr('name')] = $.trim($(this)
                                        .val());
                                }
                                if ($.trim($(this).val()) && $.trim($(this).val()) !=
                                    '0' && $(this)
                                    .is(':checked')) {
                                    d.Custom[$(this).attr('name')] = $.trim($(this)
                                        .val());
                                }
                            });
                        },
                    },
                    columns: [{
                            data: "id",
                            title: "NO.",
                            className: "table-report__action w-10 text-center",
                        },
                        {
                            data: "transaction_code",
                            title: "Transaction No.",
                            className: "table-report__action w-10 ",
                        },
                        {
                            data: "created_at",
                            title: "Created Date",
                            className: "table-report__action w-10 text-center whitespace-nowrap",
                        },
                        {
                            data: "customer_username",
                            title: "Username",
                            className: "table-report__action w-24 whitespace-nowrap text-center",
                        },
                        {
                            data: "bonus_full",
                            title: "Amount received",
                            className: "table-report__action w-10 text-end",
                        },
                        {
                            data: "tax_total",
                            title: "Tax 3%",
                            className: "table-report__action w-10 text-end",
                        },
                        {
                            data: "amt",
                            title: "Total",
                            className: "table-report__action w-10 text-end",
                        },

                        // {
                        //     data: "edit_amt",
                        //     title: "จำนวนเงินที่แก้ไข",
                        //     className: "table-report__action w-12 text-end",
                        // },
                        {
                            data: "balance",
                            title: "eWallet Balance",
                            className: "table-report__action w-12 text-end",
                        },
                        // {
                        //     data: "customers_id_receive",
                        //     title: "รหัสผู้รับ",
                        //     className: "table-report__action w-12 text-end",
                        // },
                        {
                            data: "customers_name_receive",
                            title: "Receiver Name",
                            className: "table-report__action w-12 text-center",
                        },
                        {
                            data: "note_orther",
                            title: "Detail",
                            className: "table-report__action w-10 text-center",
                        },
                        {
                            data: "type",
                            title: "Type",
                            className: "table-report__action w-10 text-center",
                        },
                        {
                            data: "status",
                            title: "Status",
                            className: "table-report__action w-10 text-center whitespace-nowrap",
                        },
                        // {
                        //     data: "id",
                        //     title: "",
                        //     className: "table-report__action w-10 text-center",
                        // },


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

                        // แสดงเลขลำดับ
                        $('td:nth-child(1)', nRow).html(`${index}`);
                    },
                });
                $('.myWhere,.myLike,.datepicker,.iSort,.myCustom').on('change', function(e) {
                    table_ewallet.draw();
                });
            });
        });



        function get_data_info_ewallet(id) {
            $.ajax({
                url: '',
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

            $('#info_ewallet').find('.box_info').show();
            data.data.forEach((val, key) => {

                let amt_bath = new Intl.NumberFormat('en-US').format(val.amt);
                if (val.type == 1) {
                    $('.ewallet_id').val(val.ewallet_id);
                    $('#customers_id_fk').val(val.customers_id_fk);
                    $('#amt').val(val.amt);

                    $('#transaction_code').text(val.transaction_code);
                    $('#ewallet_created_at').text(val.ewallet_created_at);
                    $('#name').text(val.name);
                    $('.amt').text(data.data_amt);
                    $(".img_doc_info").attr("src", `{{ asset('') }}/${val.url}/${val.file_ewllet}`);
                    $('#changePassModalLabel').text('eWallet รายการฝากเงิน');

                }
            });

        }
    </script>
@endsection
