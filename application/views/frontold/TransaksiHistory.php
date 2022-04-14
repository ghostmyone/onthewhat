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

<body class="bg-white text-white">

  <!-- ======= Navbar ======= -->
  <?php $this->load->view('front/_layout/Navbar'); ?>

  <main id="main">

    <section class="section pt-4">
        <div class="container">
          <div class="row mb-3">
            <div class="col-md-4 col-12 p-1">
              <div class="mvstyle py-auto rounded text-dark text-center">
                <h3 class="h3 text-white">Total Pembelian</h3>
                <p class="text-white"><?php echo "Rp " . number_format($totalPembelian, 2, ',', '.'); ?></p>
              </div>
            </div>
            <div class="col-md-4 col-12 p-1">
              <div class="mvstyle py-auto rounded text-dark text-center">
                <h3 class="h3 text-white">Pembelian Hari ini</h3>
                <p class="text-white"><?php echo "Rp " . number_format($pembelianHariIni, 2, ',', '.'); ?></p>
              </div>
            </div>
            <div class="col-md-4 col-12 p-1">
              <div class="mvstyle py-auto rounded text-dark text-center">
                <h3 class="h3 text-white">Total Deposit</h3>
                <p class="text-white"><?php echo "Rp " . number_format($totalDeposit, 2, ',', '.'); ?></p>
              </div>
            </div>
          </div>

          <div class="row align-items-stretch">
            <div class="col-md-12 ml-auto text-dark"  data-aos-delay="100">
              <div class="sticky-content table-responsive">
                <table id="example" class="table " >
                  <thead class="text-dark">
                      <tr>
                          <th>Id</th>
                          <th>User</th>
                          <th>Invoice Id</th>
                          <th>Payment Method</th>
                          <th>Item Name</th>
                          <th>NickName</th>
                          <th>Product</th>
                          <th>Rp.</th>
                          <th>Tanggal</th>
                          <th>Ket</th>
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody class="text-dark">
                    <?php $i=0; foreach ($data as $d): $i++?>
                      <tr>
                          <td><?php echo $d->Id; ?></td>
                          <td><?php if ($d->UserId == 0) {
    echo "Guest";
} else {
    $user = $this->db->where('id', $d->UserId)->get('users')->row();
    echo $user->first_name;
} ?></td>
                          <td><?php echo $d->InvoiceId; ?></td>
                          <td><?php echo $d->Payment; ?></td>
                          <td><?php echo $d->ItemName; ?></td>
                          <td><?php echo $d->NickName.' | '.$d->Note; ?></td>
                          <td><?php echo $d->Game.' | '. $d->ItemName; ?></td>
                          <td><?php echo "Rp " . number_format($d->Amount, 2, ',', '.'); ?></td>
                          <td><?php echo $d->TanggalUpdate; ?></td>
                          <td><?php echo $d->Ket; ?></td>
                          <td class="text-white"><?php if ($d->StatusOrder == 0) {
    echo '<div class="bg-primary text-center rounded" style="widht:100%;">
                              <p>Belum dibayar</p>
                            </div>';
} elseif ($d->StatusOrder == 1) {
    echo '<div class="bg-success text-center rounded" style="widht:100%;">
                              <p>Sudah Dibayar</p>
                            </div>';
} elseif ($d->StatusOrder == 2) {
    echo '<div class="bg-warning text-center rounded" style="widht:100%;">
                              <p>Expired</p>
                            </div>';
} elseif ($d->StatusOrder == 3) {
    echo '<div class="bg-danger text-center rounded" style="widht:100%;">
                              <p>Gagal</p>
                            </div>';
} elseif ($d->StatusOrder == 4) {
    echo '<div class="bg-danger text-center rounded" style="widht:100%;">
                              <p>Gagal By Server</p>
                            </div>';
} elseif ($d->StatusOrder == 5) {
    echo '<div class="bg-success text-center rounded" style="widht:100%;">
                              <p>Success</p>
                            </div>';
} elseif ($d->StatusOrder == 6) {
    echo '<div class="bg-warning text-center rounded" style="widht:100%;">
                              <p>Pending</p>
                            </div>';
} ?>
                        </td>
                      </tr>
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
          <div class="col-md-12 mvstyle rounded" style="padding:10px; margin-top:30px;margin-bottom:30px;">
            <h3 class="h3 text-white m-0">Riwayat Deposit</h3>
          </div>
          <div class="row align-items-stretch">
            <div class="col-md-12 ml-auto text-dark">
              <div class="sticky-content table-responsive">
                <table id="example2" class="table" >
                  <thead class="text-dark">
                    <tr>
                        <th>Id</th>
                        <th>User</th>
                        <th>Invoice Id</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                  </thead>
                  <tbody class="text-dark">
                    <?php $i=0; foreach ($dataDepo as $d): $i++?>
                      <tr>
                          <td><?php echo $d->Id; ?></td>
                          <td><?php $user = $this->db->where('id', $d->UserId)->get('users')->row(); echo $user->first_name; ?></td>
                          <td><?php echo $d->InvoiceId; ?></td>
                          <td><?php echo $d->PaymentMetod; ?></td>
                          <td><?php echo "Rp " . number_format($d->Balance, 2, ',', '.'); ?></td>
                          <td><?php echo $d->Tanggal; ?></td>
                          <td class="text-white"><?php if ($d->Status == 0) {
    echo '<div class="bg-primary text-center rounded" style="widht:100%;">
                              <p>Belum dibayar</p>
                            </div>';
} elseif ($d->Status == 1) {
    echo '<div class="bg-success text-center rounded" style="widht:100%;">
                              <p>Sukses</p>
                            </div>';
}elseif ($d->Status == 2) {
  echo '<div class="bg-warning text-center rounded" style="widht:100%;">
                            <p>Expired</p>
                          </div>';
}elseif ($d->Status == 3) {
  echo '<div class="bg-warning text-center rounded" style="widht:100%;">
                            <p>Failed</p>
                          </div>';
}  ?>

                        </td>
                      </tr>
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
    $('#example').DataTable({
      "order": [[ 0, "desc" ]],
      "pageLength": 5,
      "lengthMenu": [ [5,10, 25, 50, -1], [5,10, 25, 50, "All"] ]
    });
    $('#example2').DataTable({
      "order": [[ 0, "desc" ]],
      "pageLength": 5,
      "lengthMenu": [ [5,10, 25, 50, -1], [5,10, 25, 50, "All"] ]
    });
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
