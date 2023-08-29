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
            <li class="breadcrumb-item active" aria-current="page"><span>ข้อมูลสาขาบริษัท</span></li>
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
                        เพิ่มสาขาบริษัท</button>

                </div>
            </div>
            <div class="modal fade bd-example-modal-lg" id="add" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header ml-4">
                            <h5 class="modal-title" id="myLargeModalLabel"><b>เพิ่มสาขาบริษัท</b></h5>
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
                                            <form method="post" action="{{ route('admin/Branch_insert') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 mx-0">
                                                        <div class="form-card">
                                                            <div class="w-100">
                                                                <div class="form-group row">
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>รหัสสาขา:</b></label>
                                                                        <input type="text" name="branch_code"
                                                                            class="form-control" placeholder="รหัสสาขา">
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>ชื่อสาขา:</b></label>
                                                                        <input type="text" name="branch_name"
                                                                            class="form-control" placeholder="ชื่อสาขา">
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2">
                                                                        <div class="form-group">
                                                                            <label for="card_changwat">จังหวัด
                                                                                <span
                                                                                    class="text-danger">*</span></label>

                                                                        <select name="card_changwat" class="form-control " id="card_changwat" required>
                                                                            <option value="">เลือกจังหวัด</option>

                                                                            @foreach ($province as $value_provinces)
                                                                                <option value="{{ $value_provinces->id }}"
                                                                                    @if ($value_provinces->id == old('card_province')) selected @endif>
                                                                                    {{ $value_provinces->name_th }}</option>
                                                                            @endforeach
                                                                        </select>

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="card_amphur">เขต/อำเภอ
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select name="card_amphur" class="form-control"
                                                                                id="card_amphur" disabled required>
                                                                                <option value="">เลือกเขต/อำเภอ</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="card_tambon">แขวง/ตำบล
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select name="card_tambon" class="form-control"
                                                                                id="card_tambon" disabled required>
                                                                                <option value="">เลือกแขวง/ตำบล</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="card_zipcode">รหัสไปรษณีย์
                                                                                <span class="text-danger card_zipcode_err _err">*
                                                                                </span></label>
                                                                                <input type="text"
                                                                                class="form-control @error('card_zipcode') is-invalid @enderror"
                                                                                name="card_zipcode" placeholder="รหัสไปรษณีย์" id="card_zipcode"
                                                                                value="{{ old('card_zipcode') }}" >
                                                                            @error('card_zipcode')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>เบอร์ติดต่อ:</b></label>
                                                                        <input type="number" name="phone"
                                                                            class="form-control"
                                                                            placeholder="เบอร์ติดต่อ" maxlength="10">
                                                                    </div>
                                                                    <div class="col-lg-6 mt-2">
                                                                        <label><b>สถานะ:</b></label>
                                                                        <select class="form-control" name="branch_status">
                                                                            <option value="1">เปิดใช้งาน</option>
                                                                            <option value="0">ปิดใช้งาน</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="info-area col-md-12 text-center mt-4 ">
                                                            <button type="submit" class="btn btn-info btn-rounded">
                                                                <i class="las la-save"></i> เพิ่มสาขาบริษัท</button>
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
                            <h5 class="modal-title" id="myLargeModalLabel"><b>เเก้ไขสาขาบริษัท</b></h5>
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
                                            <form method="post" action="{{ route('admin/edit_branch') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 mx-0">
                                                        <div class="form-card">
                                                            <div class="w-100">
                                                                <div class="form-group row">
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>รหัสสาขา:</b></label>
                                                                        <input type="text" name="branch_code"  id="branch_code"
                                                                            class="form-control" placeholder="รหัสสาขา">
                                                                    </div>
                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>ชื่อสาขา:</b></label>
                                                                        <input type="hidden" name="id"
                                                                            id="id">
                                                                        <input type="text" name="branch_name"
                                                                            id="branch_name" class="form-control"
                                                                            placeholder="ชื่อสาขา">
                                                                    </div>

                                                                    <div class="col-lg-6  mt-2">
                                                                        <div class="form-group">
                                                                            <label for="card_changwat">จังหวัด
                                                                                <span
                                                                                    class="text-danger">*</span></label>

                                                                            <select name="card_changwat" class="form-control basic" id="e_card_changwat" required>
                                                                            <option value="">เลือกจังหวัด</option>
                                                                            @foreach ($province as $value_provinces)
                                                                                <option value="{{ $value_provinces->id }}"
                                                                                    @if ($value_provinces->id == old('card_province')) selected @endif>
                                                                                    {{ $value_provinces->name_th }}</option>
                                                                            @endforeach
                                                                        </select>

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="card_amphur">เขต/อำเภอ
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select name="card_amphur" class="form-control"
                                                                                id="e_card_amphur" disabled required>
                                                                                <option value="">เลือกเขต/อำเภอ</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="card_tambon">แขวง/ตำบล
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select name="card_tambon" class="form-control"
                                                                                id="e_card_tambon" disabled required>
                                                                                <option value="">เลือกแขวง/ตำบล</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="card_zipcode">รหัสไปรษณีย์
                                                                                <span class="text-danger card_zipcode_err _err">*
                                                                                </span></label>
                                                                                <input type="text"
                                                                                class="form-control @error('card_zipcode') is-invalid @enderror"
                                                                                name="card_zipcode" placeholder="รหัสไปรษณีย์" id="e_card_zipcode"
                                                                                value="{{ old('card_zipcode') }}" >
                                                                            @error('card_zipcode')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6  mt-2">
                                                                        <label><b>เบอร์ติดต่อ:</b></label>
                                                                        <input type="number" name="phone" id="phone"
                                                                            class="form-control"
                                                                            placeholder="เบอร์ติดต่อ" maxlength="10">
                                                                    </div>
                                                                    <div class="col-lg-6 mt-2">
                                                                        <label><b>สถานะ:</b></label>
                                                                        <select class="form-control" name="branch_status"
                                                                            id="branch_status">
                                                                            <option value="1">เปิดใช้งาน</option>
                                                                            <option value="0">ปิดใช้งาน</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="info-area col-md-12 text-center mt-4 ">
                                                            <button type="submit" class="btn btn-info btn-rounded">
                                                                <i class="las la-save"></i> แก้ไขสาขาบริษัท</button>
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
                        <th>รหัสสาขา</th>
                        <th>ชื่อสาขา</th>
                        <th>ชื่อสาขา (ภาษาอังกฤษ)</th>
                        <th>ตำบล</th>
                        <th>อำเภอ</th>
                        <th>จังหวัด</th>
                        <th>รหัสไปรษณีย์</th>
                        <th>เบอร์ติดต่อ</th>
                        <th>สถานะ</th>
                        <th>แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>

                    @foreach ($get_branch as $value)

                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $value->branch_code }}</td>
                            <td>{{ $value->branch_name }}</td>
                            <td>{{ $value->branch_en_name }}</td>
                            <td>{{ $value->tambon }}</td>
                            <td>{{ $value->amphur }}</td>
                            <td>{{ $value->changwat }}</td>
                            <td>{{ $value->zipcode }}</td>
                            <td>{{ $value->phone }}</td>
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
                    {{-- <tr>
                        <td>1</td>
                        <td>ถุง</td>
                        <td>Pack</td>
                        <td><span class="badge badge-pill badge-success light">เปิดใช้งาน</span></td>
                        <td>
                            <a href="#!" class="p-2">
                                <i class="lab la-whmcs font-25 text-warning"></i></a>
                        </td>
                    </tr> --}}

                </tbody>
            </table>
        </div>




    </div>
@endsection
@section('js')
    <script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/forms/custom-select2.js') }}"></script>


    <script>
        function edit(id) {
            $.ajax({
                    url: '{{ route('admin/view_branch') }}',
                    type: 'GET',
                    data: {
                        id
                    }
                })
                .done(function(data) {
                    //console.log(data['data']['status']);
                    $("#edit").modal();
                    $("#id").val(data['data']['id']);

                    $("#branch_code").val(data['data']['branch_code']);
                    $("#branch_name").val(data['data']['branch_name']);
                    $("#branch_en_name").val(data['data']['branch_en_name']);
                    $("#tambon").val(data['data']['tambon']);
                    $("#amphur").val(data['data']['amphur']);
                    $("#changwat").val(data['data']['changwat']);
                    $("#zipcode").val(data['data']['zipcode']);
                    $("#phone").val(data['data']['phone']);
                    $("#branch_status").val(data['data']['status']);

                })
                .fail(function() {
                    console.log("error");
                })
        }
    </script>

<script>

    $("#card_changwat").change(function() {
            let province_id = $(this).val();
            $.ajax({
                url: '{{ route('getDistrict') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    province_id: province_id,
                },
                success: function(data) {
                    $("#card_amphur").children().remove();
                    $("#card_tambon").children().remove();
                    $("#card_amphur").append(` <option value=""> เลือกอำเภอ </option>`);
                    $("#card_tambon").append(` <option value=""> เลือกตำบล </option>`);
                    $("#card_zipcode").val("");
                    data.forEach((item) => {
                        $("#card_amphur").append(
                            `<option value="${item.id}">${item.name_th}</option>`
                        );

                    });
                    $("#card_amphur").attr('disabled', false);
                    $("#card_tambon").attr('disabled', true);
                },
                error: function() {}
            })
        });


        $("#card_amphur").change(function() {
            let district_id = $(this).val();
            $.ajax({
                url: '{{ route('getTambon') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    district_id: district_id,
                },
                success: function(data) {
                    $("#card_tambon").children().remove();
                    $("#card_tambon").append(` <option value=""> เลือกตำบล </option>`);
                    $("#card_zipcode").val("");
                    data.forEach((item) => {
                        $("#card_tambon").append(
                            `<option value="${item.id}">${item.name_th}</option>`
                        );
                    });
                    $("#card_tambon").attr('disabled', false);
                },
                error: function() {}
            })
        });
        // BEGIN district

        $("#card_tambon").change(function() {
            let tambon_id = $('#card_tambon').val();
            console.log(tambon_id);
            $.ajax({
                url: '{{ route('getZipcode') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    tambon_id: tambon_id,
                },
                success: function(data) {
                    // console.log(data);
                    $("#card_zipcode").attr('disabled', false);
                    $("#card_zipcode").val(data.zip_code);
                },
                error: function() {}
            })
        });
</script>
@endsection
