@section('css')
    <link href='https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css' rel='stylesheet'>
@endsection
<title>VRich</title>

@extends('layouts.frontend.app')
@section('conten')
    <div class="bg-whiteLight page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active text-truncate" aria-current="page">Salepage Setting</li>
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
                                <div class="col-md-12 col-lg-3">
                                    <label for="" class="form-label">เลขที่ออเดอร์</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-5 col-lg-2">
                                    <label for="" class="form-label">วันที่เริ่มต้น</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-5 col-lg-2">
                                    <label for="" class="form-label">วันที่สิ้นสุด</label>
                                    <input type="date" class="form-control">
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
                                    <h4 class="card-title mb-0">Salepage Setting</h4>
                                </div>
                                <div class="col-sm-6 text-md-end">
                                    {{-- <button type="button" class="btn btn-info rounded-pill mb-2"><i
                                            class='bx bxs-file me-1'></i> ออกรายงาน</button> --}}
                                </div>
                            </div>

                            <hr>
                            <form method="post" id="edit" action="{{ route('edit_SalePageSetting') }}">
                                @csrf
                                <div class="row g-3">
                                    <input type="hidden" name="user_name"
                                        value="{{ Auth::guard('c_user')->user()->user_name }}">
                                    <div class="col-md-3 col-xl-3">
                                        <label for="" class="form-label">Phone Number </label>
                                        <input name="phone" type="text" class="form-control" id=""
                                            maxlength="10" minlength="10"
                                            value="{{ Auth::guard('c_user')->user()->phone }}">
                                    </div>

                                    <div class="col-md-3 col-xl-3">
                                        <label for="" class="form-label">Line ID</label>
                                        <input name="line_id" type="text" class="form-control" id=""
                                            value="{{ Auth::guard('c_user')->user()->line_id }}">
                                    </div>
                                    <div class="col-md-3 col-xl-3 mb-3">
                                        <label for="" class="form-label">Facebook</label>
                                        <input name="facebook" type="text" class="form-control" id=""
                                            value="{{ Auth::guard('c_user')->user()->facebook }}"
                                            placeholder="https://www.facebook.com/">
                                    </div>
                                    <div class="col-md-6 col-xl-3 mb-3">
                                        <label for="" class="form-label">Telegrams ID</label>
                                        <input name="telegrams" type="text" class="form-control" id=""
                                            value="{{ Auth::guard('c_user')->user()->telegrams }}"
                                            placeholder="https://t.me/username">
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-12 text-end">
                                        <hr>
                                        <button type="submit" class="btn btn-success rounded-pill">Save</button>
                                    </div>
                                </div>
                            </form>


                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="card-title mb-0">Salepage URL</h4>
                                </div>
                                <div class="col-sm-6 text-md-end">
                                    {{-- <button type="button" class="btn btn-info rounded-pill mb-2"><i
                                            class='bx bxs-file me-1'></i> ออกรายงาน</button> --}}
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-4">

                                    <div class="col-lg-6">
                                        <div class="card card-box borderR10 mb-2 mb-lg-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4 col-xxl-3 text-center">
                                                        <div class="ratio ratio-1x1">
                                                            <div class="rounded-circle">

                                                                    <img src="{{asset('frontend/salepage/s_1.png')}}" class="mw-100"
                                                                    alt="" />

                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="col-8 col-xxl-9">
                                                        <div class="row">
                                                            <div class="col-6">




                                                            </div>
                                                            <div class="col-6 text-end">

                                                            </div>
                                                        </div>

                                                        <h5> Vrich Smooth&Bright up Serum</h5>
                                                        <hr>


                                                        <div class="row">
                                                            <h5> Page Url</h5>
                                                            <div class="col-sm-12">
                                                                <div class="input-group input-group-button">
                                                                      <?php $user_name= Auth::guard('c_user')->user()->user_name; ?>
                                                                    <input type="text" class="form-control"
                                                                        value="{{url($user_name.'/1')}}">
                                                                    <span class="input-group-addon btn btn-primary"
                                                                        id="basic-addon10">
                                                                        <span class="copy-to-clipboard"
                                                                            data-url="{{url($user_name.'/1')}}">Copy
                                                                            Url</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="card card-box borderR10 mb-2 mb-lg-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4 col-xxl-3 text-center">
                                                        <div class="ratio ratio-1x1">
                                                            <div class="rounded-circle">

                                                                    <img src="{{asset('frontend/salepage/s_2.png')}}" class="mw-100"
                                                                    alt="" />

                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="col-8 col-xxl-9">
                                                        <div class="row">
                                                            <div class="col-6">




                                                            </div>
                                                            <div class="col-6 text-end">

                                                            </div>
                                                        </div>

                                                        <h5> Vrich herbal coffee</h5>
                                                        <hr>


                                                        <div class="row">
                                                            <h5> Page Url</h5>
                                                            <div class="col-sm-12">
                                                                <div class="input-group input-group-button">

                                                                    <input type="text" class="form-control"
                                                                        value="{{url($user_name.'/2')}}">
                                                                    <span class="input-group-addon btn btn-primary"
                                                                        id="basic-addon10">
                                                                        <span class="copy-to-clipboard"
                                                                            data-url="{{url($user_name.'/2')}}">Copy
                                                                            Url</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

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
            $('.copy-to-clipboard').each(function() {
            $(this).on('click', function() {
                const el = document.createElement('textarea');
                el.value = $(this).attr('data-url')
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);

                Swal.fire('Copy Url', el.value, 'success');
            })
        })
</script>
    @endsection
