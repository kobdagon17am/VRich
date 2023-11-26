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
            <li class="breadcrumb-item">การตั้งค่าระบบทั่วไป</li>
            <li class="breadcrumb-item active" aria-current="page"><span>ข้อมูลผู้ใช้งาน</span></li>
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
                        เพิ่มข้อมูลผู้ใช้งาน</button>
                </div>
            </div>
            <div class="modal fade bd-example-modal-lg" id="add" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header ml-4">
                            <h5 class="modal-title" id="myLargeModalLabel"><b>เพิ่มข้อมูลผู้ใช้งาน</b></h5>
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
                                            <form method="post" action="{{ route('admin/AdminData_insert') }}">
                                                @csrf
                                            <div class="row">
                                                <div class="col-md-12 mx-0">
                                                    <div class="form-card">
                                                        <div class="w-100">
                                                            <div class="form-group row">
                                                                <div class="col-lg-6  mt-2">
                                                                    <label><b>USERNAME:</b></label>
                                                                    <input type="text" name="username"
                                                                        class="form-control" placeholder="Uesrname" required>
                                                                </div>
                                                                <div class="col-lg-6  mt-2">
                                                                    <label><b>PASSWORD:</b></label>
                                                                    <input type="text" name="password"
                                                                        class="form-control" placeholder="Password" required>
                                                                </div>
                                                                <div class="col-lg-6  mt-2">
                                                                    <label><b>ชื่อ:</b></label>
                                                                    <input type="text" name="first_name"
                                                                        class="form-control" placeholder="ชื่อ" required>
                                                                </div>
                                                                <div class="col-lg-6  mt-2">
                                                                    <label><b>นามสกุล:</b></label>
                                                                    <input type="text" name="last_name"
                                                                        class="form-control" placeholder="นามสกุล" required>
                                                                </div>
                                                                <div class="col-lg-6  mt-2">
                                                                    <label><b>เบอร์ติดต่อ:</b></label>
                                                                    <input type="number" name="phone"
                                                                        class="form-control" placeholder="เบอร์ติดต่อ"
                                                                        maxlength="10" >
                                                                </div>

                                                                <div class="col-lg-6 mt-2">
                                                                    <label><b>ระดับสมาชิก:</b></label>
                                                                    <select class="form-control" name="admin_position">
                                                                        @foreach ($admin_position as $val)
                                                                        <option value="{{ $val->id }}">
                                                                            {{ $val->name }}
                                                                            ({{ $val->detail }})
                                                                        </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-6  mt-2">
                                                                    <label><b>แผนก:</b></label>
                                                                        <select class="form-control"
                                                                        name="department">

                                                                        @foreach ($admin_department as $val)
                                                                            <option value="{{ $val->id }}">
                                                                                {{ $val->name }}

                                                                            </option>
                                                                        @endforeach
                                                                    </select>


                                                                </div>
                                                                <div class="col-lg-6  mt-2">
                                                                    <label><b>สาขาประจำ:</b></label>
                                                                    <select class="form-control branch_select"
                                                                        name="branch_id_fk" required>
                                                                        <option selected > เลือกสาขา
                                                                        </option>
                                                                        @foreach ($get_branch as $val)
                                                                            <option value="{{ $val->id }}">
                                                                                {{ $val->branch_name }}
                                                                                ({{ $val->branch_code }})
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-6 mt-2">
                                                                    <label><b>สถานะ:</b></label>
                                                                    <select class="form-control" name="status">
                                                                        <option value="1">เปิดใช้งาน</option>
                                                                        <option value="0">ปิดใช้งาน</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="info-area col-md-12 text-center mt-4 ">
                                                        <button type="submit" class="btn btn-info btn-rounded">
                                                            <i class="las la-save"></i> เพิ่มข้อมูลผู้ใช้งาน</button>
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
                            <h5 class="modal-title" id="myLargeModalLabel"><b>แก้ไขข้อมูลผู้ใช้งาน</b></h5>
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
                                            <form method="post" action="{{ route('admin/edit_admin_data') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 mx-0">
                                                        <div class="form-card">
                                                            <div class="w-100">
                                                                <div class="form-group row">
                                                                    <div class="col-lg-6  mt-2">
                                                                        <input type="hidden" name="id"
                                                                            id="id">
                                                                        <label><b>USERNAME:</b></label>
                                                                        <input type="text" id="username"
                                                                            class="form-control" placeholder="Uesrname" disabled>
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>PASSWORD:</b></label>
                                                                        <input type="text" id="password" name="password"
                                                                            class="form-control" placeholder="Password">
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>ชื่อ:</b></label>
                                                                        <input type="text" id="first_name" name="first_name"
                                                                            class="form-control" placeholder="ชื่อ">
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>นามสกุล:</b></label>
                                                                        <input type="text" id="last_name" name="last_name"
                                                                            class="form-control" placeholder="นามสกุล">
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>เบอร์ติดต่อ:</b></label>
                                                                        <input type="number" id="phone" name="phone"
                                                                            class="form-control" placeholder="เบอร์ติดต่อ"
                                                                            maxlength="10">
                                                                    </div>


                                                                    <div class="col-lg-6 mt-2">
                                                                        <label><b>ระดับสมาชิก:</b></label>
                                                                        <select class="form-control" name="admin_position" id="admin_position">
                                                                            @foreach ($admin_position as $val)
                                                                            <option value="{{ $val->id }}">
                                                                                {{ $val->name }}
                                                                                ({{ $val->detail }})
                                                                            </option>
                                                                        @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>แผนก:</b></label>
                                                                            <select class="form-control"
                                                                            name="department" id="department">

                                                                            @foreach ($admin_department as $val)
                                                                                <option value="{{ $val->id }}">
                                                                                    {{ $val->name }}

                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>

                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>สาขาประจำ:</b></label>
                                                                        <select class="form-control branch_select"
                                                                            id="branch_id_fk" name="branch_id_fk">
                                                                            <option selected disabled> เลือกสาขา
                                                                            </option>
                                                                            @foreach ($get_branch as $val)
                                                                                <option value="{{ $val->id }}">
                                                                                    {{ $val->branch_name }}
                                                                                    ({{ $val->branch_code }})
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-6 mt-2">
                                                                        <label><b>สถานะ:</b></label>
                                                                        <select class="form-control" id="status" name="status">
                                                                            <option value="1">เปิดใช้งาน</option>
                                                                            <option value="0">ปิดใช้งาน</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="info-area col-md-12 text-center mt-4 ">
                                                            <button type="submit" class="btn btn-info btn-rounded">
                                                                <i class="las la-save"></i> แก้ไขข้อมูลผู้ใช้งาน</button>
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
                        <th>Username</th>
                        {{-- <th>Password</th> --}}
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>เบอร์ติดต่อ</th>
                        <th>ระดับสมาชิก</th>
                        <th>แผนก</th>
                        <th>สาขา</th>
                        <th>สถานะ</th>
                        <th>แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($get_admin_data as $value)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $value->username }}</td>
                            {{-- <td>{{ $value->password }}</td> --}}
                            <td>{{ $value->first_name }}</td>
                            <td>{{ $value->last_name }}</td>
                            <td>{{ $value->phone }}</td>
                            <td>{{ $value->admin_position_name }}</td>
                            <td>{{ $value->department_name }}</td>
                            <td>{{ $value->branch_name }}</td>
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
                    url: '{{ route('admin/view_admin_data') }}',
                    type: 'GET',
                    data: {
                        id
                    }
                })
                .done(function(data) {
                    //console.log(data['data']['status']);
                    $("#edit").modal();
                    $("#id").val(data['data']['id']);

                    $("#username").val(data['data']['username']);
                    // $("#password").val(data['data']['password']);
                    $("#first_name").val(data['data']['first_name']);
                    $("#last_name").val(data['data']['last_name']);
                    $("#phone").val(data['data']['phone']);
                    $("#admin_position").val(data['data']['admin_position']);

                    $("#department").val(data['data']['department_id']);
                    $("#branch_id_fk").val(data['data']['branch_id_fk']);
                    $("#status").val(data['data']['status']);

                })
                .fail(function() {
                    console.log("error");
                })
        }
    </script>
@endsection
