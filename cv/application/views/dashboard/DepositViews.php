<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_layout/HeaderNew'); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
			<h1><?php echo $title; ?></h1>


    </div>

    <div class="section-body">
		<?php
    if ($this->session->flashdata('message')) {
        ?>
    <div class="alert alert-info alert-has-icon">
      <div class="alert-icon">
        <i class="far fa-lightbulb"></i>
      </div>
      <div class="alert-body">
        <div class="alert-title"></div>
        <?php echo $this->session->flashdata('message'); ?>
      </div>
    </div>
    <?php
    unset($_SESSION['message']); ?>
    <?php
    }
    ?>
			<div class="row">
        <div class="col-12">
          <div class="card">
            <!-- <div class="card-header">
              <h4><?php echo $title; ?></h4>
            </div> -->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="table-1">
                  <thead>
                    <tr>
                    <th>Id</th>
                    <th>User</th>
                    <th>Invoice Id</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                <?php $i =0; ?>
                <?php foreach ($dataDepo as $d):?>
                    <?php $i++ ?>
                    <tr>
                      <td><?php echo $d->Id; ?></td>
                      <td><?php if ($d->UserId == 0) {
        echo "Guest";
    } else {
        $user = $this->db->where('id', $d->UserId)->get('users')->row();
        echo $user->first_name;
    } ?></td>
                      <td><?php echo $d->InvoiceId; ?></td>
                      <td><?php echo $d->PaymentMetod; ?></td>
                      <td><?php echo "Rp " . number_format($d->Balance, 2, ',', '.'); ?></td>
                      <td><?php echo $d->Tanggal; ?></td>
                      <td><?php if ($d->Status == 0) {
        echo '<div class="bg-danger text-center text-white rounded" style="widht:100%;">
                              <p>Belum dibayar</p>
                            </div>';
    } else {
        echo '<div class="bg-success text-center text-white rounded" style="widht:100%;">
                              <p>Sukses</p>
                            </div>';
    } ?>
                      <td> <?php if ($d->Status == 0) { ?>
                      <a href="<?php echo base_url('dashboard/deposit/mv?inv='.$d->InvoiceId.''); ?>" class="btn btn-info">Acc</a>
                    <?php } ?> </td>
                    </tr>
				<?php endforeach;?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>




			  </div>
  </section>
</div>

<?php $this->load->view('_layout/footer'); ?>
