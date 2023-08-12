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
            <li class="breadcrumb-item">ระบบคลังบริษัท</li>
            <li class="breadcrumb-item active" aria-current="page"><span>ข้อมูลคลังสินค้า</span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="widget-content widget-content-area br-6">
        <div class="row">
            <div class="col-md-12 text-right">
                <div class="input-group-prepend">
                    <button class="btn btn-success btn-rounded " data-toggle="modal" data-target="#add" type="button"><i
                            class="las la-plus-circle font-20"></i>
                        เพิ่มคลังสินค้า</button>
                </div>
            </div>
            <div class="modal fade bd-example-modal-lg" id="add" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header ml-4">
                            <h5 class="modal-title" id="myLargeModalLabel"><b>เพิ่มคลังสินค้า</b></h5>
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
                                            <form method="post" action="{{ route('admin/Warehouse_insert') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 mx-0">
                                                        <div class="form-card">
                                                            <div class="w-100">
                                                                <div class="form-group row">
                                                                    <div class="col-lg-6  mt-2">
                                                                       
                                                                        <label><b>ชื่อสาขา:</b></label>
                                                                        <select class="form-control" name="branch_name">
                                                                            @foreach ($get_branch as $item)
                                                                                <option value="{{ $item->id }}">
                                                                                    {{ $item->branch_name }}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>รหัสคลังสินค้า:</b></label>
                                                                        <input type="text" name="warehouse_code"
                                                                            class="form-control"
                                                                            placeholder="รหัสคลังสินค้า">
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>ชื่อคลังสินค้า:</b></label>
                                                                        <input type="text" name="warehouse_name"
                                                                            class="form-control"
                                                                            placeholder="ชื่อคลังสินค้า">
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>รายละเอียดคลังสินค้า:</b></label>
                                                                        <textarea class="form-control" name="warehouse_details" placeholder="รายละเอียดคลังสินค้า"></textarea>
                                                                    </div>
                                                                    <div class="col-lg-6 mt-2">
                                                                        <label><b>สถานะ:</b></label>
                                                                        <select class="form-control" name="warehouse_status">
                                                                            <option value="1">เปิดใช้งาน</option>
                                                                            <option value="0">ปิดใช้งาน</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="info-area col-md-12 text-center mt-4 ">
                                                            <button type="submit" class="btn btn-info btn-rounded">
                                                                <i class="las la-save"></i> เพิ่มคลังสินค้า</button>
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
                            <h5 class="modal-title" id="myLargeModalLabel"><b>เพิ่มคลังสินค้า</b></h5>
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
                                            <form method="post" action="{{ route('admin/edit_warehouse') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 mx-0">
                                                        <div class="form-card">
                                                            <div class="w-100">
                                                                <div class="form-group row">
                                                                    <div class="col-lg-6  mt-2">
                                                                        <input type="hidden" name="id" id="id">
                                                                        <label><b>ชื่อสาขา:</b></label>
                                                                        <select class="form-control" name="branch_name" id="branch_name">
                                                                            @foreach ($get_branch as $item)
                                                                                <option value="{{ $item->id }}">
                                                                                    {{ $item->branch_name }}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>รหัสคลังสินค้า:</b></label>
                                                                        <input type="text" name="warehouse_code"
                                                                            id="warehouse_code" class="form-control"
                                                                            placeholder="รหัสคลังสินค้า">
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>ชื่อคลังสินค้า:</b></label>
                                                                        <input type="text" name="warehouse_name"
                                                                            id="warehouse_name" class="form-control"
                                                                            placeholder="ชื่อคลังสินค้า">
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>รายละเอียดคลังสินค้า:</b></label>
                                                                        <textarea class="form-control" id="warehouse_details" name="warehouse_details" id="warehouse_details"
                                                                            placeholder="รายละเอียดคลังสินค้า"></textarea>
                                                                    </div>
                                                                    <div class="col-lg-6 mt-2">
                                                                        <label><b>สถานะ:</b></label>
                                                                        <select class="form-control"
                                                                            name="warehouse_status" id="warehouse_status">
                                                                            <option value="1">เปิดใช้งาน</option>
                                                                            <option value="0">ปิดใช้งาน</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="info-area col-md-12 text-center mt-4 ">
                                                            <button type="submit" class="btn btn-info btn-rounded">
                                                                <i class="las la-save"></i> เพิ่มคลังสินค้า</button>
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
        <br>
        <div class="table-responsive mb-4">
            <table id="ordertable" class="table table-hover table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อสาขา</th>
                        <th>รหัสคลังสินค้า</th>
                        <th>ชื่อคลังสินค้า</th>
                        <th>รายละเอียดคลังสินค้า</th>
                        <th>สถานะ</th>
                        <th>แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($get_warehouse as $value)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $value->branch_name }}</td>
                            <td>{{ $value->warehouse_code }}</td>
                            <td>{{ $value->warehouse_name }}</td>
                            <td>{{ $value->warehouse_details }}</td>
                            <td>
                                @if ($value->status == '1')
                                    <span class="badge badge-pill badge-success light">เปิดใช้งาน</span>
                                @endif
                                @if ($value->status == '0')
                                    <span class="badge badge-pill badge-danger light">ปิดใช้งาน</span>
                                @endif
                            <td>
                                <a href="#!" onclick="edit({{ $value->id }})" class="p-2">
                                    <i class="lab la-whmcs font-25 text-warning"></i></a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>




    </div>
@endsection
@section('js')
    <script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/forms/custom-select2.js') }}"></script>
    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>
    <script src="{{ asset('backend/assets/js/forms/multiple-step.js') }}"></script>
    <script src="{{ asset('backend/plugins/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/profile_edit.js') }}"></script>
    <script>
        function edit(id) {
            $.ajax({
                    url: '{{ route('admin/view_warehouse') }}',
                    type: 'GET',
                    data: {
                        id
                    }
                })
                .done(function(data) {
                    //console.log(data['data']['status']);
                    $("#edit").modal();
                    $("#id").val(data['data']['id']);

                    $("#branch_name").val(data['data']['branch_id_fk']);
                    $("#warehouse_code").val(data['data']['warehouse_code']);
                    $("#warehouse_name").val(data['data']['warehouse_name']);
                    $("#warehouse_details").val(data['data']['warehouse_details']);
                    $("#warehouse_status").val(data['data']['status']);

                })
                .fail(function() {
                    console.log("error");
                })
        }
    </script>
@endsection
