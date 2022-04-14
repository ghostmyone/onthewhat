<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php $this->load->view('front/_layout/Head'); ?>
  </head>
  <body class="maincolor">
    <?php $this->load->view('front/_layout/Navbar'); ?>
    <div class="maincolor m-0" >
      <div class="container" >
        <div class="title text-left " style="margin-bottom:20px;">
          Transaksi List
        </div>
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
          <div class="col-md-12 ml-auto text-white"  data-aos-delay="100">
            <div class="sticky-content table-responsive text-white">
              <table id="example2" class="table maincolor" >
                <thead class="text-white mvstyle">
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
                <tbody class="text-white maincolor">
                  <?php $i=0; foreach ($data as $d): $i++?>
                    <tr class="maincolor">
                        <td class="maincolor"><?php echo $d->Id; ?></td>
                        <td class="maincolor"><?php if ($d->UserId == 0) {
  echo "Guest";
} else {
  $user = $this->db->where('id', $d->UserId)->get('users')->row();
  echo $user->first_name;
} ?></td>
                        <td class="maincolor"><?php echo $d->InvoiceId; ?></td>
                        <td class="maincolor"><?php echo $d->Payment; ?></td>
                        <td class="maincolor"><?php echo $d->ItemName; ?></td>
                        <td class="maincolor"><?php echo $d->NickName.' | '.$d->Note; ?></td>
                        <td class="maincolor"><?php echo $d->Game.' | '. $d->ItemName; ?></td>
                        <td class="maincolor"><?php echo "Rp " . number_format($d->Amount, 2, ',', '.'); ?></td>
                        <td class="maincolor"><?php echo $d->TanggalUpdate; ?></td>
                        <td class="maincolor"><?php echo $d->Ket; ?></td>
                        <td class="maincolor text-white"><?php if ($d->StatusOrder == 0) {
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
        <div class="title text-left mt-2" style="margin-bottom:20px;margin-top:30px;">
          Deposit List
        </div>
        <div class="row align-items-stretch">
          <div class="col-md-12 ml-auto text-dark">
            <div class="sticky-content table-responsive">
              <table id="example2" class="table" >
                <thead class="text-white mvstyle">
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
                <tbody class="text-white">
                  <?php $i=0; foreach ($dataDepo as $d): $i++?>
                    <tr>
                        <td class="maincolor"><?php echo $d->Id; ?></td>
                        <td class="maincolor"><?php $user = $this->db->where('id', $d->UserId)->get('users')->row(); echo $user->first_name; ?></td>
                        <td class="maincolor"><?php echo $d->InvoiceId; ?></td>
                        <td class="maincolor"><?php echo $d->PaymentMetod; ?></td>
                        <td class="maincolor"><?php echo "Rp " . number_format($d->Balance, 2, ',', '.'); ?></td>
                        <td class="maincolor"><?php echo $d->Tanggal; ?></td>
                        <td class="maincolor text-white"><?php if ($d->Status == 0) {
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
    </div>
    <?php $this->load->view('front/_layout/Footer'); ?>
    <script type="text/javascript">
    $( document ).ready(function() {
      console.log( "ready!" );
      $('#example2').DataTable({
         "order": [[ 0, "desc" ]]
      });

      $('.dataTables_length').addClass('text-white');
      $("[name*='example2_length']").addClass('text-dark mvstyle');
      $('.dataTables_filter').addClass('text-white');
      $('input').addClass('text-white');
      $('.paginate_button').addClass('text-white');
      $('.dataTables_info').addClass('text-white');

    });
    </script>
  </body>
</html>
