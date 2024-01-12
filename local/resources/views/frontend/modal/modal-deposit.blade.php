<!-- Modal -->
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <form id="form_deposit" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content borderR25">
                <div class="modal-header">
                    <h5 class="modal-title" id="depositModalLabel">Deposit eWallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row gx-2">
                        <div class="col-sm-6">
                            <div class="alert alert-white p-2 h-82 borderR10">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img src=" {{ asset('frontend/images/man.png') }}" alt="..."
                                            width="30px">
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <p class="small mb-0"> {{ Auth::guard('c_user')->user()->user_name }} </p>
                                        <h6> {{ Auth::guard('c_user')->user()->name }}
                                            {{ Auth::guard('c_user')->user()->last_name }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="alert alert-purple p-2 h-82 borderR10">
                                <p class="small">eWallet balance</p>
                                <p class="text-end mb-0"><span class="h5 text-purple1 bg-opacity-100">
                                        {{ Auth::guard('c_user')->user()->ewallet }} </span>฿</p>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Bank 1</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"> Bank 2</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false"> Bank 3</button>
                                </li>
                              </ul>
                              <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <div class="card borderR10 p-2 mb-2">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('frontend/images/aba logo.jpg') }}" alt="icon-Kbank"
                                                    width="50px">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                ABA Bank  <br>
                                                005 095 692 <br>
                                                Kitti Singhathom


                                            </div>
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('frontend/images/aba logo.jpg') }}" alt="icon-Kbank"
                                                    width="50px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="card borderR10 p-2 mb-2">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('frontend/images/aba logo.jpg') }}" alt="icon-Kbank"
                                                    width="50px">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                ABA Bank  <br>
                                                005 095 692 <br>
                                                Kitti Singhathom


                                            </div>
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('frontend/images/aba logo.jpg') }}" alt="icon-Kbank"
                                                    width="50px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    <div class="card borderR10 p-2 mb-2">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('frontend/images/aba logo.jpg') }}" alt="icon-Kbank"
                                                    width="50px">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                ABA Bank  <br>
                                                005 095 692 <br>
                                                Kitti Singhathom


                                            </div>
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('frontend/images/aba logo.jpg') }}" alt="icon-Kbank"
                                                    width="50px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>




                            <div class="row gx-3 mb-3">
                                <span class="text-danger amt_err _err"></span>
                                <label for="" class="col-sm-4 col-md-5 col-form-label">eWallet Deposit Amount
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-8 col-md-6">
                                    <input type="text" name="amt" step="0.01"
                                        class="form-control text-purple1 bg-opacity-100" id="">
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <span class="text-danger upload_err _err"></span>
                                <label for="" class="col-sm-4 col-form-label">Attach money transfer slip <span
                                        class="text-danger ">*</span></label>
                                <div class="col-sm-8">

                                    <form action="#" method="get" name="form" enctype="multipart/form-data">
                                        <div class="upload upload">
                                            <div class="upload__wrap">
                                                <div class="upload__btn">
                                                    <input class="upload__input" type="file" name="upload" />
                                                </div>
                                            </div>
                                            <div class="upload__mess">
                                                <p class="count_img hidden_ms">Maximum number of pictures:<strong
                                                        class="count_img_var">1</strong></p>
                                                <p class="size_img hidden_ms">Maximum image size:<strong
                                                        class="size_img_var">5 Mb</strong></p>
                                                <p class="file_types hidden_ms">File Type:<strong
                                                        class="file_types_var">jpg, png</strong></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class='bx bxs-info-circle me-2'></i>
                        <div>
                            Minimum eWallet deposit = 10 USD
                        </div>
                    </div>
                    <!--
        <div class="alert alert-danger d-flex" role="alert">
           <i class='bx bxs-error me-2 bx-sm' ></i>
          <div>
              คำเตือน ! ต้องมีการยืนยันตัวตนและยืนยันข้อมูลทางบัญชีแล้วเท่านั้น (ข้อมูลส่งบัญชี)
          </div>
        </div>
-->
                </div>
                <div class="modal-footer justify-content-between border-0">
                    <button type="button" class="btn btn-outline-dark rounded-pill"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" disabled class="btn btn-p1 rounded-pill d-flex align-items-center"><i
                            class='bx bxs-check-circle me-2'></i>Submut</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="depositModal2" tabindex="-1" aria-labelledby="depositModal2Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content borderR25">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title" id="depositModal2Label">Confirm Deposit eWallet</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-2 justify-content-center">
                    <div class="col-sm-8">
                        <p class="mb-0 text-center">Confirm Username</p>
                        <div class="alert alert-white p-2 borderR10">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('frontend/images/man.png') }} " alt="..." width="30px">
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <p class="small mb-0">MLM0534768</p>
                                    <h6>ชัยพัทธ์ ศรีสดุดี</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gx-2">
                    <div class="col-sm-12">
                        <h5 class="text-center">eWallet Deposit Amount</h5>
                        <div class="card p-2 borderR10 mb-3 text-center">
                            <h4 class="mb-0 text-purple1 bg-opacity-100">4,000.00 baht</h4>
                        </div>
                    </div>
                </div>
                <div class="row gx-2 justify-content-center">
                    <div class="col-sm-4">
                        <div class="card p-2 text-center">
                            <img src="{{ asset('frontend/images/slip-example.png') }} " class="mw-100">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between border-0">
                <button type="button" class="btn btn-outline-dark rounded-pill" data-bs-target="#depositModal2"
                    data-bs-toggle="modal">Cancel</button>
                <button type="button" class="btn btn-p1 rounded-pill d-flex align-items-center"
                    data-bs-target="#depositModal3" data-bs-toggle="modal"><i
                        class='bx bxs-check-circle me-2'></i>Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="depositModal3" tabindex="-1" aria-labelledby="depositModal3Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content borderR25">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title" id="depositModal3Label">You have completed eWallet deposit</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-2">
                    <div class="col-sm-12">
                        <h5 class="text-center">eWallet Deposit Amount</h5>
                        <div class="card p-2 borderR10 mb-3 text-center">
                            <h4 class="mb-0 text-purple1 bg-opacity-100">4,000.00 baht</h4>
                        </div>
                    </div>
                </div>
                <div class="row gx-2">
                    <div class="col-sm-12 text-center">
                        <i class='far fa-check-circle text-success fa-5x mb-3'></i>
                        <h5 class="text-center">Waiting for verification<br>and approved by admin</h5>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-p1 rounded-pill" data-bs-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        var max_count = 0;
        $(document).ready(function() {

            window.images = []; // UNPUT FILE NAME GLOBAL
            $(".btn-p1").attr('disabled', false);
            //INPUT FILE UPLOADER CUSTOM SCRIPT BEGIN
            $('body').on('change', '.upload__input', function(event) {
                let files = event.target.files;

                $(".btn-p1").attr('disabled', false);
                // console.log('change');
                let messages = $(this).closest('.upload').find(
                    '.count_img, .size_img, .file_types');
                $(messages).hide();


                // console.log(files.length);

                let filename = $(this).attr('name').slice(0, -2);

                let names2 = window.images[filename];
                let names = [];
                // console.log('NAMES2 !!!!! = ' + names2);
                if (names2) {
                    names = names2;
                }

                max_count = $(this).data('maxCount');
                // console.log('max_count' + max_count);

                var i = 0;


                let file = files[i];

                //count
                names.push(file.size);
                // console.log('names = ' + names);
                // console.log('FILE = ' + names.length);

                console.log(names.length);
                if (names.length) {
                    $(this).closest('.upload').find('.count_img').show();
                    $(this).closest('.upload').find('.count_img_var').html(max_count);
                    $(this).closest('.upload').find('.upload__btn').hide();
                }
                if (names.length > max_count) {
                    names.pop();
                    return false;
                }
                window.images[filename] = names;

                //type
                var fileType = file.type;

                console.log(fileType);
                // console.log(fileType);
                if (fileType == 'image/png' || fileType == 'image/jpeg' || fileType ==
                    'image/jpg') {

                } else {
                    $(this).closest('.upload').find('.file_types').show();
                    var max_size = 1;

                }
                if (fileType == 'video/mp4') {
                    $(this).closest('.upload').find('.file_types').show();
                    var max_size = 1;
                    $(".btn-p1").attr('disabled', true);
                    $(this).closest('.upload').find('.count_img').show();
                }

                //size
                var totalBytes = file.size;

                //MB into bites
                var max_bites = max_size * 1024 * 1024;
                // console.log(max_bites);
                if (totalBytes > max_bites) {
                    $(this).closest('.upload').find('.size_img').show();
                    $(this).closest('.upload').find('.size_img_var').html(max_size + 'MB');


                }

                var picBtn = $(this).closest('.upload').find('.upload__btn');
                // console.log('picBtn' + this);

                var picReader = new FileReader();
                picReader.addEventListener("load", function(event) {
                    var picFile = event.target;
                    var picSize = event.total;
                    var picCreate = $("<div class='upload__item'><img src='" +
                        picFile.result + "'" +
                        " class='upload__img'/><a data-id='" + picSize +
                        "' class='upload__del'></a></div>");
                    $(picCreate).insertBefore(picBtn);
                });
                // console.log(file);
                picReader.readAsDataURL(file);

                // console.log(names);
            });

            $('body').on('click', '.upload__del', function() {

                $(this).closest('.upload').find('.upload__btn').show();

                let filename = $(this).closest('.upload').find('.upload__input').attr('name')
                    .slice(0, -2);
                // console.log('FILENAME = ' + filename);

                let names = window.images[filename];

                let messages = $(this).closest('.upload').find(
                    '.count_img, .size_img, .file_types');
                $(messages).hide();

                $(this).closest('.upload__item').remove();


                var removeItem = $(this).attr('data-id');
                var yet = names.indexOf(removeItem);
                names.splice(yet, 1);



            });

        }); /*$(document).ready( function()*/
    });
    /*$(function() { */
</script>





<script>
    function printErrorMsg(msg) {

        $('._err').text('');
        $.each(msg, function(key, value) {
            let class_name = key.split(".").join("_");
            console.log(class_name);
            $('.' + class_name + '_err').text(`*${value}*`);
        });
    }

    $('#form_deposit').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: '{{ route('deposit') }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if ($.isEmptyObject(data.error) || data.status == "success") {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Close',

                    }).then((result) => {
                        location.href = "eWallet-TranferHistory";
                    })
                } else {
                    printErrorMsg(data.error);
                }
            }
        });
    });
</script>


<script>
    function resetForm() {
        $('#form_deposit')[0].reset();

        $('.count_img').hide();
        $('.size_img').hide();
        $('.file_types').hide();
        $('.upload__btn').show();

        $('.upload__item').remove();






        $('._err').text('');
    }
</script>
