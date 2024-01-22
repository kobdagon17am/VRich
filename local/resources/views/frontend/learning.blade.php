<title>VRich</title>




@extends('layouts.frontend.app')
@section('conten')
    <div class="bg-whiteLight page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Vrich Learning</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">


                    <div class="card card-box borderR10 mb-2 mb-md-0">
                        <div class="card-body">
                            <h4 class="card-title">Vrich Learning</h4>
                            <hr>
                            <div class="row">
                                @if (isset($Lrn))
                                    @foreach ($Lrn as $item => $value)
                                        @php
                                            $date = new DateTime();
                                            $date->setTimezone(new DateTimeZone('Asia/Bangkok'));
                                        @endphp
                                        {{-- @if ($value->created_at >= $date->format('Y-m-d')) --}}
                                            <div class="col-md-6">
                                                <div class="card cardNewsH mb-3">
                                                    <div class="row g-0">
                                                        <div class="col-md-5">
                                                            <div class="box-imageNews">
                                                                <img src="{{ isset($value->learning_image_url) ? asset("$value->learning_image_url/$value->learning_image_name") : '' }}"
                                                                    class="img-fluid rounded-start" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="card-body">
                                                                <span
                                                                    class="badge rounded-pill bg-purple2 bg-opacity-20 text-p1 fw-light mb-1">
                                                                    {{ $value->created_at }}

                                                                </span>
                                                                <h5 class="card-title">{{ $value->learning_name }}</h5>
                                                                <p class="card-text">
                                                                    {{ isset($value->learning_title) ? $value->learning_title : '' }}
                                                                </p>
                                                                <a href="{{ url('learning_detail') }}/{{ $value->id }}"
                                                                    class="linkNews stretched-link"><span>Read more</span><i
                                                                        class='bx bxs-right-arrow-circle'></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- @endif --}}
                                    @endforeach
                                @endif
                                <div class="row">
                                    <div class="col-12">
                                        <nav aria-label="...">
                                            <ul class="pagination justify-content-end">
                                                {{-- <li class="page-item disabled">
                                                <a class="page-link">Previous</a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item active" aria-current="page">
                                                <a class="page-link" href="#">2</a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li> --}}
                                                {{ $Lrn->links() }}
                                            </ul>
                                        </nav>
                                    </div>
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
            $('#linkMenuTop .nav-item').eq(2).addClass('active');
        </script>

        <script>
            $('.page-content').css({
                'min-height': $(window).height() - $('.navbar').height()
            });
        </script>
    @endsection
