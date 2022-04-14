<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php $this->load->view('front/_layout/Head'); ?>
  </head>
  <body class="maincolor">
    <?php $this->load->view('front/_layout/Navbar'); ?>
    <div class="maincolor m-0" style="padding-bottom:50px;">
      <div class="container" >
        <div class="sticky-content table-responsive " >
          <table id="example" class="table col-12 col-md-12">
                  <thead class="text-white">
                      <tr>
                          <th>Id</th>
                          <th>Nama Layanan</th>
                          <th>Harga VIP</th>
                          <th>Harga Resseler</th>
                          <th>Harga Member</th>
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody class="text-white">
                    <?php foreach ($dataCat as $c): ?>
                      <tr>
                        <th class="bg-mv1 text-white"><?php echo $c ?></th>
                        <th class="bg-mv1 text-white"></th>
                        <th class="bg-mv1 text-white">Harga VIP</th>
                        <th class="bg-mv1 text-white">Harga Resseler</th>
                        <th class="bg-mv1 text-white">Harga Member</th>
                        <th class="bg-mv1 text-white"></th>
                      </tr>
                      <?php $i=0; foreach ($data as $d): $i++?>
                        <?php if ($d->brand == $c): ?>
                          <?php if ($d->buyer_product_status == true): ?>
                            <tr>
                              <td><?php echo $d->buyer_sku_code; ?></td>
                              <td><?php echo $d->product_name; ?></td>
                              <td><?php echo "Rp " . number_format($d->price_vip,2,',','.'); ?></td>
                              <td><?php echo "Rp " . number_format($d->price_seller,2,',','.'); ?></td>
                              <td><?php echo "Rp " . number_format($d->price_member,2,',','.'); ?></td>
                              <td><?php if ($d->seller_product_status == false) {
                                echo '<div class="bg-mv1 text-center rounded" style="widht:100%;">
                                  <p class="text-white">Tidak Tersedia</p>
                                </div>';
                              }else {
                                echo '<div class="bg-success text-center rounded" style="widht:100%;">
                                  <p class="text-white">Tersedia</p>
                                </div>';
                              } ?>

                            </td>

                          </tr>
                          <?php endif; ?>
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
    <?php $this->load->view('front/_layout/Footer'); ?>
    <script type="text/javascript">
    $( document ).ready(function() {
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
