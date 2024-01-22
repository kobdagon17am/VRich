  @extends('layouts.frontend.app')
  @section('conten')
      <div class="bg-whiteLight page-content">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-lg-12">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                              <li class="breadcrumb-item"><a href="learning.php">Learning</a></li>
                              <li class="breadcrumb-item active text-truncate" aria-current="page">
                                  {{ isset($Lrn->learning_name) ? $Lrn->learning_name : '' }}</li>
                          </ol>
                      </nav>
                  </div>
              </div>

              <div class="row">
                  <div class="col-md-12">
                      <div class="card card-box borderR10 mb-3">
                          <div class="card-body">
                              <h4 class="card-title">{{ isset($Lrn->learning_name) ? $Lrn->learning_name : '' }}</h4>
                              <span class="badge rounded-pill bg-purple2 bg-opacity-20 text-p1 fw-light mb-1">
                                {{ $Lrn->created_at }}
                            </span>

                              <hr>

                              <div class="row">
                                  <div class="col-md-8 offset-md-2 mb-3 mb-md-5">
                                      <div class="text-center">
                                          <img src="{{ isset($Lrn->learning_image_url) ? asset("$Lrn->learning_image_url/$Lrn->learning_image_name") : '' }}"
                                              class="img-fluid mb-5" alt="">

                                          <div class="detail mb-2">
                                              @if (isset($Lrn->learning_detail))
                                                  {!! $Lrn->learning_detail !!}
                                              @endif
                                          </div>

                                          @if (isset($Lrn->vdeo_url_1))
                                              <div class="ratio ratio-16x9">
                                                  <iframe class="videoIframe js-videoIframe" height="100%"
                                                      src="{{ $Lrn->vdeo_url_1 }}" frameborder="0" allowTransparency="true"
                                                      allowfullscreen data-src=""></iframe>
                                              </div>
                                          @endif
                                          @if (isset($Lrn->vdeo_url_2))
                                              <div class="ratio ratio-16x9 mt-2">
                                                  <iframe class="videoIframe js-videoIframe" height="100%"
                                                      src="{{ $Lrn->vdeo_url_2 }}" frameborder="0" allowTransparency="true"
                                                      allowfullscreen data-src=""></iframe>
                                              </div>
                                          @endif
                                          @if (isset($Lrn->vdeo_url_3))
                                              <div class="ratio ratio-16x9 mt-2">
                                                  <iframe class="videoIframe js-videoIframe" height="100%"
                                                      src="{{ $Lrn->vdeo_url_3 }}" frameborder="0" allowTransparency="true"
                                                      allowfullscreen data-src=""></iframe>
                                              </div>
                                          @endif
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
          $('#linkMenuTop .nav-item').eq(2).addClass('active');
      </script>

      <script>
          $('.page-content').css({
              'min-height': $(window).height() - $('.navbar').height()
          });
      </script>
  @endsection
