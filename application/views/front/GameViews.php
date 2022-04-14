<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php $this->load->view('front/_layout/Head'); ?>
  </head>
  <body class="maincolor">
    <?php $this->load->view('front/_layout/Navbar'); ?>
    <section class="section">
      <div class="container">
        <div class="row">
          <div class=" col-md-12 col-sm-12 col-lg-4">
            <img src="<?php echo $gamePic; ?>" alt="Image" class="img-fluid mt-1">
            <div class="title text-left">
              <?php echo $gameName; ?>
            </div>
            <p class="subtitle mb-4 readmorep"><span class="text-muted deskpro"></span>
            </p>
          </div>

          <div class="seccolor col-md-12 col-sm-12 col-lg-7"  style="padding-bottom:30px;">
            <div class="title text-left mt-2" >
              1. Masukan ID / Data
            </div>
            <div class="subtitle" style="margin-top:20px;">
              <?php echo $gameId; ?>
            </div>
            <div class="mt-2">
              <input value="" nickname="" status="true" class="form-control produkcolor inputid userid" type="text" name="id" id="id">
            </div>
            <div class="title text-left mt-2" >
              2. Pilih Produk
            </div>
            <div class="row" style="margin-top:20px;">
              <?php foreach ($data as $d):?>
                <?php if ($d->brand == $gameName && $d->buyer_product_status == true && $d->seller_product_status == true): ?>


                <div class="rounded p-2 col-6 col-sm-6 col-md-6 col-lg-4 text-white text-center " style=" cursor: pointer;" >
                  <div class="rounded divitem item" style="background-color:#283269;" price="<?php echo $d->newprice; ?>" id="<?php echo $d->sku_code; ?>">
                    <div class="text-white" style="padding:10px;">
                      <?php echo $d->product_name; ?>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
              <?php  endforeach; ?>
            </div>
            <div class="title text-left mt-2" >
              2. Metode Pembayaran
            </div>
            <div class="listpayment" style="margin-top:20px;">

            </div>
            <div class="title text-left mt-2" >
              3. Beli
            </div>
            <div class="" style="margin-top:20px;">
              <?php if (!$this->ion_auth->logged_in()) {?>
              <div class="col-md-12 col-12 form-group ">
                <!-- 60002123 -->
                <label for="" class="text-white">Email : </label>
                <input value="" nickname="" status="true" class="form-control produkcolor sendemail inputid" type="text" name="EmailSend" id="SendEmail" placeholder="Masukkan Email">

              </div>
              <?php } ?>
              <div class="g-recaptcha" data-sitekey="<?php echo GOOGLESITE_KEY; ?>"></div><br>
              <div class="mt-1 ">
                <p style="width:100%;"><a nickname="" itemid="" payment="" userids="false" userid="" price="" style="width:100%;padding:10px;font-size:20px;cursor:pointer;"  class="mvstyle text-center buy text-white">Beli Sekarang</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php $this->load->view('front/_layout/Footer'); ?>
    <script type="text/javascript">
    $( document ).ready(function() {
      console.log( "ready!" );
      getPayment();
      $('.userid').focusout(function(){
        var cekurl = '<?php echo $gameCekId; ?>';
        if (this.value != '') {
          if (cekurl != '') {
            var UserId = this.value;
            $('.loader').show();
            $.ajax({
                url: cekurl,
                cache: false,
                type: "post",
                dataType: "json",
                async: true,
                data: {
                    "UserId": UserId,
                },

                success: function (data) {
                  if (!data.Status) {
                    Swal.fire({
                      background : '#283269',
                      color: 'white',
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Id Tidak Ditemukan.',
                      // footer: '<a href="">Why do I have this issue?</a>'
                    })
                    $(".userid").attr('status', 'false');
                    $(".buy").attr('userids','false');
                  } else {
                    Swal.fire({
                      background : '#283269',
                      color: 'white',
                      icon: 'success',
                      title: 'Sukses',
                      text: 'Username : '+data.NickName,
                      // footer: '<a href="">Why do I have this issue?</a>'
                    })
                    $(".userid").attr('status', 'true');
                    $(".userid").attr('nickname', data.NickName);
                    $(".buy").attr('userid',$(".userid").val());
                    $(".buy").attr('userids','true');
                    $(".buy").attr('nickname',data.NickName);
                  }
                  $('.loader').hide('fade');
                },
                error: function () {
                  $.ajax(this);
                  return false;
                }
            });
          } else {
            $(".buy").attr('userid',$(".userid").val());
            $(".buy").attr('userids','true');
            $(".buy").attr('nickname',$(".userid").val());
          }
        }
      });
      $(".divitem").mouseover(function(){
        $(this).css("background-color","#17a2b8");
      });
      $(".divitem").mouseout(function(){
        $(this).css("background-color","#283269");
      });
      $(document).on("mouseover",".mvstyle",function(){
        $(this).css("background-color","#17a2b8");
      });
      $(document).on("mouseout",".mvstyle",function(){
        $(this).css("background-color","#283269");
      });
      if ($(window).width() < 960) {
       $(".deskpro").text('PERINGATAN: Mohon untuk hubungi pihak <?php echo $gameName; ?> jika anda ada pertanyaan....');
       $(".readmorep").append('<a style="color:white;" class="readmorea">Readmore</a>');
      }
      else {
       $(".deskpro").text('PERINGATAN: Mohon untuk hubungi pihak <?php echo $gameName; ?> jika anda ada pertanyaan perihal Top up ! Cukup masukan User ID <?php echo $gameName; ?> Anda, pilih jumlah Top up yang Anda inginkan, selesaikan pembayaran, dan Diamond akan secara langsung ditambahkan ke akun <?php echo $gameName; ?> Anda.Bayarlah menggunakan GoPay, OVO, Bank Transfers, DANA, Shopee Pay, LinkAja, Alfamart . <?php echo SITE_NAME; ?> adalah cara terbaik untuk top up <?php echo $gameName; ?>  secara online tanpa perlu kartu kredit, registrasi ataupun log-in.Unduh dan mainkan <?php echo $gameName; ?> sekarang!');
      }
      $('.readmorep').on('click','.readmorea',function() {
        $(".deskpro").text('PERINGATAN: Mohon untuk hubungi pihak <?php echo $gameName; ?> jika anda ada pertanyaan perihal Top up ! Cukup masukan User ID <?php echo $gameName; ?> Anda, pilih jumlah Top up yang Anda inginkan, selesaikan pembayaran, dan Diamond akan secara langsung ditambahkan ke akun <?php echo $gameName; ?> Anda.Bayarlah menggunakan GoPay, OVO, Bank Transfers, DANA, Shopee Pay, LinkAja, Alfamart. <?php echo SITE_NAME; ?> adalah cara terbaik untuk top up <?php echo $gameName; ?>  secara online tanpa perlu kartu kredit, registrasi ataupun log-in.Unduh dan mainkan <?php echo $gameName; ?> sekarang!');
        $(".readmorea").remove();
        $(".readmorep").append('<a style="color:white;" class="readmorem">Hide</a>');
      });
      $('.readmorep').on('click','.readmorem',function() {
        $(".deskpro").text('PERINGATAN: Mohon untuk hubungi pihak <?php echo $gameName; ?> jika anda ada pertanyaan....');
        $(".readmorem").remove();
        $(".readmorep").append('<a style="color:white;" class="readmorea">Readmore</a>');
      });
      function getPayment(){
        $('.loader').show();
        $.ajax({

            url: "<?php echo base_url('order/getPayment') ?>",
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
                    $(".listpayment").append('<div class="row mvstyle p-1 mt-2 rounded mx-1" style="height:50px;cursor:pointer;">'
                      +'<div class=" col-md-5 col-5" style="height:100%;">'
                        +'<img style="height:40px;max-width:100%;" src="'+data.data[i].image+'" alt="">'
                      +'</div>'
                      +'<div class=" col-md-7 col-7 text-center">'
                        +'<p style="width:100%;"><a disabled style="width:100%;margin-top:2px;" id="'+data.data[i].code+'" class="readmore text-center payment '+data.data[i].code+'">'+formatRupiah(data.data[i].price.toString(), 'Rp. ')+'</a></p>'
                      +'</div>'
                    +'</div>');
                  }else {
                    <?php if ($this->ion_auth->logged_in()) { ?>
                    $(".listpayment").append('<div class="row p-1 mvstyle mt-2 rounded mx-1" style="height:50px;cursor:pointer;">'
                      +'<div class=" col-md-5 col-5" style="height:100%;">'
                        +'<h3 class=" text-white" >'+data.data[i].code+'</h3>'
                      +'</div>'
                      +'<?php if ($this->ion_auth->logged_in()){ ?>'
                        +'<div class=" col-md-7 col-7 text-center">'
                          +'<p style="width:100%;"><a style="width:100%;" id="'+data.data[i].code+'"  class="readmore text-center payment '+data.data[i].code+'">'+formatRupiah(data.data[i].price.toString(), 'Rp. ')+'</a></p>'
                        +'</div>'
                      +'<?php }else{ ?>'
                        +'<div class=" col-md-7 col-7 text-center">'
                          +'<p style="width:100%;" class="readmore  '+data.data[i].code+'">Rp.0</p>'
                        +'</div>'
                      +'<?php } ?>'
                    +'</div>');
                    <?php } ?>
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
      $(document).on("click",".item", function () {
        $('.loader').show();
        $('.item').removeClass("bg-info");
        $(this).addClass("bg-info");
        var itemId = $(this).attr('id');
        var price = $(this).attr('price');
        $(".buy").attr('itemid',itemId);
        $(".buy").attr('itemname',$(this).text());
        var clickedBtnID = $(this).attr('id');
        $.ajax({
            url: "<?php echo base_url('prosess/getdata') ?>",
            cache: false,
            type: "post",
            dataType: "json",
            async: true,
            data: {
                "itemId": itemId,
                "price": price,
            },
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
                  }else {
                    <?php if ($this->ion_auth->logged_in()) { ?>
                    $(".listpayment").append('<div id="'+data.data[i].code+'" price="'+data.data[i].price+'" class="row payment mvstyle p-1 mt-2 rounded mx-1 '+data.data[i].code+'" style="height:50px;cursor:pointer;">'
                      +'<div class="col-md-5 col-5" style="height:100%;">'
                        +'<h3 class="h3 text-white">'+data.data[i].code+'</h3>'
                      +'</div>'
                      +'<?php if ($this->ion_auth->logged_in()){ ?>'
                        +'<div class="col-md-7 col-7 text-center">'
                          +'<p style="width:100%;"><a price="'+data.data[i].price+'" style="width:100%;" id="'+data.data[i].code+'"  class="readmore text-center  '+data.data[i].code+'">'+formatRupiah(data.data[i].price.toString(), 'Rp. ')+'</a></p>'
                        +'</div>'
                      +'<?php }else{ ?>'
                        +'<div class="col-md-7 col-7 text-center">'
                          +'<p style="width:100%;" class="readmore '+data.data[i].code+'">Rp.0</p>'
                        +'</div>'
                      +'<?php } ?>'
                    +'</div>');
                    <?php } ?>
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
              }
              $('.loader').hide('fade');

            },
            error: function () {
              $.ajax(this);
              return false;
            }
        });
      });
      $(document).on("click",".payment", function () {
        if ($(this).attr('price') === undefined) {
        }else {
          $(".payment").removeClass("bg-info text-white");
          $(this).addClass("bg-info text-white");
          $(".buy").attr('price',$(this).attr('price'));
          $(".buy").attr('userid',$(".userid").val());
          $(".buy").attr('payment',$(this).attr('id'));
        }
      });
      $(document).on("click",".buy", function () {
        var cekurl = '<?php echo $gameCekId; ?>';
        var token = $("#g-recaptcha-response").val();
        var SendEmail = $('.sendemail').val();
        <?php if (!$this->ion_auth->logged_in()) {?>
          if  (SendEmail == ''){
            Swal.fire({
                  background : '#212529',
                  color: 'white',
                  icon: 'error',
                  title: 'Failed',
                  html: 'Silahakan masukan Email terlebih dahulu.',
                  // footer: '<a href="">Why do I have this issue?</a>'
                });
            return false;
          }
        <?php } ?>
        if (cekurl != '') {
          if ($(this).attr('userids') == 'false') {
            Swal.fire({
                  background : '#283269',
                  color: 'white',
                  icon: 'error',
                  title: 'Failed',
                  html: 'Silahakan masukan id yang benar.',
                  // footer: '<a href="">Why do I have this issue?</a>'
                });
            return false;
          }
        }

        if ($(this).attr('price') === "") {
          Swal.fire({
                background : '#283269',
                color: 'white',
                icon: 'error',
                title: 'Failed',
                html: 'Silahakan pilih metode pembayaran dulu.',
                // footer: '<a href="">Why do I have this issue?</a>'
              });
          return false;
        }
        if ($(".userid").val() === "") {
          Swal.fire({
                background : '#283269',
                color: 'white',
                icon: 'error',
                title: 'Failed',
                html: 'Silahkan isi id terlebih dahulu.',
                // footer: '<a href="">Why do I have this issue?</a>'
              });
          return false;
        }
        Swal.fire({
          background : '#283269',
          color: 'white',
          title: 'Anda yakin ingin melanjutkan pembelian? Pastikan user id benar!.',
          showCancelButton: true,
          confirmButtonText: 'Ok',
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {

              if ($(this).attr('payment') == 'BALANCE') {
                <?php if ($this->ion_auth->logged_in()){ ?>
                  if ($(this).attr('price') > <?php echo $this->ion_auth->user()->row()->Balance; ?>) {
                    alert('Saldo tidak cukup.');
                    return false;
                  }
                <?php } ?>
              }
              $('.loader').show();
              var price = $(this).attr('price');
              var userid = $(".userid").val();
              var payment = $(this).attr('payment');
              var itemid = $(this).attr('itemid');
              var nickname = $(this).attr('nickname');
              var itemname = $(this).attr('itemname');
              $.ajax({
                  url: "<?php echo base_url('prosess') ?>",
                  cache: false,
                  type: "post",
                  dataType: "json",
                  async: true,
                  data: {
                      "price": price,
                      "userid": userid,
                      "payment": payment,
                      "itemid":itemid,
                      "game" : "<?php echo $gameCode; ?>",
                      "token" : token,
                      "nickName" : nickname,
                      "SendEmail" : SendEmail,
                      "itemName" : itemname,
                  },
                  success: function (data) {
                    if (data === null) {
                      Swal.fire({
                            background : '#283269',
                            color: 'white',
                            icon: 'error',
                            title: 'Failed',
                            html: '<p> Pembelian gagal harap ulangi beberapa saat lagi, Atau pilih item lain. </p>',
                            // footer: '<a href="">Why do I have this issue?</a>'
                          });

                    } else {
                      if (data.status === "FAILED") {
                        Swal.fire({
                              background : '#283269',
                              color: 'white',
                              icon: 'error',
                              title: 'Failed',
                              html: '<p> Pembelian gagal harap ulangi beberapa saat lagi, Atau pilih item lain. </p>'
                              +'<p> Error : '+data.message+' </p>',
                              // footer: '<a href="">Why do I have this issue?</a>'
                            });

                      }else
                      if (data.status === "BALANCE") {
                        Swal.fire({
                          background : '#283269',
                          color: 'white',
                          icon: 'success',
                          title: 'Sukses',
                          html: '<p> Metode pembayaran : Balance </p>'
                          +'<p> User id : '+data.NickName+' </p>'
                          +'<p> Invoice : '+data.InvoiceId+' (Simpan untuk cek status pesanan)</p>'
                          +'<p> Terimakasih telah melakukan pembelian, pesanan akan segera di proses.</p>',
                          // footer: '<a href="">Why do I have this issue?</a>'
                        }).then((result) => {
                            if (result.isConfirmed) {
                              location.reload();
                            }
                          });
                      }else {
                        if (data.success) {
                          if (data.data.payment_method === "OVO") {
                            window.location.replace(data.data.checkout_url);
                          }else {
                            var qq = '';
                            for (var i = 0; i < data.data.instructions.length; i++) {
                              qq += "<p class='text-warning'>"+(i+1)+" : "+data.data.instructions[i].title+"</p>";
                              for (var j = 0; j < data.data.instructions[i].steps.length; j++) {
                                qq += "<p> - "+data.data.instructions[i].steps[j]+"</p>";
                              }
                            }
                            console.log(qq);
                            if (data.data.qr_url != undefined) {
                              Swal.fire({
                                imageUrl: data.data.qr_url != undefined ? data.data.qr_url : ' ',
                                imageWidth: 200,
                                imageHeight: 200,
                                background : '#283269',
                                color: 'white',
                                icon: 'success',
                                title: 'Sukses',
                                html: '<p> Metode pembayaran : '+data.data.payment_name+'</p>'
                                +'<p> Username : '+data.data.customer_name+'</p>'
                                +'<p> Invoice : '+data.data.merchant_ref+' (Simpan untuk cek status pesanan)</p>'
                                +'<p> Total : '+formatRupiah(data.data.amount.toString(), 'Rp. ')+'</p>'
                                +'<p> Item : '+data.data.order_items[0].name+'</p>'
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
                                html: '<p> Metode pembayaran : '+data.data.payment_name+'</p>'
                                +'<p> Username : '+data.data.customer_name+'</p>'
                                +'<p> Invoice : '+data.data.merchant_ref+' (Simpan untuk cek status pesanan)</p>'
                                +'<p> Total : '+formatRupiah(data.data.amount.toString(), 'Rp. ')+'</p>'
                                +'<p> Item : '+data.data.order_items[0].name+'</p>'
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
                        }
                      }
                    }
                    $('.loader').hide('fade');
                  },
                  error: function () {
                    Swal.fire({
                      background : '#0b0e2e',
                      color: 'white',
                      icon: 'error',
                      title: 'Failed',
                      text: 'Pembelian gagal harap ulangi beberapa saat lagi.',
                    })
                    $('.loader').hide('fade');
                  }

              });
          }
        })
      });
      cekaja();
      function cekaja(){
        var q = 'aku';
        for (var i = 0; i < 10; i++) {
          q += ' suka';
        }
        console.log(q);
      }
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
