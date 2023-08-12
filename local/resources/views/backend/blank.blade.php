@extends('layouts.backend.app')
@section('css')

@endsection
@section('page-header')
<nav class="breadcrumb-one" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboards</a></li>
        <li class="breadcrumb-item active" aria-current="page"><span>Dashboard 1</span></li>
    </ol>
</nav>
@endsection
@section('content')
<div class="row layout-top-spacing">
    <div class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow mb-4">
            {{-- <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Picker</h4>
                    </div>
                </div>
            </div> --}}
            <div class="widget-content widget-content-area">

                content

            </div>
            {{-- <div class="widget-footer text-right">
                <button type="reset" class="btn btn-primary mr-2">Submit</button>
                <button type="reset" class="btn btn-outline-primary">Cancel</button>
            </div> --}}
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection
