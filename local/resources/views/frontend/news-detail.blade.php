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
                                 <li class="breadcrumb-item active text-truncate" aria-current="page">{{ $News->news_name }}
                                 </li>
                             </ol>
                         </nav>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-12">
                         <div class="card card-box borderR10 mb-3">
                             <div class="card-body">
                                 <h4 class="card-title">{{ $News->news_name }}</h4>
                                 <span class="badge rounded-pill bg-purple2 bg-opacity-20 text-p1 fw-light mb-1">
                                     {{ $News->created_at }}
                                 </span>

                                 <hr>

                                 <div class="detail" style="text-align: center">
                                    <img src="{{ isset($News->news_image_url) ? asset("$News->news_image_url/$News->news_image_name") : '' }}"
                                    class="img-fluid mb-5" alt="" >
                                    <p>{{ $News->news_detail }}</p>

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
     @endsection
