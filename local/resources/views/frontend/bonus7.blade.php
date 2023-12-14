 <title>VRich</title>

 @section('css')
     <link href='https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css' rel='stylesheet'>
 @endsection


 @extends('layouts.frontend.app')
 @section('conten')
     <div class="bg-whiteLight page-content">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-lg-12">
                     <nav aria-label="breadcrumb">
                         <ol class="breadcrumb">
                             <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                             <li class="breadcrumb-item active text-truncate" aria-current="page"> Pro Dealer </li>
                         </ol>
                     </nav>
                 </div>
             </div>
             <div class="row">
                 <div class="col-md-12">
                     <div class="card card-box borderR10 mb-3">
                         <div class="card-body">
                             <h4 class="card-title">Search</h4>
                             <hr>
                             <div class="row g-3">
                                 <div class="col-md-6 col-lg-2">
                                     <label for="" class="form-label">Year</label>
                                     <input type="text" id="year" class="form-control" value="{{date('Y')}}">
                                 </div>
                                 <div class="col-md-6 col-lg-2">
                                     <label for="" class="form-label">Month</label>
                                     <select class="form-select" id="month" aria-label="Default select example">
                                        <option value="01" @if(date('m') == '01') selected @endif>January</option>
                                        <option value="02" @if(date('m') == '02') selected @endif>February</option>
                                        <option value="03" @if(date('m') == '03') selected @endif>March</option>
                                        <option value="04" @if(date('m') == '04') selected @endif>April</option>
                                        <option value="05" @if(date('m') == '05') selected @endif>May</option>
                                        <option value="06" @if(date('m') == '06') selected @endif>June</option>
                                        <option value="07" @if(date('m') == '07') selected @endif>July</option>
                                        <option value="08" @if(date('m') == '08') selected @endif>August</option>
                                        <option value="09" @if(date('m') == '09') selected @endif>September</option>
                                        <option value="10" @if(date('m') == '10') selected @endif>October</option>
                                        <option value="11" @if(date('m') == '11') selected @endif>November</option>
                                        <option value="12" @if(date('m') == '12') selected @endif>December</option>

                                      </select>
                                 </div>
                                 {{-- <div class="col-md-6 col-lg-2">
                                     <label for="" class="form-label">เวลาเริ่มต้น</label>
                                     <input type="time" class="form-control">
                                 </div>
                                 <div class="col-md-6 col-lg-2">
                                     <label for="" class="form-label">เวลาสิ้นสุด</label>
                                     <input type="time" class="form-control">
                                 </div> --}}
                                 {{-- <div class="col-md-10 col-lg-3">
                                     <label for="" class="form-label">คำค้นหา</label>
                                     <input type="text" class="form-control">
                                 </div> --}}
                                 <div class="col-md-2 col-lg-1">
                                     <label for="" class="form-label d-none d-md-block">&nbsp;</label>
                                     <button type="button" id="search-form" class="btn btn-dark rounded-circle btn-icon"><i
                                             class="bx bx-search"></i></button>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="card card-box borderR10 mb-2 mb-md-0">
                         <div class="card-body">
                             <div class="row">
                                 <div class="col-sm-6">
                                     <h4 class="card-title mb-0">History Pro Dealer</h4>
                                 </div>
                                 {{-- <div class="col-sm-6 text-md-end">
                                     <button type="button" class="btn btn-info rounded-pill"><i
                                             class='bx bxs-file me-1'></i> ออกรายงาน</button>
                                 </div> --}}
                             </div>
                             <hr>
                             <table id="cashback" class="table table-bordered nowrap">


                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection

 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
 <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
 <script>
     $(function() {
         table_order = $('#cashback').DataTable({
             dom: 'Bfrtip',
             buttons: ['excel'],
             searching: false,
             ordering: false,
             lengthChange: false,
             responsive: true,
             paging: false,
             processing: true,
             serverSide: true,
             "language": {
                 "lengthMenu": "Show _MENU_ rows",
                 "zeroRecords": "No data found",
                 "info": "Showing page _PAGE_ of _PAGES_",
                 "search": "Search",
                 "infoEmpty": "",
                 "infoFiltered": "",
                 "paginate": {
                     "first": "First",
                     "previous": "Previous",
                     "next": "Next",
                     "last": "Last"
                 },
                 'processing': "Loading data",
             },
             ajax: {
                 url: '{{ route('datatable_bonus7') }}',
                 data: function(d) {
                     // d.username = $('#username').val();
                    //  d.route = $('#route').val();
                     d.month = $('#month').val();
                     d.year = $('#year').val();
                     // d.position = $('#position').val();
                     // d.type = $('#type').val();

                 },
             },


             columns: [
                 // {
                 //     data: "id",
                 //     title: "ลำดับ",
                 //     className: "w-10 text-center",
                 // },

                 {
                     "data": "name",
                     "title": "Name",
                     "className": "w-10 text-center"
                 },
                 {
                     "data": "last_name",
                     "title": "Last Name",
                     "className": "w-10 text-center"
                 },
                 {
                     "data": "qualification",
                     "title": "Position",
                     "className": "w-1 text-center"
                 },
                 {
                     "data": "year",
                     "title": "Year",
                     "className": "w-1 text-center"
                 },
                 {
                     "data": "month",
                     "title": "Month",
                     "className": "w-1 text-center"
                 },
                 {
                        data: "pv",
                        title: "PT",
                        className: "w-1 text-center",

                    },

                    {
                        data: "reth",
                        title: "Reth",
                        className: "w-1 text-center",

                    },


                    {
                        data: "bonus_total_usd",
                        title: "Bonus total",
                        className: "w-1 text-center",

                    },
                    {
                        data: "note",
                        title: "Note",
                        className: "w-1",

                    },


                    {
                        data: "status",
                        title: "Status",
                        className: "w-10",

                    },

             ],



         });
         $('#search-form').on('click', function(e) {
             table_order.draw();
             e.preventDefault();
         });

     });
 </script>



 @section('script')
     <script>
         $('.page-content').css({
             'min-height': $(window).height() - $('.navbar').height()
         });
     </script>
     <script>
         $(document).ready(function() {
             var table = $('#bonusAll').DataTable({
                 responsive: true
             });

             new $.fn.dataTable.FixedHeader(table);
         });
     </script>
 @endsection
