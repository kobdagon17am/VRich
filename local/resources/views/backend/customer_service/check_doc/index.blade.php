@extends('layouts.backend.app_new')

@section('head_text')
<nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Customer Service</a></li>
        <li class="breadcrumb-item active" aria-current="page">ระบบบริการสมาชิก</li>
    </ol>
</nav>
@endsection

@section('css')
    <style>
        .icon_size {
            font-size: 28px;
        }
    </style>
@endsection


@section('content')

            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <div class="">
                        <label for="" class="mr-2 text-slate-500">แก้ไขข้อมูลจากรหัสสมาชิก</label>
                        <div class="form-inline ">
                            <form id="href_username" method="post">
                                @csrf
                                <input type="text" name="user_name" class="form-control w-56 mt-2"
                                    placeholder="รหัสผู้ใช้">
                                <button type="submit" class="btn btn-success text-white ml-2 btn-sm  ">
                                    <i class="fa-solid fa-right-to-bracket mr-2"></i> ตกลง</button>
                            </form>
                        </div>
                    </div>

                    <div class="hidden md:block mx-auto text-slate-500"></div>
                    <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    </div>
                </div>


                <div class="row intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2">

                        <div class="col-md-4 col-lg-4  items-center sm:mr-4">
                        <div class="col-span-4 sm:col-span-4">

                            <label for="modal-datepicker-1" class="form-label">รหัสสมาชิก</label>
                            <div class=" relative text-slate-500">
                            <div class="form-inline">

                                <input type="text" name="user_name_2" id="user_name_2" class="form-control w-56 box pr-10 myLike "
                                    placeholder="รหัสสมาชิก...">
                                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                            </div>
                            </div>
                         </div>
                        </div>

                        <div class="col-md-4 col-lg-4  items-center sm:mr-4">
                            <div class="col-span-4 sm:col-span-4">

                                <label for="modal-datepicker-1" class="form-label">รหัสบัตรประชาชน</label>
                                <div class=" relative text-slate-500">
                                    <div class="form-inline">

                                        <input type="text" name="id_card" id="id_card" class="form-control w-56 box pr-10 myLike "
                                            placeholder="รหัสบัตรประชาชน">
                                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                                    </div>
                                </div>
                             </div>
                            </div>


                        <div class="col-md-4 col-lg-4  items-center sm:mr-4">
                            <div class="col-span-4 sm:col-span-4">

{{--
                                <div class=" relative text-slate-500">
                                    <div class="form-inline">

                                        <button id="search-form" type="button"
                                class="btn btn-primary w-full sm:w-16 mt-6">ค้นหา</button>
                                    </div>
                                </div> --}}
                             </div>
                            </div>





                </div>
                <!-- BEGIN: Data List -->
                <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <table id="check_doc" class="table table-report -mt-2">
                    </table>
                </div>
                <!-- END: Data List -->
            </div>




    <!-- BEGIN: Modal info_card -->
    <div id="info_card" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">ตรวจสอบเอกสาร</h2>
                    <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-400"></i>
                    </a>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body">
                    <div class="info_detail_card_null">
                        <h2 class="text-xl  text-center h-24 ">รอสมาชิกส่งข้อมูลมาใหม่</h2>
                    </div>

                    <div class="info_detail_card grid grid-cols-12 lg:col-span-12 gap-4 gap-y-3">
                        <div class="col-span-4 lg:col-span-4 my-auto">
                            <img id="img_crad" src="https://via.placeholder.com/300x300.png?text=card" alt="">
                        </div>
                        <div class="col-span-8 lg:col-span-8">
                            <div class="grid grid-cols-12 lg:col-span-12 gap-3  mx-auto">
                                <div class="col-span-12">
                                    <div> <label for="address" class="form-label">ที่อยู่</label> <input id="address"
                                            type="text" class="form-control" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-span-4">
                                    <div> <label for="moo" class="form-label">หมู่</label>
                                        <input id="moo" type="text" class="form-control" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-span-4">
                                    <div> <label for="soi" class="form-label">ซอย</label>
                                        <input id="soi" type="text" class="form-control" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-span-4">
                                    <div> <label for="road" class="form-label">ถนน</label> <input id="road"
                                            type="text" class="form-control" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-span-4">
                                    <div> <label for="province" class="form-label">จังหวัด</label> <input id="province"
                                            type="text" class="form-control" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-span-4">
                                    <div> <label for="district" class="form-label">อำเภอ/เขต</label> <input id="district"
                                            type="text" class="form-control" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-span-4">
                                    <div> <label for="rtambon" class="form-label">ตำบล</label>
                                        <input id="tambon" type="text" class="form-control" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-span-4">
                                    <div> <label for="zipcode" class="form-label">รหัสไปรษณีย์</label> <input
                                            id="zipcode" type="text" class="form-control" value="54313" readonly>
                                    </div>
                                </div>
                                <div class="col-span-4">
                                    <div> <label for="phone" class="form-label">เบอร์มือถือ</label> <input
                                            id="phone" type="text" class="form-control" value="" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <div class="grid grid-cols-12 gap-3  mx-auto">
                        <div class="col-span-10">
                            <form class="action_card_doc" method="post">
                                @csrf
                                <input type="hidden" name="user_name" class="user_name">
                                <input type="hidden" name="status" value="4">
                                <button type="submit" data-tw-dismiss="modal"
                                    class="btn btn-outline-danger w-20 mr-1">ไม่ผ่าน</button>
                            </form>
                        </div>
                        <div class="col-span-2 mr-2">
                            <form class="action_card_doc" method="post">
                                @csrf
                                <input type="hidden" name="user_name" class="user_name">
                                <input type="hidden" name="status" value="1">
                                <button type="submit" class="btn btn-outline-success  w-20">ผ่าน</button>
                            </form>
                        </div>
                    </div> <!-- END: Modal Footer -->
                </div>
            </div>
        </div> <!-- END: Modal info_card -->
    </div>



        <!-- BEGIN: Modal info_bank -->
        <div id="info_bank" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">ตรวจสอบเอกสาร</h2>
                        <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                                class="w-8 h-8 text-slate-400"></i>
                        </a>
                    </div> <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->
                    <div class="modal-body">
                        <div class="info_detail_card_null">
                            <h2 class="text-xl  text-center h-24 ">รอสมาชิกส่งข้อมูลมาใหม่</h2>
                        </div>

                        <div class="info_detail_card grid grid-cols-12 lg:col-span-12  gap-4 gap-y-3">
                            <div class="col-span-4 lg:col-span-4 my-auto">
                                <img id="img_bank" src="https://via.placeholder.com/300x300.png?text=card"
                                    alt="">
                            </div>
                            <div class="col-span-8 lg:col-span-8">
                                <div class="grid grid-cols-12 gap-3  mx-auto">
                                    <div class="col-span-12">
                                        <div> <label for="name" class="form-label">ธนาคาร</label> <input
                                                id="name" type="text" class="form-control" value=""
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-span-6">
                                        <div> <label for="bank_branch" class="form-label">สาขา</label>
                                            <input id="bank_branch" type="text" class="form-control" value=""
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-span-6">
                                        <div> <label for="bank_no" class="form-label">เลขบัญชี</label>
                                            <input id="bank_no" type="text" class="form-control" value=""
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-span-12">
                                        <div> <label for="account_name" class="form-label">ชื่อบัญชี</label> <input
                                                id="account_name" type="text" class="form-control" value=""
                                                readonly>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div> <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <div class="grid grid-cols-12 gap-3  mx-auto">
                            <div class="col-span-10">
                                <form class="action_bank_doc" method="post">
                                    @csrf
                                    <input type="hidden" name="user_name" class="user_name">
                                    <input type="hidden" name="status" value="4">
                                    <button type="submit" data-tw-dismiss="modal"
                                        class="btn btn-outline-danger w-20 mr-1">ไม่ผ่าน</button>
                                </form>

                            </div>
                            <div class="col-span-2 mr-2">
                                <form class="action_bank_doc" method="post">
                                    @csrf
                                    <input type="hidden" name="user_name" class="user_name">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-outline-success  w-20">ผ่าน</button>
                                </form>

                            </div>
                        </div>

                    </div> <!-- END: Modal Footer -->
                </div>
            </div>
        </div> <!-- END: Modal info_bank -->
    @endsection




    @section('script')

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
        {{-- BEGIN data_table_branch --}}
        @include('backend.customer_service.check_doc.data_tabel_check_doc')
        {{-- END data_table_branch --}}

        <script>
            function admin_login_user(id) {
                window.open(`admin_login_user/${id}`);
            }
        </script>


        <script>
            $('.action_card_doc').submit(function(e) {
                const myModal = tailwind.Modal.getInstance(document.querySelector("#info_card"));
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: '{{ route('action_card_doc') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if ($.isEmptyObject(data.error) || data.status == "success") {
                            myModal.hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'ทำรายการสำเร็จ',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'ปิด',

                            }).then((result) => {
                                check_doc.draw();
                            })
                        }
                    }
                });
            });
        </script>

        <script>
            $('.action_bank_doc').submit(function(e) {
                const myModal = tailwind.Modal.getInstance(document.querySelector("#info_bank"));
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: '{{ route('action_bank_doc') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if ($.isEmptyObject(data.error) || data.status == "success") {
                            myModal.hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'ทำรายการสำเร็จ',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'ปิด',

                            }).then((result) => {
                                check_doc.draw();
                            })
                        }
                    }
                });
            });
        </script>

        <script>
            $('#href_username').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    type: 'post',
                    url: '{{ route('search_username') }}',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == "success") {
                            window.open(`info_customer/${data.data.id}`);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ไม่พบรหัสผู้ใช้งาน',
                                text: 'กรุณาทำรายการใหม่อีกครั้ง',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'ตกลง',
                            });
                        }
                    },
                });
            });
        </script>
    @endsection
