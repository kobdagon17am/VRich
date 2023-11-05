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
@endsection
@section('page-header')
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">ระบบข่าวสาร</li>
            <li class="breadcrumb-item active" aria-current="page"><span>ข่าวสารและกิจกรรม</span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="widget-content widget-content-area br-6">
        <div class="row">
            {{-- <div class="col-md-2">
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-12 col-sm-12"><b>รหัสสินค้า</b></label>
                    <input type="text" class="form-control float-left text-center w130 myLike product_code "
                        placeholder="รหัสสินค้า">
                </div>
            </div> --}}

            <div class="col-md-12 text-right">
                <div class="input-group-prepend">
                    <button class="btn btn-success btn-rounded " data-toggle="modal" data-target="#add" type="button"><i
                            class="las la-plus-circle font-20"></i>
                        เพิ่มข่าวสาร</button>
                </div>
            </div>
            <div class="modal fade bd-example-modal-lg" id="add" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header ml-4">
                            <h5 class="modal-title" id="myLargeModalLabel"><b>เพิ่มข่าวสาร</b></h5>
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
                                            <form method="post" action="{{ route('admin/News_insert') }}"
                                                enctype="multipart/form-data" id="msform">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 mx-0">
                                                        <div class="form-card">
                                                            <div class="w-100">
                                                                <div class="form-group row">
                                                                    <div class="col-lg-12 text-center">
                                                                        <label><b>หัวข้อข่าว:</b></label>
                                                                        <input type="text" name="news_title"
                                                                            class="form-control"
                                                                            placeholder="หัวข้อข่าว">
                                                                    </div>
                                                                    <div class="col-lg-12 mt-2 text-left">
                                                                        <label><b>รายละเอียดอย่างย่อ:</b></label>
                                                                        <input type="text" name="news_name"
                                                                            class="form-control"
                                                                            placeholder="รายละเอียดอย่างย่อ">
                                                                    </div>
                                                                    {{-- <div class="col-lg-6 mt-2 text-left">
                                                                        <label><b>URL:</b></label>
                                                                        <input type="text" name="news_url"
                                                                            class="form-control"
                                                                            placeholder="URL">
                                                                    </div> --}}
                                                                    <div class="col-lg-12 mt-2 text-left">
                                                                        <label><b>รายละเอียด:</b></label>
                                                                        <textarea class="form-control" rows="9" name="news_detail" placeholder="รายละเอียดข่าวสาร"></textarea>
                                                                    </div>
                                                                    <div class="col-lg-6 mt-2 text-left">
                                                                        <label for="news_image1"><b>รูปภาพ: กว้าง 1200 px สูง 800 px</b></label
                                                                        <div class="upload text-center img-thumbnail">
                                                                            <input type="file"
                                                                                name="news_image1" class="dropify"
                                                                                data-default-file="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 mt-2 text-left">
                                                                        <label><b>สถานะข่าวสาร:</b></label>
                                                                        <select class="form-control"
                                                                            name="news_status">
                                                                            <option value="1">เปิดใช้งาน</option>
                                                                            <option value="0">ปิดใช้งาน</option>
                                                                        </select>
                                                                    </div>


                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="info-area col-md-12 text-center mt-4 ">
                                                            <button type="submit" class="btn btn-info btn-rounded">
                                                                <i class="las la-save"></i> เพิ่มข่าวสาร</button>
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
                            <h5 class="modal-title" id="myLargeModalLabel"><b>แก้ไขข่าวสาร</b></h5>
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
                                            <form method="post" action="{{ route('admin/edit_news') }}"
                                                enctype="multipart/form-data" id="msform">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 mx-0">
                                                        <div class="form-card">
                                                            <div class="w-100">
                                                                <div class="form-group row">
                                                                    <div class="col-lg-12 text-center">
                                                                        <input type="hidden" name="id"
                                                                            id="id">
                                                                        <label><b>หัวข้อข่าว:</b></label>
                                                                        <input type="text" name="news_title" id="news_title"
                                                                            class="form-control"
                                                                            placeholder="หัวข้อข่าว">
                                                                    </div>
                                                                    <div class="col-lg-12 mt-2 text-left">
                                                                        <label><b>รายละเอียดอย่างย่อ:</b></label>
                                                                        <input type="text" name="news_name" id="news_name"
                                                                            class="form-control"
                                                                            placeholder="รายละเอียดอย่างย่อ">
                                                                    </div>
                                                                    {{-- <div class="col-lg-6 mt-2 text-left">
                                                                        <label><b>URL:</b></label>
                                                                        <input type="text" name="news_url" id="news_url"
                                                                            class="form-control"
                                                                            placeholder="URL">
                                                                    </div> --}}
                                                                    <div class="col-lg-12 mt-2 text-left">
                                                                        <label><b>รายละเอียด:</b></label>
                                                                        <textarea class="form-control" rows="9" name="news_detail" id="news_detail" placeholder="รายละเอียดข่าวสาร"></textarea>
                                                                    </div>
                                                                    <div class="col-lg-6 mt-2 text-left">
                                                                        <label for="news_image1"><b>รูปภาพ: สูง 500 px กว้าง 1300 px</b></label>
                                                                        <div class="upload text-center img-thumbnail">
                                                                            <input type="file"
                                                                                name="news_image1" id="news_image1" class="dropify"
                                                                                data-default-file="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 mt-2 text-left">
                                                                        <label><b>สถานะข่าวสาร:</b></label>
                                                                        <select class="form-control"
                                                                            name="news_status" id="news_status">
                                                                            <option value="1">เปิดใช้งาน</option>
                                                                            <option value="0">ปิดใช้งาน</option>
                                                                        </select>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="info-area col-md-12 text-center mt-4 ">
                                                            <button type="submit" class="btn btn-info btn-rounded">
                                                                <i class="las la-save"></i> แก้ไขข่าวสาร</button>
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
        <div class="table-responsive mt-4 mb-2">
            <table id="basic-dt" class="table table-hover" style="width:100%">

            </table>
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
    <script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/forms/custom-select2.js') }}"></script>
    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>
    <script src="{{ asset('backend/assets/js/forms/multiple-step.js') }}"></script>
    <script src="{{ asset('backend/plugins/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/profile_edit.js') }}"></script>
    <!-- The following JS library files are loaded to use PDF Options-->
    <script src="{{ asset('backend/plugins/table/datatable/button-ext/pdfmake.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/table/datatable/button-ext/vfs_fonts.js') }}"></script>
    <script>
        function edit(id) {
            $.ajax({
                    url: '{{ route('admin/view_news') }}',
                    type: 'GET',
                    data: {
                        id
                    }
                })
                .done(function(data) {
                    console.log(data);
                    $("#edit").modal();
                    $("#id").val(data['data']['id']);
                    $("#news_title").val(data['data']['news_title']);
                    $("#news_name").val(data['data']['news_name']);
                    $("#news_detail").val(data['data']['news_detail']);
                    $("#news_url").val(data['data']['news_url']);
                    $("#news_status").val(data['data']['news_status']);
                    $.each(data['img'], function(index, value) {
                        if (value['news_image_orderby'] == 1) {

                            var img = '{{ asset('') }}' + value['news_image_url'] + value[
                                'news_image_name'];
                            $('#news_image1').attr('data-default-file', img).dropify();
                        }



                    });

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
                    url: '{{ route('admin/news_datatable') }}',
                    data: function(d) {

                    },
                },

                columns: [
                    // {
                    //     data: "id",
                    //     title: "ลำดับ",
                    //     className: "w-10 text-center",
                    // },
                    {
                        data: "news_image",
                        title: "รูปภาพ",
                        className: "w-10 ",
                    },

                    {
                        data: "news_title",
                        title: "หัวข้อข่าว",
                        className: "w-10",
                    },

                    {
                        data: "news_name",
                        title: "รายละเอียดอย่างย่อ",
                        className: "w-10 ",
                    },
                    {
                        data: "news_detail",
                        title: "เนื้อหาข่าว",
                        className: "w-10 ",
                    },


                    {
                        data: "created_at",
                        title: "วันที่เขียนข่าว",
                        className: "w-10",
                    },

                    {
                        data: "news_status",
                        title: "สถานะข่าวสาร",
                        className: "w-10",

                    },

                    {
                        data: "action",
                        title: "Action",
                        className: "w-10",
                    },



                ],



            });
            // $('#search-form').on('click', function(e) {
            //     table_order.draw();
            //     e.preventDefault();
            // });

        });
    </script>
@endsection
