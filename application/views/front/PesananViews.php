<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php $this->load->view('front/_layout/Head'); ?>
  </head>
  <body class="maincolor">
    <?php $this->load->view('front/_layout/Navbar'); ?>
    <div class="maincolor pt-4 m-0" style="padding-bottom:50px;">
      <div class="container" >
        <div class="p-1" >
          <div class="mvstyle row rounded ">
            <div class="col-md-8 col-8 mt-1 mb-1">
              <input type="text" placeholder="Masukan id pesanan" name="id" value="" class="produkcolor cekid form-control text-white inputid" id="id" required>
            </div>
            <div class="col-md-4 col-4 mt-2 mb-1">
              <p style="width:100%;margin:0px;height:46px;" class="text-center">
                <button type="submit" name="button" class="form-control btn btn-success cek">CEK</button>
              </p>
            </div>
          </div>
          <div class="col-md-12 col-12 mt-4">
            <h5 class="h5 invoiceid text-white">-</h5>
            <div class="status text-white">

            </div>
            <p class="payment text-white"></p> <br>
            <p class="itemname text-white"></p> <br>
            <p class="id text-white"></p> <br>
            <p class="total text-white"></p> <br>
            <p class="tanggal text-white"></p> <br>
            <p class="ket text-white"></p> <br>
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view('front/_layout/Footer'); ?>
    <script type="text/javascript">
    $( document ).ready(function() {
      $(document).on('click','.cek', function(){
        var cekid = $('.cekid').val();
        if (cekid != '') {
            $('.loader').show();
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
                $('.loader').hide('fade');
              console.log(data);
            },
            error: function(){
              $('.status').empty();
              alert('InvoiceId / Pesanan tidak ditemukan.');
              $('.loader').hide('fade');
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
