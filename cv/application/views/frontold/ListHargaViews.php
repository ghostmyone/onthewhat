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
    color: black;
  }
    a.readmore{
      cursor: pointer;
      color: black;
    }
    .readmorea{
      cursor: pointer;
    }
    .readmore:hover {
      color: red;

    }
  </style>
</head>

<body class="bg-white text-dark">

  <!-- ======= Navbar ======= -->
  <?php $this->load->view('front/_layout/Navbar'); ?>

  <main id="main">

    <section class="section pt-4">

        <div class="container">
          <div class="row align-items-stretch">
            <div class="col-md-12 ml-auto text-white " data-aos="fade-up" data-aos-delay="100">
              <div class="sticky-content table-responsive">
                <table id="example" class="table col-12 col-md-12">
                  <thead class="text-dark">
                      <tr>
                          <th>Id</th>
                          <th>Nama Layanan</th>
                          <th>Harga VIP</th>
                          <th>Harga Resseler</th>
                          <th>Harga Member</th>
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody class="text-dark">
                    <?php foreach ($dataProduct as $c): ?>
                      <tr class="text-white mvstyle">
                        <th class=""><?php echo $c->ProductName ?></th>
                        <th class=""></th>
                        <th class="">Harga VIP</th>
                        <th class="">Harga Resseler</th>
                        <th class="">Harga Member</th>
                        <th class=""></th>
                      </tr>
                      <?php $i=0; foreach ($dataItem as $d): $i++?>
                        <?php if ($d['brand'] == $c->ProductName): ?>
                            <tr>
                              <td><?php echo $d['sku_code']; ?></td>
                              <td><?php echo $d['product_name']; ?></td>
                              <td><?php echo "Rp " . number_format($d['price_vip'],2,',','.'); ?></td>
                              <td><?php echo "Rp " . number_format($d['price_seller'],2,',','.'); ?></td>
                              <td><?php echo "Rp " . number_format($d['price_member'],2,',','.'); ?></td>
                              <td><div class="bg-success text-center rounded text-white" style="widht:100%;">
                                <p>Tersedia</p>
                              </div>
                            </td>

                          </tr>
                          <?php endif; ?>
                      <?php endforeach; ?>
                    <?php endforeach; ?>


                  </tbody>
        <!-- <tfoot class="text-white">
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot> -->
    </table>
              </div>
            </div>
          </div>
        </div>
    </section>
  </main>
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content bg-dark">
      <div class="modal-header" style="border-bottom: 1px solid #ffc107;">
        <h5 class="modal-title">Detail pembayaran</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body payment-detail">

      </div>
      <div class="modal-footer" style="border-top: 1px solid #ffc107;">
        <p><?php echo $title ?></p>
        <!-- <button type="button" class="btn btn-warning">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
      </div>
    </div>
  </div>
</div>

  <!-- ======= Footer ======= -->

  <!-- Vendor JS Files -->
  <?php $this->load->view('front/_layout/Footer'); ?>
  <script type="text/javascript">
  $( document ).ready(function() {

    console.log( "ready!" );
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
