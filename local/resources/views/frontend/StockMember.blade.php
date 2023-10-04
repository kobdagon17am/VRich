     <title>บริษัท มารวยด้วยกัน จำกัด</title>


     @extends('layouts.frontend.app')
     @section('css')
         <link href='https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css' rel='stylesheet'>
     @endsection

     @section('conten')
         <div class="bg-whiteLight page-content">
             <div class="container-fluid">
                 <div class="row">
                     <div class="col-lg-12">
                         <nav aria-label="breadcrumb">
                             <ol class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                 <li class="breadcrumb-item active text-truncate" aria-current="page">MY STOCK</li>
                             </ol>
                         </nav>
                     </div>
                 </div>

                 <div class="card card-box borderR10 mb-2 mb-md-0">
                    <div class="card-body">

                        <div class=" table-responsive">



                            <table class="table">
                                <thead>
                                  <tr>
                                    <tr>
                                        <th>Picture</th>
                                        <th>Product name</th>
                                        <th width="10">Quantity</th>
                                        <th>Price</th>
                                        <th>Total price</th>
                                        <th>PT</th>
                                        <th>PT total</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $arr_pv = array();
                                    $arr_pri =  array();
 
                                    ?>
                                      @foreach($stock as $value)
                                      <tr id="items">
                                          <td class="text-center">
                                               <img src="{{asset($value->product_image_url.''.$value->product_image_name)}}" class="img-fluid" width="70" alt="tbl"></a>
                                          </td>
                                          <td class="text-center">
                                              <h6> {{ $value->product_name }} </h6>

                                          </td>
                                          <td class="text-center">
                                            {{ $value->amt }}
                                          </td>
                                          <td class="text-center">{{ number_format($value->price,2) }}</td>
                                          <td class="text-center">{{ number_format($value->price_total,2) }}</td>

                                          <td class="text-center">{{number_format($value->pv)}}</td>
                                          <td class="text-center">{{number_format($value->pv*$value->amt)}}</td>
                                          <?php
                                          $arr_pv[] = $value->pv*$value->amt;
                                          $arr_pri[] = $value->price_total;
                                          ?>

                                      </tr>
                                      @endforeach
                                      <tr id="items">
                                        <td class="text-center">

                                        </td>
                                        <td>

                                        </td>
                                        <td>

                                        </td>
                                        <td class="text-center"> Price Total </td>
                                        <td class="text-center"><b>{{number_format(array_sum($arr_pri))}}</b></td>

                                        <td class="text-center">PT Total </td>
                                        <td class="text-center"><b>{{number_format(array_sum($arr_pv))}}</b></td>

                                    </tr>
                                  </tbody>
                              </table>
                        </div>
                    </div>
                </div>

             </div>
         </div>

     @endsection

     @section('script')

         <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
         <script>
             $('.page-content').css({
                 'min-height': $(window).height() - $('.navbar').height()
             });
         </script>

     @endsection
