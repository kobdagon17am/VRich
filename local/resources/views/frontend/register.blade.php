@extends('layouts.frontend.app')

@section('css')
    <style>
        .info_alert {
            text-align: left;
            height: 15rem;
            width: 100%;
        }

        .disabled_select {
            pointer-events: none;
            background: #E9ECEF;
        }
    </style>
@endsection

@section('conten')
    <div class="bg-whiteLight page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Register</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form id="form_register">
                        @csrf
                        <div class="card card-box borderR10 mb-2 mb-md-0">
                            <div class="card-body">
                                <h4 class="card-title">Membership Registration</h4>
                                <hr>

                                <div class="borderR10 py-2 px-3 bg-purple3 bg-opacity-50 h5 mb-3">Personal Information</div>

                                <div class="row g-3">
                                    <div class="col-md-4 col-lg-4 col-xxl-3">
                                        <label for="" class="form-label">Sponsor Code<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="sponsor"  id="sponsor"
                                            value="{{ Auth::guard('c_user')->user()->user_name }}">
                                        {{-- <input type="hidden" class="form-control" name="sponsor" value="{{ Auth::guard('c_user')->user()->user_name }}" id=""> --}}
                                    </div>

                                    <div class="col-md-4 col-lg-4 col-xxl-3 mb-3">
                                        <label for="" class="form-label">Sponsor Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="sponsor_name"
                                            value="{{ Auth::guard('c_user')->user()->name }} {{ Auth::guard('c_user')->user()->last_name }}"
                                            disabled>
                                    </div>

                                    <div class="col-md-4 col-xl-4">
                                        <label for="" class="form-label">Business Size<span
                                                class="text-danger sizebusiness_err _err">*</span></label>
                                        <select name="sizebusiness" class="form-select" id="sizebusiness">
                                            {{-- <option selected disabled>Select business size</option> --}}
                                            @foreach ($dataset_qualification as $postion_value)
                                                <option value="{{ $postion_value->code }}">
                                                    {{ $postion_value->business_qualifications }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="borderR10 py-2 px-3 bg-purple3 bg-opacity-50 h5 mb-3">Personal Information</div>
                                <div class="row g-3">

                                    {{-- <div class="col-md-6 col-xl-6">
                                        <label for="" class="form-label">TP <span
                                                class="text-danger pv_err _err">*</span></label>
                                        <input name="pv" readonly type="text" class="form-control" id="pv">
                                    </div> --}}
                                    <input name="pv" readonly type="hidden" class="form-control" value="0">
                                    <div class="col-md-6 col-xl-3">
                                        <label for="" class="form-label">Title <span
                                                class="text-danger prefix_name_err _err">*</span></label>
                                        <select name="prefix_name" class="form-select" id="">
                                            <option selected disabled>Select title</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Miss">Miss</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-xl-3">
                                        <label for="" class="form-label">First Name <span
                                                class="text-danger name_err _err">*</span></label>
                                        <input name="name" type="text" class="form-control" id="">
                                    </div>
                                    <div class="col-md-3 col-xl-3">
                                        <label for="" class="form-label">Last Name <span
                                                class="text-danger last_name_err _err">*</span></label>
                                        <input name="last_name" type="text" class="form-control" id="">
                                    </div>
                                    <div class="col-md-6 col-xl-3">
                                        <label for="" class="form-label">Gender <span
                                                class="text-danger gender_err _err">*</span></label>
                                        <select name="gender" class="form-select" id="">
                                            <option selected disabled>Select gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            {{-- <option value="ไม่ระบุ">ไม่ระบุ</option> --}}
                                        </select>
                                    </div>

                                    <div class="col-md-6 col-xl-6">
                                        <label for="" class="form-label">Business Name</label>
                                        <input name="business_name" type="text" class="form-control" id="">
                                    </div>
                                    <div class="col-md-6 col-xl-2">
                                        <label for="" class="form-label">Date of Birth <span
                                                class="text-danger day_err _err">*</span></label>
                                        <select name="day" class="form-select" id="">
                                            <option selected disabled>Day</option>
                                            @foreach ($day as $val)
                                                <option value="{{ $val }}">{{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 col-xl-2">
                                        <label for=""
                                            class="text-danger form-label d-none d-md-block month_err _err">&nbsp;</label>
                                        <select name="month" class="form-select" id="">
                                            <option selected disabled>Month</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 col-xl-2">
                                        <label for=""
                                            class="text-danger form-label d-none d-md-block year_err _err">&nbsp;</label>
                                        <select class="form-select" id="" name="year">
                                            <option selected disabled>Year</option>
                                            @foreach ($arr_year as $val)
                                                <option val="{{ $val }}">{{ $val }}</option>
                                            @endforeach


                                        </select>
                                    </div>
                                    <div class="col-md-6 col-xl-2">
                                        <label for="" class="form-label">Nationality <span
                                                class="text-danger nation_id_err _err">*</span></label>
                                        <select class="form-select" name="nation_id" id="nation_id">
                                            {{-- <option selected disabled>Select nationality</option> --}}
                                            @php $region = DB::table('dataset_business_location')->get(); @endphp
                                            @foreach (@$region as $r)
                                                <option value="{{ @$r->id }}">{{ @$r->txt_desc }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 col-xl-5">
                                        <label for="" class="form-label">National ID Card Number <span
                                                class="text-danger id_card_err _err">*</span></label>
                                        <input name="id_card" type="text" class="form-control" maxlength="13"
                                            id="id_card">
                                        <span class="error text-danger"></span>
                                    </div>
                                    <div class="col-md-6 col-xl-5">
                                        <label for="" class="form-label">Phone Number <span
                                                class="text-danger phone_err _err">*</span></label>
                                        <input name="phone" type="text" class="form-control" id=""
                                            maxlength="10" minlength="10" onkeyup="isThaichar(this.value,this)">
                                    </div>

                                    <div class="col-md-3 col-xl-3">
                                        <label for="" class="form-label">E-mail <span
                                                class="text-danger email_err _err"></span></label>
                                        <input name="email" type="text" class="form-control" id="">
                                    </div>
                                    <div class="col-md-3 col-xl-3">
                                        <label for="" class="form-label">Line ID</label>
                                        <input name="line_id" type="text" class="form-control" id="">
                                    </div>
                                    <div class="col-md-3 col-xl-3 mb-3">
                                        <label for="" class="form-label">Facebook</label>
                                        <input name="fackbook" type="text" class="form-control" id="">
                                    </div>

                                    <div class="col-md-6 col-xl-3 mb-3">
                                        <label for="" class="form-label">Telegrams</label>
                                        <input name="telegrams" type="text" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="borderR10 py-2 px-3 bg-purple3 bg-opacity-50 h5 mb-3">Address Information</div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="col-md-12 text-center">
                                            <div class="file-upload">
                                                <span class="text-danger file_card_err _err"></span>
                                                <label for="file_card" class="file-upload__label"><i
                                                        class='bx bx-upload'></i> Upload Document</label>
                                                <input id="file_card" class="file-upload__input" type="file"
                                                    accept="image/*" name="file_card">
                                            </div>
                                        </div>
                                        <div class="mt-1 mb-2 d-flex justify-content-center">
                                            <img width="250" height="300" id="img_bank" accept="image/*"
                                                src="{{ asset('frontend/images/250x300.png') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-8 my-auto">
                                        <div id="group_data_card_address" class="row">
                                            <div class="col-md-6 col-xl-5">
                                                <label for="" class="form-label">Address <span
                                                        class="text-danger card_address_err _err">*</span></label>
                                                <input type="text" name="card_address" value=""
                                                    class="form-control card_address" id="">
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <label for="" class="form-label">Moo  </label>
                                                <input type="text" name="card_moo" class="form-control card_address"
                                                    id="">
                                            </div>
                                            <div class="col-md-6 col-xl-4">
                                                <label for="" class="form-label">Soi  </label>
                                                <input type="text" name="card_soi" class="form-control card_address"
                                                    id="">
                                            </div>
                                            <div class="col-md-6 col-xl-4">
                                                <label for="" class="form-label">Road </label>
                                                <input type="text" name="card_road" class="form-control card_address"
                                                    id="">
                                            </div>
                                            <div class="col-md-6 col-xl-4">
                                                <label for="province" class="form-label">Province</label>
                                                <label class="form-label text-danger card_province_err _err"></label>
                                                <select class="form-select card_address" name="card_province"
                                                    id="province">
                                                    <option value="">--Please Select--</option>
                                                    @foreach ($province as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name_th }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-xl-4">
                                                <label for="district" class="form-label">District</label>
                                                <label class="form-label text-danger card_district_err _err"></label>
                                                <select class="form-select card_address" name="card_district"
                                                    id="district" disabled>
                                                    <option value="">--Please Select--</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-xl-4">
                                                <label for="tambon" class="form-label">Sub-district</label>
                                                <label class="form-label text-danger tambon_err _err"></label>
                                                <select class="form-select card_address" name="card_tambon"
                                                    id="tambon" disabled>
                                                    <option value="">--Please Select--</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-xl-4">
                                                <label for="" class="form-label">Postal Code </label>
                                                <input id="zipcode" name="card_zipcode" type="text"
                                                    class="form-control card_address" id="">
                                            </div>
                                            <div class="col-md-6 col-xl-4 mb-3">
                                                <label for="" class="form-label">Mobile Number <span
                                                    class="text-danger card_phone _err">*</span></label>
                                                <input type="text" name="card_phone" maxlength="10"
                                                    class="form-control card_address" id="" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="borderR10 py-2 px-3 bg-purple3 bg-opacity-50 h5 mb-3">
                                    Delivery Address
                                    <div class="form-check form-check-inline h6 fw-normal">
                                        <input class="form-check-input" id="status_address" type="checkbox"
                                            name="status_address" value="1" id="flexCheckDefault">
                                        <label class="form-check-label" for="status_address">
                                            Use the same address as ID card
                                        </label>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6 col-xl-5">
                                        <label for="" class="form-label">Address <span
                                                class="text-danger same_address_err _err">*</span></label>
                                        <input type="text" name="same_address" class="form-control address_same_card"
                                            id="">
                                    </div>
                                    <div class="col-md-6 col-xl-3">
                                        <label for="" class="form-label">Moo  </label>
                                        <input type="text" name="same_moo" class="form-control address_same_card"
                                            id="">
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <label for="" class="form-label">Soi  </label>
                                        <input type="text" name="same_soi" class="form-control address_same_card"
                                            id="">
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <label for="" class="form-label">Road </label>
                                        <input type="text" name="same_road" class="form-control address_same_card"
                                            id="">
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <label for="province" class="form-label">Province</label>
                                        <label class="form-label text-danger same_province_err _err"></label>
                                        <select class="form-select address_same_card select_same" name="same_province"
                                            id="same_province">
                                            <option value="">--Please Select--</option>
                                            @foreach ($province as $item)
                                                <option value="{{ $item->id }}">{{ $item->name_th }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <label for="district" class="form-label">District</label>
                                        <label class="form-label text-danger same_district_err _err"></label>
                                        <select class="form-select address_same_card select_same" name="same_district"
                                            id="same_district" disabled readonly>
                                            <option value="">--Please Select--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <label for="tambon" class="form-label">Sub-district</label>
                                        <label class="form-label text-danger same_tambon_err _err"></label>
                                        <select class="form-select address_same_card select_same" name="same_tambon"
                                            id="same_tambon" disabled readonly>
                                            <option value="">--Please Select--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <label for="" class="form-label">Postal Code </label>
                                        <input id="same_zipcode" name="same_zipcode" type="text"
                                            class="form-control address_same_card" id="">
                                    </div>
                                    <div class="col-md-6 col-xl-4 mb-3">
                                        <label for="" class="form-label">Mobile Number <span
                                            class="text-danger same_phone _err">*</span></label>
                                        <input type="text" name="same_phone" class="form-control address_same_card"
                                            id="" maxlength="10" required>
                                    </div>
                                </div>

                                <div class="borderR10 py-2 px-3 bg-purple3 bg-opacity-50 h5 mb-3">
                                    Bank Account Information for Income</div>
                                <div class="row g-3">
                                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                                        <i class='bx bxs-error me-2'></i>
                                        <div>
                                            Members can choose to provide or not provide this information. If not provided,
                                            it will affect the
                                            transfer of funds to the member.
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="text-danger file_bank_err _err"></span>
                                        <div class="col-md-12 text-center">
                                            <div class="file-upload">
                                                <label for="file_bank" class="file-upload__label"><i
                                                        class='bx bx-upload'></i>
                                                    Upload Document</label>
                                                <input id="file_bank" class="file-upload__input" type="file"
                                                    name="file_bank">
                                            </div>
                                        </div>
                                        <div class=" mt-1 mb-1 d-flex justify-content-center">
                                            <img width="250" height="300" id="img_bank" accept="image/*"
                                                src="{{ asset('frontend/images/250x300.png') }}" />
                                        </div>

                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6 col-xl-4">
                                                <label for="" class="form-label">Bank <span
                                                        class="text-danger bank_name_err _err "></span></label>
                                                <select name="bank_name" class="form-select" id="">
                                                    <option selected disabled>Select Bank</option>

                                                    @foreach ($bank as $value_bank)
                                                        <option value="{{ $value_bank->id }}">{{ $value_bank->bank_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-xl-4">
                                                <label for="" class="form-label">Branch <span
                                                        class="text-danger bank_branch_err _err "></span></label>
                                                <input type="text" name="bank_branch" class="form-control"
                                                    id="">
                                            </div>
                                            <div class="col-md-6 col-xl-4">
                                                <label for="" class="form-label">Account Number <span
                                                        class="text-danger small bank_no_err _err">*
                                                        (Only enter numbers)</span></label>
                                                <input type="text" name="bank_no" minlength="10" maxlength="12"
                                                    class="form-control" id="">
                                            </div>
                                            <div class="col-md-6 col-xl-12 mb-3">
                                                <label for="" class="form-label">Account Name <span
                                                        class="text-danger account_name_err _err "></span></label>
                                                <input type="text" name="account_name" class="form-control"
                                                    id="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="borderR10 py-2 px-3 bg-purple3 bg-opacity-50 h5 mb-3">Beneficiary</div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                                            <i class='bx bxs-error me-2'></i>
                                            <div>
                                                If not filled, the beneficiary will be considered as the legal beneficiary.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <label for="" class="form-label">First Name <span
                                                class="text-danger name_benefit_err _err "></span></label>
                                        <input type="text" name="name_benefit" class="form-control" id="">
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <label for="" class="form-label">Last Name <span
                                                class="text-danger last_name_benefit_err _err "></span></label>
                                        <input type="text" name="last_name_benefit" class="form-control"
                                            id="">
                                    </div>
                                    <div class="col-md-6 col-xl-4 mb-3">
                                        <label for="" class="form-label">Relationship <span
                                                class="text-danger involved_err _err "></span></label>
                                        <input type="text" name="involved" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-12 text-center">
                                        <hr>
                                        <p onclick="alert_summit()" class="btn btn-success rounded-pill">Register</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection




@section('script')
    {{-- sweetalert2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $('#linkMenuTop .nav-item').eq(0).addClass('active');
    </script>
    <script>
        function isThaichar(str, obj) {
            var orgi_text = "1234567890";
            var str_length = str.length;
            var str_length_end = str_length - 1;
            var isThai = true;
            var Char_At = "";
            for (i = 0; i < str_length; i++) {
                Char_At = str.charAt(i);
                if (orgi_text.indexOf(Char_At) == -1) {
                    isThai = false;
                }
            }
            if (str_length >= 1) {
                if (isThai == false) {
                    obj.value = str.substr(0, str_length_end);
                }
            }
        }
    </script>



    <script>
        function printErrorMsg(msg) {
            console.log(msg);
            $('._err').text('');
            $.each(msg, function(key, value) {
                $('.' + key + '_err').text(`*${value}*`);
            });
        }

        function clear_sponser() {
            $('#sponser').val('');
            $('#sponser_name').val('');
        }

        $('#sponser').change(function() {
            sponser = $(this).val();
            if (sponser == '') {
                return;
            }
            $.ajax({
                    url: '{{ route('check_sponser') }}',
                    type: 'GET',
                    data: {
                        sponser: sponser,
                        user_name: '{{ Auth::guard('c_user')->user()->user_name }}'
                    },
                })
                .done(function(data) {

                    if (data['status'] == 'fail') {

                        Swal.fire({
                            icon: 'error',
                            title: data['message'],
                        })

                        $('#sponser').val('');
                        $('#sponser_name').val('');


                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: data['data']['name'] + data['data']['last_name'] + ' (' + data[
                                'data'][
                                'user_name'
                            ] + ')',
                            text: data['message'],
                        })

                        sponser_name = data['data']['name'] + data['data']['last_name'];
                        $('#sponser_name').val(sponser_name);

                    }

                    console.log(data);
                })
                .fail(function() {
                    console.log("error");
                })
        })

        function alert_summit() {


            Swal.fire({
                title: 'สัญญาตั้งตัวแทนจำหน่ายสินค้าหรือผลิตภัณฑ์ ของ VRICH Global Co.,LTD',
                html: `    <div class="row info_alert">
        <div class="col-12 overflow-auto">
            <p style="font-size: 12px;" > ในเว็บไซต์ https://www.vrichglobal.com ระบบแพลตฟอร์ม VRICH SYSTEM
อันเป็นการทำสัญญาและธุรกรรมทางอิเล็กทรอนิกส์ ตามกฎหมายว่าด้วยธุรกรรมทางอิเล็กทรอนิกส์
ข้าพเจ้าซึ่งเป็นบุคคลดังมีชื่อ นามสกุล อายุ ที่อยู่ อาชีพ หมายเลขโทรศัพท์ หมายเลขประจำตัว ประชาชน หมายเลขหนังสือเดินทาง และหรือข้อมูลอื่นใดที่ได้ลงทะเบียนหรือระบุรายละเอียดลงไว้ในระบบ ระบบคอมพิวเตอร์ แพลตฟอร์ม เว็บไซต์ และหรือทางสื่ออื่นใดของ VRICH Global Co.,LTD (ซึ่งต่อไปใน สัญญานี้จะเรียกว่า“บริษัท”) ที่เกี่ยวกับการสมัคร การทำสัญญา หรือการขอสมัครเป็นตัวแทนจำหน่าย สินค้าหรือตัวแทนจำหน่ายผลิตภัณฑ์ของบริษัท และตามเอกสารหลักฐานและภาพถ่ายของข้าพเจ้าที่ได้ นำเข้าสู่ระบบ ระบบคอมพิวเตอร์ แพลตฟอร์ม เว็บไซต์ และหรือนำเข้าทางสื่ออื่นใดของบริษัทดังกล่าว โดย การอัปโหลด (Upload) หรือโดยวิธีการอื่นใดทั้งหมด ไม่ว่าข้าพเจ้าจะได้กระทำการหรือดำเนินการดังกล่าว โดยตนเอง หรือโดยการใช้ จ้าง วาน ให้ความยินยอม หรือโดยมอบหมายให้ผู้อื่นกระทำการหรือดำเนินการ ดังกล่าว หรือโดยให้ผู้อื่นกระทำการหรือดำเนินการแทนในฐานะเป็นตัวแทน หรือโดยให้ผู้อื่นช่วยกระทำการ หรือดำเนินการให้ หรือกระทำโดยวิธีอื่นใด ทั้งนี้ เพื่อให้ข้อมูล ภาพถ่าย และเอกสารหลักฐานของข้าพเจ้า ดังกล่าวมาข้างต้นทั้งหมด รวมทั้งข้อมูล ภาพถ่าย และเอกสารหลักฐานของบุคคลซึ่งเกี่ยวข้อง ถูกนำเข้าสู่ ระบบ ระบบคอมพิวเตอร์ แพลตฟอร์ม เว็บไซต์ และหรือนำเข้าทางสื่ออื่นใดของบริษัท ในการตรวจสอบ ความถูกต้องของบุคคล การพิสูจน์ การแสดงและยืนยันตัวตนบุคคลของข้าพเจ้าตามกฎหมาย โดยให้ถือ เสมือนว่าข้าพเจ้าได้กระทำการดังกล่าวมาข้างต้นนี้ด้วยตนเองทั้งสิ้น ข้าพเจ้ายินยอมรับผิดชอบทุกประการ
ข้าพเจ้าทราบและเข้าใจเป็นอย่างดีและขอยืนยันว่า ในการสมัครทำสัญญาตัวแทนจำหน่ายสินค้า หรือผลิตภัณฑ์ของบริษัทนี้ ข้าพเจ้าได้ศึกษาและได้อ่านเงื่อนไขและข้อตกลงในสัญญานี้โดยละเอียด ได้มี การซักถามข้อสงสัยจนเป็นที่เข้าใจดีแล้ว ไม่มีบุคคลใดบังคับ ขู่เข็ญ หลอกลวง โน้มน้าว ชักจูง หรือกระทำ โดยวิธีอื่นใดที่ไม่ชอบด้วยกฎหมายหรือขัดต่อความสงบเรียบร้อยหรือศีลธรรมอันดีของประชาชน เพื่อให้ ข้าพเจ้าสมัครทำสัญญาโดยปราศจากความสมัครใจและความยินยอมของข้าพเจ้าอย่างแท้จริงแต่อย่างใด โดยข้าพเจ้าจะไม่ยกเหตุเรื่องการที่ไม่ได้อ่าน ไม่ได้ศึกษา และไม่เข้าใจในข้อสัญญานี้ มาเป็นข้ออ้าง ข้อเถียง ข้อโต้แย้ง และหรือข้อปฏิเสธต่อบริษัทในอันที่จะไม่ปฏิบัติตามสัญญากับบริษัท และในอันที่จะไม่ยอมรับให้ มีผลผูกพันกับข้าพเจ้า ไม่ว่าในกรณีใด ๆ ทั้งสิ้น
ข้าพเจ้าทราบและเข้าใจเป็นอย่างดีว่า หากข้าพเจ้าไม่เห็นด้วยกับเงื่อนไข ข้อสัญญา ข้อผูกพัน ข้อตกลง ข้อจำกัด ข้อความ และหรือข้อกำหนดทั้งหลาย บรรดาที่ระบุไว้ในสัญญาตั้งตัวแทนจำหน่ายสินค้า หรือผลิตภัณฑ์ของบริษัทนี้ ไม่ว่าข้อใดข้อหนึ่ง ส่วนใดส่วนหนึ่ง หรือทั้งหมด ไม่ว่าจะเป็นข้อสัญญาที่ไม่เป็น ธรรมหรือไม่ว่าจะด้วยเหตุผลใดก็ตาม ข้าพเจ้ามีสิทธิและมีอิสระเต็มที่ตั้งแต่ต้นในการที่จะยกเลิก ระงับ ยับยั้ง ยุติ และหรือปฏิเสธไม่สมัครทำสัญญานี้ทั้งหมดต่อไป ไม่ยืนยันข้อตกลง ไม่แสดงการยอมรับ ไม่กดปุ่ม สัญลักษณ์หรือลงลายมือชื่อในสัญญาหรือในแพลตฟอร์ม รวมถึงมีสิทธิและมีอิสระเต็มที่ตั้งแต่ต้นที่จะไม่ ดำเนินการหรือกระทำการต่าง ๆ ซึ่งจะทำให้การสมัครทำสัญญานี้มีผลทางกฎหมายหรือมีผลในทางใดทาง หนึ่งที่จะผูกพันข้าพเจ้าตามกฎหมายต่อไป</p>

        </div>
    </div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยอมรับข้อตกลง',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_register').submit();
                }
            })
        }


        //BEGIN form_register
        $('#form_register').submit(function(e) {
            Swal.fire({
                title: 'รอสักครู่...',
                html: 'ระบบกำลังทำรายการกรุณาอย่าปิดหน้านี้จนกว่าระบบจะทำรายการเสร็จ...',
                didOpen: () => {
                    Swal.showLoading()
                },
            })

            e.preventDefault();
            var formData = new FormData($(this)[0]);
            // console.log(formData);



            $.ajax({
                url: '{{ route('store_register') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.close();
                    if (data.pvalert) {
                        Swal.fire({
                            icon: 'warning',
                            title: data['pvalert'],
                        })
                    }
                    if ($.isEmptyObject(data.error) || data.status == "success") {
                        alert_result(data.data_result);
                    }

                    if (data.ms) {

                        Swal.fire({
                            icon: 'warning',
                            title: data.ms,
                        })
                        printErrorMsg(data.error);
                    }
                }
            });
        });
        //END form_register

        $('#sizebusiness').change(function() {
            val = $(this).val();
            $.ajax({
                url: '{{ route('pv') }}',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    val: val
                },
                success: function(data) {
                    // $('#pv').val(data)
                }
            });
        })
    </script>

    {{-- BEGIN create --}}
    <script>
        function alert_result(data) {
            if (data) {
                var html = `
            <div class="overflow-hidden " >
            <div class="row">
                <div class="col-12 text-right">Name: ${data.prefix_name}${data.name} ${data.last_name}</div>
                <div class="col-12 text-right">Business Name: ${data.business_name}</div>
                <hr class="mt-3">
                <div class="col-12 text-right">Username: ${data.user_name}</div>
                <div class="col-12 text-right">Password: ${data.password}</div>
            </div>
        </div>
            `
                Swal.fire({
                    title: 'Membership registration successful',
                    html: html,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ปิด',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('home') }}";
                    }
                })
            }
        }
    </script>
    {{-- END create --}}

    {{-- BEGIN  Preview image --}}
    <script>
        file_card.onchange = evt => {
            const [file] = file_card.files
            if (file) {
                img_card.src = URL.createObjectURL(file)
            }
        }

        file_bank.onchange = evt => {
            const [file] = file_bank.files
            if (file) {
                img_bank.src = URL.createObjectURL(file)
            }
        }
    </script>

    {{-- END  Preview image --}}

    {{-- BEGIN Action same_address --}}
    <script>
        $('#status_address').click(function() {

            if (this.checked) {

                $('.card_address').each(function(key) {
                    $('.address_same_card').eq(key).val($(this).val()).attr('readonly', true);
                    $("#same_district").attr('disabled', false);
                    $("#same_tambon").attr('disabled', false);
                    $('#same_district,#same_tambon,#same_province').addClass('disabled_select')
                });
            } else {
                $('.address_same_card').val('').attr('readonly', false);
                $("#same_district").attr('disabled', true);
                $("#same_tambon").attr('disabled', true);
                $('#same_district,#same_tambon,#same_province').removeClass('disabled_select')

            }
        });
    </script>
    {{-- END Action same_address --}}

    {{-- --------------------- Address Card  --------------------- --}}
    <script>
        // BEGIN province
        $("#province").change(function() {
            let province_id = $(this).val();
            $.ajax({
                url: '{{ route('getDistrict') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    province_id: province_id,
                },
                success: function(data) {
                    $("#district").children().remove();
                    $("#tambon").children().remove();
                    $("#district").append(` <option value="">--please select--</option>`);
                    $("#tambon").append(` <option value="">--please select--</option>`);
                    $("#zipcode").val("");
                    data.forEach((item) => {
                        $("#district").append(
                            `<option value="${item.id}">${item.name_th}</option>`
                        );
                        $("#same_district").append(
                            `<option value="${item.id}">${item.name_th}</option>`
                        );
                    });
                    $("#district").attr('disabled', false);
                    $("#tambon").attr('disabled', true);
                },
                error: function() {}
            })
        });
        // END province

        // BEGIN district
        $("#district").change(function() {
            let district_id = $(this).val();

            $.ajax({
                url: '{{ route('getTambon') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    district_id: district_id,
                },
                success: function(data) {
                    $("#tambon").children().remove();
                    $("#tambon").append(` <option value="">--please select--</option>`);
                    $("#zipcode").val("");
                    data.forEach((item) => {
                        $("#tambon").append(
                            `<option value="${item.id}">${item.name_th}</option>`
                        );
                        $("#same_tambon").append(
                            `<option value="${item.id}">${item.name_th}</option>`
                        );
                    });
                    $("#tambon").attr('disabled', false);
                },
                error: function() {}
            })
        });
        // BEGIN district

        //  BEGIN tambon
        $("#tambon").change(function() {
            let tambon_id = $(this).val();
            $.ajax({
                url: '{{ route('getZipcode') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    tambon_id: tambon_id,
                },
                success: function(data) {
                    $("#zipcode").val(data.zipcode);
                },
                error: function() {}
            })
        });
        //  END tambon
    </script>
    {{-- --------------------- Address Card --------------------- --}}

    {{-- --------------------- Address shipping  --------------------- --}}
    <script>
        // BEGIN province
        $("#same_province").change(function() {
            let province_id = $(this).val();
            $.ajax({
                url: '{{ route('getDistrict') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    province_id: province_id,
                },
                success: function(data) {
                    $("#same_district").children().remove();
                    $("#same_tambon").children().remove();
                    $("#same_district").append(` <option value="">--please select--</option>`);
                    $("#same_tambon").append(` <option value="">--please select--</option>`);
                    $("#same_zipcode").val("");
                    data.forEach((item) => {
                        $("#same_district").append(
                            `<option value="${item.id}">${item.name_th}</option>`
                        );
                    });
                    $("#same_district").attr('disabled', false);
                    $("#same_tambon").attr('disabled', true);

                },
                error: function() {}
            })
        });
        // END province

        // BEGIN district
        $("#same_district").change(function() {
            let district_id = $(this).val();
            $.ajax({
                url: '{{ route('getTambon') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    district_id: district_id,
                },
                success: function(data) {
                    $("#same_tambon").children().remove();
                    $("#same_tambon").append(` <option value="">--please select--</option>`);
                    $("#same_zipcode").val("");
                    data.forEach((item) => {
                        $("#same_tambon").append(
                            `<option value="${item.code}">${item.name_th}</option>`
                        );
                    });
                    $("#same_tambon").attr('disabled', false);
                },
                error: function() {}
            })
        });
        // BEGIN district

        //  BEGIN tambon
        $("#same_tambon").change(function() {
            let tambon_id = $(this).val();
            $.ajax({
                url: '{{ route('getZipcode') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    tambon_id: tambon_id,
                },
                success: function(data) {
                    $("#same_zipcode").val(data.zipcode);
                },
                error: function() {}
            })
        });
        //  END tambon
    </script>

    {{-- --------------------- Address shipping --------------------- --}}

    <script>
        $('#nation_id').change(function() {
            $('span.error').removeClass('true').text('');
            value = $(this).val();
            if (value != "1") {
                $('#id_card').attr('maxlength', '15');
                $('#id_card').val("");
            } else {
                $('#id_card').attr('maxlength', '13');
                $('#id_card').val("");
            }
        })


        $(document).ready(function() {


            $('#id_card').on('keyup', function() {
                nation_id = $('#nation_id').val();
                if (nation_id == 1) {
                    if ($.trim($(this).val()) != '' && $(this).val().length == 13) {
                        id = $(this).val().replace(/-/g, "");
                        var result = Script_checkID(id);
                        if (result === false) {
                            id_card = $('#id_card').val();
                            $('span.error').removeClass('true').text('เลขบัตร' + id_card + ' ไม่ถูกต้อง');
                            $('#id_card').val('');
                        } else {
                            // $('span.error').addClass('true').text('เลขบัตรถูกต้อง');
                        }
                    } else {
                        $('span.error').removeClass('true').text('');

                    }

                }

            })
        });

        function Script_checkID(id) {
            if (!IsNumeric(id)) return false;
            if (id.substring(0, 1) == 0) return false;
            if (id.length != 13) return false;
            for (i = 0, sum = 0; i < 12; i++)
                sum += parseFloat(id.charAt(i)) * (13 - i);
            if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12))) return false;
            return true;
        }

        function IsNumeric(input) {
            var RE = /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
            return (RE.test(input));
        }
    </script>
@endsection
