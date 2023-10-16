<style>
    .img_doc_info {
        width: 90%;
        height: 90%;
    }
</style>

@extends('layouts.frontend.app')
@section('conten')
    <div class="bg-whiteLight page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active text-truncate" aria-current="page">History Stock</li>
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
                                <div class="col-md-6 col-lg-3">
                                    <label for="" class="form-label">รหัสการดำเนินการ</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6 col-lg-2">
                                    <label for="" class="form-label">สถานะ</label>
                                    <select class="form-select" id="">
                                        <option>ทั้งหมด</option>
                                        <option>รออนุมัติ</option>
                                        <option>อนุมัติ</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-2">
                                    <label for="" class="form-label">วันที่เริ่มต้น</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-6 col-lg-2">
                                    <label for="" class="form-label">วันที่สิ้นสุด</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-6 col-lg-2">
                                    <label for="" class="form-label">ประเถทการดำเนินการ</label>
                                    <select class="form-select" id="">
                                        <option>ทั้งหมด</option>
                                        <option>ฝากเงิน</option>
                                        <option>โอนเงิน</option>
                                        <option>ถอนเงิน</option>
                                    </select>
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
                                    <h4 class="card-title mb-0">History Stock </h4>
                                </div>
                                {{-- <div class="col-sm-6 text-md-end">
                                    <button type="button" class="btn btn-info rounded-pill"><i
                                            class='bx bxs-file me-1'></i> Report</button>
                                </div> --}}
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table id="workL" class="table table-bordered nowrap"></table>

                                </table>


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
        $('.page-content').css({
            'min-height': $(window).height() - $('.navbar').height()
        });
    </script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $('.page-content').css({
        'min-height': $(window).height() - $('.navbar').height()
    });
</script>
<script>
    $(document).ready(function() {
   $(function() {
        oTable = $('#workL').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            pageLength: 25,
            ajax: {
                url: '{{ route('Stock-history-datatable') }}',

                method: 'get'
            },


            columns: [
                //   {
                //             data: "",
                //             title: "#",
                //             className: "table-report__action w-10 text-center",
                //         },
                        {
                            data: "created_at",
                            title: "Created Date",
                            className: "table-report__action w-10 text-center",
                        },
                        {
                            data: "code_order",
                            title: "Transaction No.",
                            className: "table-report__action w-10 text-center",
                        },

                        {
                            data: "user_name_tranfer",
                            title: "Username",
                            className: "table-report__action w-24 whitespace-nowrap text-center",
                        },
                        {
                            data: "user_name_recive",
                            title: "Receiver Name",
                            className: "table-report__action w-12 text-center",
                        },
                        {
                            data: "product_name",
                            title: "Product Name",
                            className: "table-report__action w-10 text-end",
                        },
                        {
                            data: "amt",
                            title: "Amt",
                            className: "table-report__action w-10 text-end",
                        },
                        {
                            data: "amt_new",
                            title: "Amt Balance",
                            className: "table-report__action w-10 text-end",
                        },



                        {
                            data: "note",
                            title: "Detail",
                            className: "table-report__action w-10 text-center",
                        },
                        {
                            data: "type_action",
                            title: "Type",
                            className: "table-report__action w-10 text-center",
                        },
                        {
                            data: "status",
                            title: "Status",
                            className: "table-report__action w-10 text-center whitespace-nowrap",
                        },

            ],
        });
        $('.myWhere,.myLike,.myCustom,#onlyTrashed').on('change', function(e) {
            oTable.draw();
        });

        $('#search-form').on('click', function(e) {
            oTable.draw();
            e.preventDefault();
        });
    });

   });

</script>


@endsection
