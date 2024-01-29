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
            <li class="breadcrumb-item">Learning</li>
            <li class="breadcrumb-item active" aria-current="page"><span>สื่อการเรียนรู้</span></li>
        </ol>
    </nav>
@endsection
@section('content')

<div class="col-lg-12 layout-spacing">
    <div class="statbox widget box box-shadow mb-4">

        <form method="post" action="{{ route('admin/edit_learning') }}"
        enctype="multipart/form-data" id="msform_edit">
        @csrf
        <div class="widget-content widget-content-area">
            <div class="form-group row">
                <div class="col-lg-12 col-sm-12">
                    <div class="row">
                        <div class="col-md-12 mx-0">
                            <div class="form-card">
                                <div class="w-100">
                                    <div class="form-group row">
                                        <div class="col-lg-12 text-left">
                                            <input type="hidden" name="id" value="{{$get_learning->id}}"
                                                id="id">
                                            <label><b>หัวข้อข่าว *</b></label>
                                            <input type="text" name="learning_name" id="learning_name"
                                                class="form-control"  value="{{$get_learning->learning_name}}"
                                                placeholder="หัวข้อข่าว" required>
                                        </div>
                                        <div class="col-lg-12 mt-2 text-left">
                                            <label><b>รายละเอียดอย่างย่อ *</b></label>
                                            <input type="text" name="learning_title" id="learning_title"
                                                class="form-control"  value="{{$get_learning->learning_title}}"
                                                placeholder="รายละเอียดอย่างย่อ" required>
                                        </div>
                                        <div class="col-lg-12 mt-2 text-center">
                                        <span style="color:red">** Link Youtube เช่น
                                            https://www.youtube.com<span style="color:blue">/embed/</span>zthvZvw-yJE <span style="color:blue">ต้องใช้ /embed/ เพราะเป็นข้อจำกัดของ Youtube </span>**</span>
                                        </div>
                                        <div class="col-lg-12 mt-2 text-left">

                                            <label><b>URL Youtube 1:</b></label>
                                            <input type="text" name="vdeo_url_1" id="vdeo_url_1"
                                                class="form-control"  value="{{$get_learning->vdeo_url_1}}"
                                                placeholder="URL">
                                        </div>
                                        <div class="col-lg-12 mt-2 text-left">

                                            <label><b>URL Youtube 2:</b></label>
                                            <input type="text" name="vdeo_url_2" id="vdeo_url_2"
                                                class="form-control"  value="{{$get_learning->vdeo_url_2}}"
                                                placeholder="URL">
                                        </div>
                                        <div class="col-lg-12 mt-2 text-left">

                                            <label><b>URL Youtube 3:</b></label>
                                            <input type="text" name="vdeo_url_3" id="vdeo_url_3"
                                                class="form-control" value="{{$get_learning->vdeo_url_3}}"
                                                placeholder="URL">
                                        </div>
                                        <div class="col-lg-12 mt-2 text-left">
                                            <label><b>รายละเอียด:</b></label>
                                            {{-- <textarea class="form-control" rows="9" name="learning_detail" id="learning_detail" placeholder="รายละเอียดสื่อการเรียบรู้"></textarea> --}}

                                            <input name="learning_detail" type="hidden" id="edit_learning_detailail">

                                            <div class="form-group row">
                                                <div class="col-lg-12 col-sm-12">

                                                    <div id="editor">


                                                    </div>

                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-lg-6 mt-2 text-left">
                                            <label for="learning_image1"><b>รูปภาพ: สูง 500 px กว้าง 1300 px</b></label>
                                            <div class="upload text-center img-thumbnail">
                                                <input type="file"
                                                    name="learning_image1" id="learning_image1" class="dropify"
                                                    data-default-file="{{asset($get_learning->learning_image_url . '' . $get_learning->learning_image_name)}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mt-2 text-left">
                                            <label><b>สถานะสื่อการเรียบรู้:</b></label>
                                            <select class="form-control"
                                                name="learning_status" id="learning_status">

                                                <option value="1" @if($get_learning->learning_status == 1) selected @endif>เปิดใช้งาน</option>
                                                <option value="0"  @if($get_learning->learning_status == 0) selected @endif>ปิดใช้งาน</option>



                                            </select>
                                        </div>

                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget-footer text-right">
            <button onclick="submit_edit()" class="btn btn-info btn-rounded">
                <i class="las la-save"></i> แก้ไขสื่อการเรียบรู้</button>
            <a href="{{route('admin/Learning')}}" type="reset" class="btn btn-outline-primary">ย้อนกลับ</a>
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
            function submit_edit(){

                        // Check if required fields are filled
                        var requiredFieldsFilled = true;

                        // Check each required input field
                        $("#msform_edit :input[required]").each(function () {
                            if ($(this).val().trim() === '') {
                                // Mark the field as not filled
                                requiredFieldsFilled = false;
                                // Optionally, you can highlight the field or show an error message
                                // For example: $(this).addClass('error');
                            }
                        });

                        // If all required fields are filled, proceed with form submission
                        if (requiredFieldsFilled) {
                            var editorValue = $("#editor .ql-editor").html();
                            $("#edit_learning_detailail").val(editorValue);
                            $("#msform_edit").submit();
                        } else {
                            // Optionally, you can show an alert or perform any other action
                            alert("Please fill in all required fields.");
                        }


        }


        function edit(id) {
            $.ajax({
                    url: '{{ route('admin/view_learning') }}',
                    type: 'GET',
                    data: {
                        id
                    }
                })
                .done(function(data) {
                    console.log(data);
                    $("#edit").modal();
                    $("#id").val(data['data']['id']);
                    $("#learning_title").val(data['data']['learning_title']);
                    $("#learning_name").val(data['data']['learning_name']);
                    $("#learning_detail").val(data['data']['learning_detail']);
                    $("#vdeo_url_1").val(data['data']['vdeo_url_1']);
                    $("#vdeo_url_2").val(data['data']['vdeo_url_2']);
                    $("#vdeo_url_3").val(data['data']['vdeo_url_3']);
                    $("#learning_status").val(data['data']['learning_status']);
                    $.each(data['img'], function(index, value) {
                        if (value['learning_image_orderby'] == 1) {

                            var img = '{{ asset('') }}' + value['learning_image_url'] + value[
                                'learning_image_name'];
                            $('#learning_image1').attr('data-default-file', img).dropify();
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
                    url: '{{ route('admin/learning_datatable') }}',
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
                        data: "learning_image",
                        title: "รูปภาพ",
                        className: "w-10 ",
                    },

                    {
                        data: "learning_title",
                        title: "หัวข้อข่าว",
                        className: "w-10",
                    },

                    {
                        data: "learning_name",
                        title: "รายละเอียดอย่างย่อ",
                        className: "w-10 ",
                    },
                    {
                        data: "learning_detail",
                        title: "เนื้อหาข่าว",
                        className: "w-10 ",
                    },


                    {
                        data: "created_at",
                        title: "วันที่เขียนข่าว",
                        className: "w-10",
                    },

                    {
                        data: "learning_status",
                        title: "สถานะสื่อการเรียบรู้",
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
