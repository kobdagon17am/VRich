@extends('layouts.backend.app_new')



@section('head')
    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('css')

@endsection

@section('head_text')
    <nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">คลังสินค้า</a></li>
            <li class="breadcrumb-item active" aria-current="page">รับสินค้าเข้า</li>
        </ol>
    </nav>
@endsection
@section('content')

    <div class="grid grid-cols-12 gap-5">
        <div class="col-span-12 ">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4">

                <div class="">
                    <button onclick="resetForm()" class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal"
                        data-tw-target="#add_product">
                        รับสินค้าเข้า</button>
                </div>
                <div class="">
                    <div class="form-inline ">
                        <label for="" class="mr-1 ml- text-slate-500 ">คลัง : </label>

                        <select id="branch_select_filter" class="js-example-basic-single w-56 branch_select myWhere"
                            name="branch_id_fk">
                            <option value="0">ทั้งหมด</option>
                            @foreach ($branch as $val)
                                <option value="{{ $val->id }}">{{ $val->b_code }}::{{ $val->b_name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="" class="mr-1 ml-2 text-slate-500 ">สาขา : </label>

                        <select id="warehouse_select_filter" class="js-example-basic-single w-56 warehouse_select myWhere"
                            name="warehouse_id_fk" disabled>
                            <option value="0">ทั้งหมด</option>
                        </select>

                    </div>
                </div>
                <div class="hidden md:block mx-auto text-slate-500"></div>
                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">

                    <div class=" relative text-slate-500">
                        <div class="form-inline">
                            <label for="" class="mr-2">ค้นหารหัสสาขา</label>
                            <input type="text" name="b_code" class="form-control w-56 box pr-10 myLike "
                                placeholder="ค้นหา...">
                            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                        </div>
                    </div>

                </div>
            </div>


            <h2 class="text-lg font-medium mr-auto mt-2">อนุมัติรับสินค้าเข้า</h2>

            <div class="table-responsive">

                <table id="table_receive" class="table table-report">
                </table>

            </div>


            <hr>
            <div class="table-responsive">

            <h2 class="text-lg font-medium mr-auto mt-2">รายการรับเข้าสินค้า</h2>
            <table id="table_receive_confirm" class="table table-report">
            </table>
            </div>


        </div>

    </div>







    <div id="add_product" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="form_add_product" method="post" enctype="multipart/form-data" >
                    @csrf
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">รับเข้าสินค้า</h2>
                        <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                                class="w-8 h-8 text-slate-400"></i>
                        </a>
                    </div> <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3 bg-slate-100/50">
                        <div class="col-span-12 ">
                            <div class="grid grid-cols-12 gap-5">
                                <div class="col-span-6 col-md-6 col-lg-6 ">
                                    <label for="">สาขา</label>
                                    <span class="form-label text-danger branch_id_fk_err _err"></span>
                                    <select class="js-example-basic-single branch_select form-control" name="branch_id_fk" >
                                        <option selected disabled>==== เลือกสาขา ====</option>
                                        @foreach ($branch as $val)
                                            <option value="{{ $val->id }}">{{ $val->b_code }}::{{ $val->b_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class=" col-span-6">
                                    <label for="">คลัง</label>
                                    <span class="form-label text-danger warehouse_id_fk_err _err"></span>
                                    <select class="js-example-basic-single warehouse_select form-control"
                                        name="warehouse_id_fk" disabled>
                                        <option selected disabled>==== เลือกคลัง ====</option>
                                    </select>
                                </div>

                                <div class=" col-span-6">
                                    <label for="">สินค้า</label>
                                    <span class="form-label text-danger product_id_fk_err _err"></span>
                                    <select id="product_select" class="js-example-basic-single form-control"
                                        name="product_id_fk" disabled>

                                        <option selected disabled>==== เลือกสินค้า ====</option>
                                        @foreach ($product as $key => $val)


                                            <option value="{{ $val->id }}">{{ $key + 1 }} .
                                                {{ $val->product_name }}
                                            </option>




                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="grid grid-cols-12 gap-5">
                                    <div class="col-span-3">
                                        <label for="amt" class="form-label">จำนวน</label>
                                        <span class="form-label text-danger amt_err _err"></span>
                                        <input id="amt" type="number" min="1" class="form-control "
                                            name="amt" placeholder="จำนวน">
                                    </div>

                                    <div class="col-span-3">
                                        <label for="unit" class="form-label">หน่วย</label>
                                        <select id="unit" name="unit" class="form-control">
                                            @foreach ($pro_unit as $key => $val)
                                            <option value="{{ $val->product_unit_id }}">
                                                {{ $val->product_unit }}
                                            </option>
                                        @endforeach

                                        </select>
                                    </div>


                                    <div class=" col-span-6">
                                        <label for="doc_no" class="form-label">เลขที่เอกสาร</label>
                                        <span class="form-label text-danger doc_noe_rr _err"></span>
                                        <input id="doc_no" type="text" class="form-control " name="doc_no"
                                            placeholder="เลขที่เอกสาร" value="{{ $code }}">

                                    </div>
                                    <div class=" col-span-4">
                                        <label for="doc_date" class="form-label">วันที่เอกสาร</label>
                                        <span class="form-label text-danger doc_date_err _err"></span>
                                        <input id="doc_date" type="date" class="form-control "
                                            value="{{ date('Y-m-d') }}" name="doc_date" placeholder="วันที่เอกสาร">
                                    </div>
                                    <div class=" col-span-6">
                                        <label for="lot_number" class="form-label">หมายเลขล็อตสินค้า</label>
                                        <span class="form-label text-danger lot_number_err _err"></span>
                                        <input id="lot_number" type="text" class="form-control" value="{{date('Ymd')}}"  name="lot_number"
                                            placeholder="หมายเลขล็อตสินค้า">
                                    </div>
                                    <div class=" col-span-6">
                                        <label for="lot_expired_date" class="form-label">วันหมดอายุ</label>
                                        <span class="form-label text-danger lot_expired_date_err _err"></span>
                                        <input id="lot_expired_date" type="date" class="form-control "
                                            name="lot_expired_date" placeholder="วันหมดอายุ">
                                    </div>


                                </div>
                            </div>


                            <div class="mt-4">
                                <label for="file" class="form-label">เอกสาร</label>

                                <div class="intro-y box mt-5">

                                    <div id="multiple-file-upload" class="p-5">
                                        <div class="preview">

                                                <div class="fallback">
                                                    <input name="file" type="file" multiple/>
                                                </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal"
                            class="btn btn-outline-danger w-20 mr-1">ยกเลิก</button>
                        <button type="submit" class="btn btn-outline-success  w-20">ตกลง</button>
                    </div> <!-- END: Modal Footer -->

                </form>
            </div>

        </div>
    </div>



    <div id="add_product_confirm" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{route('receive/form_add_product_confirm')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">อนุมัติรายการรับเข้าสินค้า</h2>
                        <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                                class="w-8 h-8 text-slate-400"></i>
                        </a>
                    </div> <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->
                    <input type="hidden" id="stock_lot_id" name="stock_lot_id">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3 bg-slate-100/50">
                        <div class="col-span-12 ">
                            <div class="grid grid-cols-12 gap-5">
                                <div class="col-span-6 col-md-6 col-lg-6 ">
                                    <label for="">สาขา</label>

                                    <input  type="text" class="form-control" id="c_branch" value="">

                                </div>
                                <div class=" col-span-6">
                                    <label for="">คลัง</label>
                                    <span class="form-label text-danger   _err"></span>
                                    <select class="js-example-basic-single   form-control"
                                        disabled>
                                        <option selected disabled>==== เลือกคลัง ====</option>
                                    </select>
                                </div>

                                <div class=" col-span-6">
                                    <label for="">สินค้า</label>
                                    <span class="form-label text-danger _err"></span>
                                    <select class="js-example-basic-single form-control"
                                          disabled>

                                        <option selected disabled>==== เลือกสินค้า ====</option>



                                            <option value="">
                                             1111
                                            </option>

                                    </select>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="grid grid-cols-12 gap-5">
                                    <div class="col-span-3">
                                        <label for="amt" class="form-label">จำนวน</label>
                                        <span class="form-label text-danger amt_err _err"></span>
                                        <input   type="number" min="1" class="form-control "
                                            placeholder="จำนวน">
                                    </div>

                                    <div class="col-span-3">
                                        <label for="unit" class="form-label">หน่วย</label>
                                        <select class="form-control">

                                            <option value="">
                                               fff
                                            </option>

                                        </select>
                                    </div>


                                    <div class=" col-span-6">
                                        <label for="doc_no" class="form-label">เลขที่เอกสาร</label>
                                        <span class="form-label text-danger doc_noe_rr _err"></span>
                                        <input  type="text" class="form-control "
                                            placeholder="เลขที่เอกสาร" value="{{ $code }}">

                                    </div>
                                    <div class=" col-span-4">
                                        <label for="doc_date" class="form-label">วันที่เอกสาร</label>
                                        <span class="form-label text-danger doc_date_err _err"></span>
                                        <inpu  type="date" class="form-control "
                                            value="{{ date('Y-m-d') }}"  placeholder="วันที่เอกสาร">
                                    </div>
                                    <div class=" col-span-6">
                                        <label for="lot_number" class="form-label">หมายเลขล็อตสินค้า</label>
                                        <span class="form-label text-danger lot_number_err _err"></span>
                                        <input   type="text" class="form-control" value="{{date('Ymd')}}"
                                            placeholder="หมายเลขล็อตสินค้า">
                                    </div>
                                    <div class=" col-span-6">
                                        <label for="lot_expired_date" class="form-label">วันหมดอายุ</label>
                                        <span class="form-label text-danger _err"></span>
                                        <input  type="date" class="form-control "
                                              placeholder="วันหมดอายุ">
                                    </div>


                                        <div class=" col-span-6">
                                            <label for="lot_expired_date" class="form-label">เอกสาร</label>
                                            <span class="form-label text-danger   _err"></span>

                                        </div>

                                        <div class="col-span-6">
                                            <label for=" " class="form-label">รายละเอียด</label>

                                            <textarea class="form-control"  placeholder="รายละเอียด"> </textarea>
                                        </div>



                                </div>
                            </div>


                        </div>
                    </div> <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        {{-- <button type="submit" data-tw-dismiss="modal"
                            class="btn btn-outline-danger w-20 mr-1">ยกเลิกรายการ</button> --}}
                        <button type="submit"
                            class="btn btn-outline-danger w-20 mr-1"  name="type" value="cancle">ยกเลิกรายการ</button>
                        <button type="submit" class="btn btn-outline-success w-20" name="type" value="confirm">อนุมัติรายการ</button>
                    </div> <!-- END: Modal Footer -->

                </form>
            </div>

        </div>
    </div>



    <!-- END: Modal add_product-->
@endsection



@section('script')
    {{-- select2 --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {

            $('.branch_select').select2({
                dropdownParent: $('#add_product')
            });
            $('#branch_select_filter').select2();

            $('.warehouse_select').select2({
                dropdownParent: $('#add_product')
            });
            $('#warehouse_select_filter').select2();
            $('#product_select').select2({
                dropdownParent: $('#add_product')
            });


        });
    </script>

    <script>
        $('.branch_select').change(function() {
            $('.warehouse_select').prop('disabled', false);

            const id = $(this).val();
            $.ajax({
                url: '{{ route('get_data_warehouse_select') }}',
                type: 'GET',
                dataType: 'json',
                async: false,
                data: {
                    id: id,
                },
                success: function(data) {
                    append_warehouse_select(data);
                },
            });
        });

        function append_warehouse_select(data) {
            $('.warehouse_select').empty();
            $('.warehouse_select').append(`
                <option disabled selected value="">==== เลือกสาขา ====</option>
                `);
            data.forEach((val, key) => {

                $('.warehouse_select').append(`
                <option value="${val.id}">${val.w_code}::${val.w_name}</option>
                `);
            });
        }

        $('.warehouse_select').change(function() {
            $('#product_select').prop('disabled', false);
        });



        $('#product_select').change(function() {
            const product_id = $(this).val();

            $.ajax({
                url: '{{ route('get_data_product_unit') }}',
                method: 'GET',
                data: {
                    'product_id': product_id
                },
                success: function(data) {
                    console.log(data);
                    $('#text_product_unit').val(data.product_unit);
                },
            });
        });
    </script>

    {{-- BEGIN print err input --}}
    <script>
        function printErrorMsg(msg) {

            $('._err').text('');
            $.each(msg, function(key, value) {
                $('.' + key + '_err').text(`*${value}*`);
            });
        }

        function resetForm() {
            $('#form_add_product')[0].reset();
            $('._err').text('');
            $('.branch_select').select2({
                dropdownParent: $('#add_product')
            });
            $('#branch_select_filter').select2();

            $('.warehouse_select').select2({
                dropdownParent: $('#add_product')
            });
            $('#warehouse_select_filter').select2();
            $('#product_select').select2({
                dropdownParent: $('#add_product')
            });
            $('.warehouse_select').prop('disabled', true);
            $('#product_select').prop('disabled', true);
        }
    </script>
    {{-- END print err input --}}

    {{-- //BEGIN form_warehoues --}}
    <script>
        $('#form_add_product').submit(function(e) {

            const myModal = tailwind.Modal.getInstance(document.querySelector("#add_product"));
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '{{ route('receive/store_product') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if ($.isEmptyObject(data.error) || data.status == "success") {
                        myModal.hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกสำเร็จ',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ปิด',

                        }).then((result) => {
                            $('.warehouse_select').prop('disabled', true);
                            resetForm();

                            table_receive.draw();
                        })
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });


        function confirm_stock(id) {




            $.ajax({
            url:"{{route('receive/view_confirm_add_stock')}}",
            type: 'GET',
            dataType: 'json',
            data: {
                id: id,
            },
            success: function(data) {
                $('#stock_lot_id').val(id);

                $('#c_branch').val(data);

                console.log(data)
            },
            error: function() {}
        })

            }




    </script>



    {{-- //END form_warehoues --}}

    {{-- BEGIN data_table_branch --}}
    @include('backend.stock.receive.data_table_receive')
    {{-- END data_table_branch --}}
@endsection
