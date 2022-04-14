<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view('front/_layout/Head'); ?>
  <style media="screen">
  .input-group-sm>.input-group-append>select.btn:not([size]):not([multiple]), .input-group-sm>.input-group-append>select.input-group-text:not([size]):not([multiple]), .input-group-sm>.input-group-prepend>select.btn:not([size]):not([multiple]), .input-group-sm>.input-group-prepend>select.input-group-text:not([size]):not([multiple]), .input-group-sm>select.form-control:not([size]):not([multiple]), select.form-control-sm:not([size]):not([multiple]){
    height: calc(2.25rem + 2px);
  }
  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }
  a:not([href]):not([tabindex]){
    color: white;
  }
    a.readmore{
      cursor: pointer;
      color: white;
      border-color: white;
    }
    .readmorea{
      cursor: pointer;
    }
    .readmore:hover {
      color: red;

    }
  </style>
</head>

<body class="bg-white text-white">

  <!-- ======= Navbar ======= -->
  <?php $this->load->view('front/_layout/Navbar'); ?>

  <main id="main">

    <section class="section pt-4">

        <div class="container">
          <div class="p-1">
            <div class="mvstyle row rounded ">
              <div class="col-md-8 col-8 mt-1 mb-1">
                <!-- 60002123 -->
                <input value=""  style="background:#212529!important;" type="text" placeholder="Masukan id pesanan" name="id" class="form-control bg-dark text-white cekid" id="id" required>
              </div>
              <div class="col-md-4 col-4 mt-1 mb-1">
                <p style="width:100%;margin:0px;height:46px;" class="text-center">
                  <a  style="width:100%;height:46px;padding-top:15px;"  class="readmore text-center cek">CEK</a>
                </p>
              </div>
            </div>
            <div class="col-md-12 col-12 mt-4">
              <h1 class="h1 invoiceid text-dark">-</h1>
              <div class="status">

              </div>
              <p class="payment text-dark"></p> <br>
              <p class="itemname text-dark"></p> <br>
              <p class="id text-dark"></p> <br>
              <p class="total text-dark"></p> <br>
              <p class="tanggal text-dark"></p> <br>
              <p class="ket text-dark"></p> <br>
            </div>
          </div>


        </div>
    </section>
  </main>


  <!-- ======= Footer ======= -->

  <!-- Vendor JS Files -->
  <?php $this->load->view('front/_layout/Footer'); ?>
  <script type="text/javascript">
  $( document ).ready(function() {
    console.log( "ready!" );
    $(document).on('click','.cek', function(){
      var cekid = $('.cekid').val();
      if (cekid != '') {
          $.LoadingOverlay("show");
        $.ajax({
          url: "<?php echo base_url('pesanan/getdata'); ?>",
          cache: false,
          type: "post",
          dataType: "json",
          async: true,
          data:{
            'invoiceid' : cekid
          },
          success: function(data){
            if (data.status) {
              $('.status').empty();
              $('.invoiceid').text(data.InvoiceId);
              $('.payment').text('Payment Method : '+data.data.Payment);
              $('.itemname').text('ItemName : '+data.data.ItemName);
              $('.id').text('Id : '+data.data.NickName+' | '+data.data.Note);
              $('.total').text('Total pembayaran : '+data.data.Amount);
              $('.tanggal').text('Tanggal : '+data.data.TanggalUpdate);
              $('.ket').text('Keterangan / SN: '+data.data.Ket);
              $('.status').append(data.dataStatus);
            }else {
              $('.status').empty();
              $('.invoiceid').text('');
              $('.payment').text('');
              $('.itemname').text('');
              $('.id').text('');
              $('.total').text('');
              $('.tanggal').text('');
              $('.ket').text('');
              alert('InvoiceId / Pesanan tidak ditemukan.');
            }
              $.LoadingOverlay("hide");
            console.log(data);
          },
          error: function(){
            $('.status').empty();
            alert('InvoiceId / Pesanan tidak ditemukan.');
            $.LoadingOverlay("hide");
          }
        });
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
