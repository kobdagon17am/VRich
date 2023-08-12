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
            <li class="breadcrumb-item">ระบบบริการสมาชิก</li>
            <li class="breadcrumb-item active" aria-current="page"><span>ประวัติการตรวจสอบเอกสาร</span></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="widget-content widget-content-area br-6">
                <div class="table-responsive mb-4">
            <table id="ordertable" class="table table-hover table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>วันที่สมัคร</th>
                        <th>รหัสสมาชิก</th>
                        <th>ชื่อสมาชิก</th>
                        <th>รหัสผู้แนะนำ</th>
                        <th>สถานะ</th>
                        <th>ผู้อนุมัติ</th>
                        <th>วันที่อนุมัติ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>06/09/2023</td>
                        <td>A001</td>
                        <td>Vrich</td>
                        <td>A000</td>
                        <td><span class="badge badge-success light">อนุมัติ</span></td>
                        <td>นำโชค</td>
                        <td>15/09/2023</td>
                    </tr>
                    <tr>
                        <td>06/09/2023</td>
                        <td>A001</td>
                        <td>Vrich</td>
                        <td>A000</td>
                        <td><span class="badge badge-success light">อนุมัติ</span></td>
                        <td>นำโชค</td>
                        <td>15/09/2023</td>
                    </tr>
                </tbody>

            </table>
        </div>
        {{-- <div class="pagination p1">
            <ul class="mx-auto">
                <a href="previous">
                    <li><i class="las la-angle-left"></i></li>
                </a>
                <a class="is-active" href="page">
                    <li>1</li>
                </a>
                <a href="page2">
                    <li>2</li>
                </a>
                <a href="page2">
                    <li>3</li>
                </a>
                <a href="next">
                    <li><i class="las la-angle-right"></i></li>
                </a>
            </ul>
        </div> --}}

    </div>


    </div>
@endsection
@section('js')
    <script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/forms/custom-select2.js') }}"></script>
@endsection
