<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php $this->load->view('front/_layout/Head'); ?>
  </head>
  <body class="maincolor">
    <?php $this->load->view('front/_layout/Navbar'); ?>
    <div class="maincolor m-0" >
      <div class="container">
        <div class="row">
          <div class=" col-md-12 col-sm-12 col-lg-4">
            <img src="<?php echo $dataProduct->ProductImage; ?>" alt="Image" class="img-fluid mt-1">
            <div class="title text-left">
              <?php echo $dataProduct->ProductName; ?>
            </div>
            <p class="subtitle mb-4 readmorep"><span class="text-muted deskpro">PERINGATAN: Mohon untuk hubungi pihak Higgs Domino jika anda ada pertanyaan perihal Top up ! Cukup masukan User ID Higgs Domino Anda, pilih jumlah Top up yang Anda inginkan, selesaikan pembayaran, dan Diamond akan secara langsung ditambahkan ke akun Higgs Domino Anda.Bayarlah menggunakan GoPay, OVO, Bank Transfers, DANA, Shopee Pay, LinkAja, Alfamart . <?php echo SITE_NAME; ?> adalah cara terbaik untuk top up Higgs Domino secara online tanpa perlu kartu kredit, registrasi ataupun log-in.Unduh dan mainkan Higgs Domino sekarang!</span>
            </p>
          </div>

          <div class="seccolor col-md-12 col-sm-12 col-lg-7"  style="padding-bottom:30px;">
            <div class="title text-left mt-2" >
              1. Masukan ID / Data
            </div>
            <div class="subtitle" style="margin-top:20px;">
              <?php echo $dataProduct->ProductTutor; ?>
            </div>
            <div class="mt-2">
              <input value="" nickname="" status="true" class="form-control produkcolor inputid userid" type="text" name="id" id="id">
            </div>
            <div class="title operator text-left mt-2" >
              2. Pilih Nominal Top Up
            </div>
            <div class="row listpulsa" style="margin-top:20px;">

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
    </div>
    <?php $this->load->view('front/_layout/Footer'); ?>
    <script type="text/javascript">
    $( document ).ready(function() {
      console.log( "ready!" );
      getPayment();
      $(document).on("mouseover",".divitem",function(){
        $(this).css("background-color","#17a2b8");
      });
      $(document).on("mouseout",".divitem",function(){
        $(this).css("background-color","#283269");
      });
      $(document).on("mouseover",".mvstyle",function(){
        $(this).css("background-color","#17a2b8");
      });
      $(document).on("mouseout",".mvstyle",function(){
        $(this).css("background-color","#283269");
      });

      getPayment();
      function getPayment(){
        $.ajax({
            url: "<?php echo base_url('order/getPayment') ?>",
            cache: false,
            type: "get",
            dataType: "json",
            async: true,
            success: function (data) {
              if (data === null) {
                Swal.fire({
                      background : '#283269',
                      color: 'white',
                      icon: 'error',
                      title: 'Failed',
                      html: 'TERJADI KESALAHAN SILAHKAN COBA KEMBALI.',
                      // footer: '<a href="">Why do I have this issue?</a>'
                    });
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
      $(".userid").keyup(function(){
        var ops = parseOperator($(this).val());
        //console.log(ops['operator']+' '+ops['phone']);
        if (ops['operator'] != null) {
          $('.operator').text('2. Pilih Nominal Top Up | '+ops['operator']);
        }
      });
      $(".userid").focusout(function(){
        var ops = parseOperator($(this).val());

        //console.log(ops['operator']+' '+ops['phone']);
        if (ops['operator'] != null) {
          $('.loader').show();
          $.ajax({
              url: "<?php echo base_url('pulsa/getdata') ?>",
              cache: false,
              type: "post",
              dataType: "json",
              async: true,
              data: {
                  "operator": ops['operator'],
              },
              success: function (data) {
                if (data === null) {
                  $('.loader').hide('fade');
                  Swal.fire({
                        background : '#283269',
                        color: 'white',
                        icon: 'error',
                        title: 'Failed',
                        html: 'TERJADI KESALAHAN SILAHKAN COBA KEMBALI.',
                        // footer: '<a href="">Why do I have this issue?</a>'
                      });
                } else {
                  $('.loader').hide('fade');
                  $(".listpulsa").empty();
                  for (var i = 0; i < data.length; i++) {
                    if (data[i].brand === ops['operator'] && data[i].category == 'Pulsa' && data[i].buyer_product_status == true && data[i].seller_product_status == true) {

                      $(".listpulsa").append('<div class="rounded p-2 col-6 col-sm-6 col-md-6 col-lg-4 text-white text-center " style=" cursor: pointer;" >'
                  +'<div class="rounded  divitem item" style="background-color:#283269;" price="'+data[i].newprice+'" id="'+data[i].buyer_sku_code+'">'
                    +'<div class="text-white" style="padding:10px;">'
                      +''+data[i].product_name+''
                    +'</div>'
                  +'</div>'
                +'</div>');
                    }
                  }
                }
              },
              error: function () {
                $('.loader').hide('fade');
                $.ajax(this);
                return false;
              }
          });
        }
      });
      function parseOperator(phone) {
      var OperatorPrefix = {
          TELKOMSEL: ["0811","0812","0813","0821","0822","0823","0851","0852","0853"],
          INDOSAT: ["0814","0815","0816","0855","0856","0857","0858"],
          TRI: ["0895","0896","0897","0898","0899"],
          SMART: ["0881","0882","0883","0884","0885","0886","0887","0888","0889"],
          XL: ["0817","0818","0819","0859","0877","0878"],
          AXIS: ["0838","0831","0832","0833"]
      }

      if (phone.length > 13) return {
          operator: null
      }
      for (var name in OperatorPrefix) {
          var _operator = OperatorPrefix[name];
          for (var index in _operator) {
              if (phone.startsWith(_operator[index])) return {
                  operator: name,
                  prefix: _operator[index],
                  phone: phone
              }
          }
      }

      return {
          operator: null
      }
    }
      if ($(window).width() < 960) {
         $(".deskpro").text('PERINGATAN: Mohon untuk memasukan nomer ponsel dengan benar...');
         $(".readmorep").append('<a style="color:white;" class="readmorea">Readmore</a>');
      }
      else {
       $(".deskpro").text('Mohon untuk memasukan nomer ponsel dengan benar. kesalahan nomer ponsel bukan tanggung jawab pihak kami.');
      }
      $('.readmorep').on('click','.readmorea',function() {
        $(".deskpro").text('Mohon untuk memasukan nomer ponsel dengan benar. kesalahan nomer ponsel bukan tanggung jawab pihak kami.');
        $(".readmorea").remove();
        $(".readmorep").append('<a style="color:white;" class="readmorem">Hide</a>');
      });
      $('.readmorep').on('click','.readmorem',function() {
        $(".deskpro").text('Mohon untuk memasukan nomer ponsel dengan benar....');
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
      $(document).on("click",".payment", function () {
        //console.log($(this).attr('price'));
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
          title: 'Anda yakin ingin melanjutkan pembelian? Pastikan nomer sudah benar!.',
          showCancelButton: true,
          confirmButtonText: 'Ok',
        }).then((result) => {
            if (result.isConfirmed) {
              if ($(this).attr('payment') == 'BALANCE') {
                <?php if ($this->ion_auth->logged_in()) { ?>
                  if ($(this).attr('price') > <?php echo $this->ion_auth->user()->row()->Balance; ?>) {
                    Swal.fire({
                          background : '#283269',
                          color: 'white',
                          icon: 'error',
                          title: 'Failed',
                          html: '<p> Pembelian gagal harap ulangi beberapa saat lagi, Atau pilih item lain. </p>'
                          +'<p> Error : Saldo tidak cukup. </p>',
                          // footer: '<a href="">Why do I have this issue?</a>'
                        });
                    return false;
                  }
                <?php } ?>
              }
              $('.loader').show();
              var price = $(this).attr('price');
              var userid = $(".userid").val();
              var payment = $(this).attr('payment');
              var itemid = $(this).attr('itemid');
              var nickname = $(".userid").val();
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
                      "game" : 'PULSA',
                      "token" : token,
                      "nickName" : nickname,
                      "itemName" : itemname,
                      "SendEmail" : SendEmail,
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
            });
      });
      $(document).on("click",".item", function () {
        $('.loader').show();
        $('.item').removeClass("bg-info");
        $(this).addClass("bg-info");
        var itemId = $(this).attr('id');
        var price = $(this).attr('price');
        $(".buy").attr('itemid',itemId);
        //$(".buy").attr('price',price);
        $(".buy").attr('itemname',$(this).text());
        var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id
        // alert('MANTAP AJG #' + clickedBtnID);
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
                $('.loader').hide('fade');
                alert('TERJADI KESALAHAN SILAHKAN COBA KEMBALI.');
              } else {
                // console.log(data.price);
                // console.log(data.data.length);
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
