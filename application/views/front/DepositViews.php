<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php $this->load->view('front/_layout/Head'); ?>
  </head>
  <body class="maincolor">
    <?php $this->load->view('front/_layout/Navbar'); ?>
    <div class="maincolor m-0" style="padding-bottom:50px;">
      <div class="container">
        <div class="row" >
          <div class=" col-md-12 col-sm-12 col-lg-4">

            <div class="title text-left">
              <?php echo $title; ?>
            </div>
            <p class="subtitle mb-4 readmorep"><span class="text-muted deskpro">PERINGATAN: Mohon untuk hubungi pihak Higgs Domino jika anda ada pertanyaan perihal Top up ! Cukup masukan User ID Higgs Domino Anda, pilih jumlah Top up yang Anda inginkan, selesaikan pembayaran, dan Diamond akan secara langsung ditambahkan ke akun Higgs Domino Anda.Bayarlah menggunakan GoPay, OVO, Bank Transfers, DANA, Shopee Pay, LinkAja, Alfamart . MVSTORE adalah cara terbaik untuk top up Higgs Domino secara online tanpa perlu kartu kredit, registrasi ataupun log-in.Unduh dan mainkan Higgs Domino sekarang!</span>
            </p>
          </div>

          <div class="seccolor col-md-12 col-sm-12 col-lg-7"  style="padding-bottom:30px;">
            <div class="title text-left mt-2" >
              1. Masukan Nominal
            </div>
            <div class="subtitle" style="margin-top:20px;">
              DEPOSIT
            </div>
            <div class="mt-2">
              <input value="Rp. 1.000" nickname="" status="true" class="form-control produkcolor inputid userid nominal" type="text" name="id" id="id">
            </div>

            <div class="title text-left mt-2" >
              2. Metode Pembayaran
            </div>
            <h3 class="text-white">Otomatis</h3>
            <div class="listpayment" style="margin-top:20px;">

            </div>
            <h3 class="text-white">Manual</h3>
            <div class="listpaymentmanual" style="margin-top:20px;">

            </div>
            <div class="title text-left mt-2" >
              3. Beli
            </div>
            <div class="" style="margin-top:20px;">
              <div class="g-recaptcha" data-sitekey="<?php echo GOOGLESITE_KEY; ?>"></div><br>
              <div class="mt-1 ">
                <p style="width:100%;"><a nickname="" itemid="" payment="" userids="false" userid="" price="" style="width:100%;padding:10px;font-size:20px;cursor:pointer;"  class="mvstyle text-center buy text-white">Beli Sekarang</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view('front/_layout/Footer'); ?>
    <script type="text/javascript">
    $( document ).ready(function() {

        getPayment();
        $('.nominal').keyup(function() {
          var nominal = $(this).val();
          $(this).val(formatRupiah(nominal.toString(), 'Rp. '));
          var orinominal = $(this).val();
          var orinominal1 = orinominal.replace("Rp. ", "");
          var orinominal2 = orinominal1.replace(".", "");
          var orinominal2 = orinominal2.replace(".", "");
          console.log('KEYUP : '+parseInt(orinominal2));
          if (orinominal2 < 1000) {
            //$(this).val(formatRupiah("1000", 'Rp. '));
          }
        });
    //=====================================================
        $(document).on("focusout",".nominal", function () {
          $('.loader').show();
          //$(".item").removeClass("bg-dark text-white");
          //$(this).addClass("bg-dark text-white");
          var orinominal = $('.nominal').val();
          var orinominal1 = orinominal.replace("Rp. ", "");
          var orinominal2 = orinominal1.replace(".", "");
          var orinominal2 = orinominal2.replace(".", "");
          console.log('item : '+parseInt(orinominal2));
          if (orinominal2 < 1000) {
            //$(this).val(formatRupiah("1000", 'Rp. '));
          }
          var price = parseInt(orinominal2) + 1100;
          var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id
          // alert('MANTAP AJG #' + clickedBtnID);
          $.ajax({
              url: "<?php echo base_url('deposit/getdata') ?>",
              cache: false,
              type: "post",
              dataType: "json",
              async: true,
              data: {
                  "price": price,
              },
              success: function (data) {
                if (data === null) {
                  alert('TERJADI KESALAHAN SILAHKAN COBA KEMBALI.');
                  $('.loader').hide('fade');
                } else {
                  // console.log(data.price);
                  // console.log(data.data.length);
                  $(".listpayment").empty();
                  $(".manual").empty();
                  for (var i = 0; i < data.data.length; i++) {

                    if (data.data[i].mode == "otomatis") {
                      $(".listpayment").append('<div mode="'+data.data[i].mode+'" id="'+data.data[i].code+'" price="'+data.data[i].price+'" class="row payment mvstyle p-1 mt-2 rounded mx-1 '+data.data[i].code+'" style="height:50px;cursor:pointer;">'
                        +'<div class="col-md-5 col-5" style="height:100%;">'
                          +'<img style="height:40px;max-width:100%;" src="'+data.data[i].image+'" alt="">'
                        +'</div>'
                        +'<div class="col-md-7 col-7 text-center">'
                          +'<p style="width:100%;"><a price="'+data.data[i].price+'" style="width:100%;margin-top:2px;"  class="readmore text-center  '+data.data[i].code+'">'+formatRupiah(data.data[i].price.toString(), 'Rp. ')+'</a></p>'
                        +'</div>'
                      +'</div>');
                    }else {
                      $(".listpaymentmanual").append('<div mode="'+data.data[i].mode+'" id="'+data.data[i].code+'" price="'+data.data[i].price+'" class="row payment mvstyle p-1 mt-2 rounded mx-1 '+data.data[i].code+'" style="height:50px;cursor:pointer;">'
                        +'<div class="col-md-5 col-5" style="height:100%;">'
                          +'<img style="height:40px;max-width:100%;" src="'+data.data[i].image+'" alt="">'
                        +'</div>'
                        +'<div class="col-md-7 col-7 text-center">'
                          +'<p style="width:100%;"><a price="'+data.data[i].price+'" style="width:100%;margin-top:2px;"  class="readmore text-center  '+data.data[i].code+'">'+formatRupiah(data.data[i].price.toString(), 'Rp. ')+'</a></p>'
                        +'</div>'
                      +'</div>');
                    }
                  }
                  if (data.price < 10000) {
                    $('.BCAVA').attr('hidden', true);
                    $('.BNIVA').attr('hidden', true);
                    $('.BRIVA').attr('hidden', true);
                    $('.INDOMARET').attr('hidden', true);
                  }
                  if (data.price < 5000) {
                    $('.MANDIRIVA').attr('hidden', true);
                    $('.ALFAMART').attr('hidden', true);
                    $('.ALFAMIDI').attr('hidden', true);
                  }
                  if (data.price < 1000) {
                    $('.QRISC').attr('hidden', true);
                    $('.OVO').attr('hidden', true);
                }
                $('.loader').hide('fade');
                }
              },
              error: function () {
                $('.loader').hide('fade');
                $.ajax(this);
                return false;
              }
          });
        });
    //=====================================================
        if ($(window).width() < 960) {
           $(".deskpro").text('PERINGATAN : Mohon transfer dengan tepat dan simpan bukti...');
           $(".readmorep").append('<a style="color:white;" class="readmorea">Readmore</a>');
        }
        else {
         $(".deskpro").text('PERINGATAN : Mohon transfer dengan tepat dan simpan bukti transfer untuk menghindari hal yang tidak diinginkan terjadi. Pastian transfer sesuai nominal dan kode unit yang diberikan, jangan lupa cek nama penerima transfer.');
        }
        $('.readmorep').on('click','.readmorea',function() {
          $(".deskpro").text('PERINGATAN : Mohon transfer dengan tepat dan simpan bukti transfer untuk menghindari hal yang tidak diinginkan terjadi. Pastian transfer sesuai nominal dan kode unit yang diberikan, jangan lupa cek nama penerima transfer.');
          $(".readmorea").remove();
          $(".readmorep").append('<a style="color:white;" class="readmorem">Hide</a>');
        });
        $('.readmorep').on('click','.readmorem',function() {
          $(".deskpro").text('PERINGATAN : Mohon transfer dengan tepat dan simpan bukti...');
          $(".readmorem").remove();
          $(".readmorep").append('<a style="color:white;" class="readmorea">Readmore</a>');
        });
        //$(".bd-example-modal-lg").modal('show');
        $('.bd-example-modal-lg').on('hidden.bs.modal', function () {
          location.reload();
        });
        console.log( "ready!" );
        $(document).on("click",".close", function () {
          $(".bd-example-modal-lg").modal('hide');
        });
    //=====================================================
        function getPayment(){
          $('.loader').show();
          $.ajax({
              url: "<?php echo base_url('prosess/getPayment') ?>",
              cache: false,
              type: "get",
              dataType: "json",
              async: true,
              success: function (data) {
                if (data === null) {
                  alert('TERJADI KESALAHAN SILAHKAN COBA KEMBALI.');
                } else {
                  $(".listpayment").empty();
                  for (var i = 0; i < data.data.length; i++) {
                    if (data.data[i].code != "BALANCE") {
                      $(".listpayment").append('<div id="'+data.data[i].code+'" price="'+data.data[i].price+'" class="row payment mvstyle p-1 mt-2 rounded mx-1 '+data.data[i].code+'" style="height:50px;cursor:pointer;">'
                        +'<div class="col-md-5 col-5" style="height:100%;">'
                          +'<img style="height:40px;max-width:100%;" src="'+data.data[i].image+'" alt="">'
                        +'</div>'
                        +'<div class="col-md-7 col-7 text-center">'
                          +'<p style="width:100%;"><a price="'+data.data[i].price+'" style="width:100%;margin-top:2px;"  class="readmore text-center  '+data.data[i].code+'">'+formatRupiah(data.data[i].price.toString(), 'Rp. ')+'</a></p>'
                        +'</div>'
                      +'</div>');
                    }
                  }

                }
                $('.loader').hide('fade');
              },
              error: function () {
                $.ajax(this);
                return false;
              }
          });
        }
        //==============================================================================
        $(document).on("click",".payment", function () {
            if ($(this).attr('price') != 0) {
              $(".payment").removeClass("bg-info text-white");
              $(this).addClass("bg-info text-white");
              $(".buy").attr('payment',$(this).attr('id'));
              $(".buy").attr('mode',$(this).attr('mode'));
              $(".buy").attr('price',$(this).attr('price'));
              console.log('PAYMENT : '+$(this).attr('id'));
              console.log('METODE : '+$(this).attr('mode'));
            }

        });
            //==============================================================================
        $(document).on("click",".buy", function () {
          if ($(this).attr('price') === "") {
            $('.loader').hide('fade');
            Swal.fire({
                  background : '#283269',
                  color: 'white',
                  icon: 'error',
                  title: 'Failed',
                  html: 'Silahkan pilih metode pembayaran terlebih dahulu.',
                  // footer: '<a href="">Why do I have this issue?</a>'
                });
            return false;
          } else {
            if ($(this).attr('payment') === "") {
              Swal.fire({
                    background : '#283269',
                    color: 'white',
                    icon: 'error',
                    title: 'Failed',
                    html: 'Silahkan pilih metode pembayaran terlebih dahulu.',
                    // footer: '<a href="">Why do I have this issue?</a>'
                  });
              $('.loader').hide('fade');
            }else {
              if (confirm('Anda yakin ingin melanjutkan pembelian?')) {
                var orinominal = $('.nominal').val();
                var orinominal1 = orinominal.replace("Rp. ", "");
                var orinominal2 = orinominal1.replace(".", "");
                var orinominal2 = orinominal2.replace(".", "");
                if (orinominal2 < 1000) {
                  alert('Minimal deposit Rp. 1000');
                  return false;
                }
                $('.loader').show();
                var payment = $(this).attr('payment');
                var mode = $(this).attr('mode');
                $.ajax({
                    url: "<?php echo base_url('Deposit/pro') ?>",
                    cache: false,
                    type: "post",
                    dataType: "json",
                    async: true,
                    data: {
                        "price": orinominal,
                        "payment": payment,
                        "mode" : mode
                    },
                    success: function (data) {
                      console.log(data);
                      if (data === null) {
                        alert('SILAHKAN COBA KEMBALI NANTI');
                      } else {
                        console.log(data);
                        if (data.Mode == 'manual') {
                          Swal.fire({
                            imageWidth: 200,
                            imageHeight: 200,
                            background : '#283269',
                            color: 'white',
                            icon: 'success',
                            title: 'Sukses',
                            html: '<p> Metode pembayaran : '+data.Payment+'</p>'
                            +'<p> Invoice : '+data.Invoice+' (Simpan untuk cek status pesanan)</p>'
                            +'<p> Total : '+formatRupiah(data.Total.toString(), 'Rp. ')+'</p>'

                            +'<p> Cara Pembayaran  </p>'
                            +''+data.Detail+''
                          }).then((result) => {
                            if (result.isConfirmed) {
                              location.reload();
                            }
                          });
                          $('.loader').hide('fade');
                        }else {
                          if (data.Respone.data.payment_method === "OVO") {
                            console.log('ovo');
                            window.location.replace(data.Respone.data.checkout_url);
                          }else {

                              var qq = '';
                              for (var i = 0; i < data.Respone.data.instructions.length; i++) {
                                qq += "<p class='text-warning'>"+(i+1)+" : "+data.Respone.data.instructions[i].title+"</p>";
                                for (var j = 0; j < data.Respone.data.instructions[i].steps.length; j++) {
                                  qq += "<p> - "+data.Respone.data.instructions[i].steps[j]+"</p>";
                                }
                              }
                              if (data.Respone.data.qr_url != undefined) {
                                Swal.fire({
                                  imageUrl: data.Respone.data.qr_url != undefined ? data.Respone.data.qr_url : ' ',
                                  imageWidth: 200,
                                  imageHeight: 200,
                                  background : '#283269',
                                  color: 'white',
                                  icon: 'success',
                                  title: 'Sukses',
                                  html: '<p> Metode pembayaran : '+data.Respone.data.payment_name+'</p>'
                                  +'<p> Username : '+data.Respone.data.customer_name+'</p>'
                                  +'<p> Invoice : '+data.Respone.data.merchant_ref+' (Simpan untuk cek status pesanan)</p>'
                                  +'<p> Total : '+formatRupiah(data.Respone.data.amount.toString(), 'Rp. ')+'</p>'
                                  +'<p> Item : '+data.Respone.data.order_items[0].name+'</p>'
                                  // + data.data.qr_url != undefined ? '<img class="mx-auto" style="display:block;margin-bottom:10px;" src="'+data.data.qr_url+'" alt="">' : ' '
                                  +'<p> Cara Pembayaran </p>'
                                  +qq
                                }).then((result) => {
                                  if (result.isConfirmed) {
                                    location.reload();
                                  }
                                });
                              }else {
                                Swal.fire({
                                  background : '#283269',
                                  color: 'white',
                                  icon: 'success',
                                  title: 'Sukses',
                                  html: '<p> Metode pembayaran : '+data.Respone.data.payment_name+'</p>'
                                  +'<p> Username : '+data.Respone.data.customer_name+'</p>'
                                  +'<p> Invoice : '+data.Respone.data.merchant_ref+' (Simpan untuk cek status pesanan)</p>'
                                  +'<p> Total : '+formatRupiah(data.Respone.data.amount.toString(), 'Rp. ')+'</p>'
                                  +'<p> Item : '+data.Respone.data.order_items[0].name+'</p>'
                                  // + data.data.qr_url != undefined ? '<img class="mx-auto" style="display:block;margin-bottom:10px;" src="'+data.data.qr_url+'" alt="">' : ' '
                                  +'<p> Cara Pembayaran </p>'
                                  +qq
                                }).then((result) => {
                                  if (result.isConfirmed) {
                                    location.reload();
                                  }
                                });
                              }

                          }
                          // alert('sukses');
                        }

                      }
                      $('.loader').hide('fade');
                    },
                    error: function () {
                      $.ajax(this);
                      return false;
                    }
                });
              } else {
                $('.loader').hide('fade');
                return false;
              }
            }




          }
        });
        function formatRupiah(angka, prefix){
    			var number_string = angka.replace(/[^,\d]/g, '').toString(),
    			split   		= number_string.split(','),
    			sisa     		= split[0].length % 3,
    			rupiah     		= split[0].substr(0, sisa),
    			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    			// tambahkan titik jika yang di input sudah menjadi angka ribuan
    			if(ribuan){
    				separator = sisa ? '.' : '';
    				rupiah += separator + ribuan.join('.');
    			}
    			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    		}


    });
    </script>
  </body>
</html>
