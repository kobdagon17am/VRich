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


    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/editors/quill/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/editors/markdown/simplemde.min.css') }}">


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

<div class="col-lg-12 layout-spacing">
    <div class="statbox widget box box-shadow mb-4">

        <form method="post" action="{{ route('admin/edit_news') }}"
        enctype="multipart/form-data" id="msform_edit">
        @csrf
        <div class="widget-content widget-content-area">
            <div class="form-group row">
                <div class="col-lg-12 col-sm-12">
                    <div class="form-group row">
                        <div class="col-lg-12 text-center">
                            <input type="hidden" name="id"
                                id="id" value="{{$get_news->id}}">
                            <label><b>หัวข้อข่าว:</b></label>
                            <input type="text" name="news_name" id="news_name"
                                class="form-control"
                                placeholder="หัวข้อข่าว" value="{{$get_news->news_name}}">
                        </div>
                        <div class="col-lg-12 mt-2 text-left">
                            <label><b>รายละเอียดอย่างย่อ:</b></label>
                            <input type="text" name="news_title" id="news_title"
                                class="form-control" value="{{$get_news->news_title}}"
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

                            <input name="news_detail" type="hidden" id="edit_news_detail">

                            <div class="form-group row">
                                <div class="col-lg-12 col-sm-12">

                                    <div id="editor">

                                        {!!$get_news->news_detail!!}
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="col-lg-6 mt-2 text-left">
                            <label for="news_image1"><b>รูปภาพ: สูง 500 px กว้าง 1300 px</b></label>
                            <div class="upload text-center img-thumbnail">
                                <input type="file"
                                    name="news_image1" id="news_image1" class="dropify"
                                    data-default-file="{{ asset($get_news->news_image_url . '' . $get_news->news_image_name) }}">


                            </div>
                        </div>
                        <div class="col-lg-6 mt-2 text-left">
                            <label><b>สถานะข่าวสาร:</b></label>
                            <select class="form-control"
                                name="news_status" id="news_status">
                                <option value="1" @if($get_news->news_status == 1) selected @endif>เปิดใช้งาน</option>
                                <option value="0"  @if($get_news->news_status == 0) selected @endif>ปิดใช้งาน</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="widget-footer text-right">
            <button onclick="submit_edit()" class="btn btn-info btn-rounded">
                <i class="las la-save"></i> แก้ไขข่าวสาร</button>
            <a href="{{route('admin/News')}}" type="reset" class="btn btn-outline-primary">ย้อนกลับ</a>
        </div>
        </form>
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

    <script src="{{ asset('backend/plugins/editors/quill/quill.js') }}""></script>
    <script src="{{ asset('backend/plugins/editors/markdown/simplemde.min.js') }}""></script>
    <script src="{{ asset('backend/assets/js/forms/forms-text-editor.js') }}""></script>

    <script>
        // รองรับการโหลดโค้ดตอนที่หน้าเว็บโหลดเสร็จ


        function submit_edit(){
            var editorValue = $("#editor .ql-editor").html();
            $("#edit_news_detail").val(editorValue);
            $("#msform_edit").submit();

        }
    </script>

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
