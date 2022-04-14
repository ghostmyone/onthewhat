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
    <div class="alert alert-primary alert-has-icon">
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
            <div class="card-header">
              <a href="<?php echo base_url('dashboard/price/create'); ?>" style="border-radius:5px;" class="btn btn-info">Add Data</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                    <th>Group Name</th>
                    <th>Price Range</th>
                    <th>Mark Up</th>
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                <?php $i =0; ?>
                <?php foreach ($data as $d):?>
                    <?php $i++ ?>
                    <tr>
                      <td><?php echo $d->GroupName; ?></td>
                      <td><?php echo 'Rp. '.number_format($d->Price, 2, ',', '.').' - Rp. '.number_format($d->Price2, 2, ',', '.'); ?></td>
                      <td><?php echo $d->MarkUp; ?></td>
                      <td><?php if ($d->Status == 0) {
                          echo '<div class="bg-danger text-center text-white rounded" style="widht:100%;">
                                                <p>Non Aktif</p>
                                              </div>';
                      } else {
                          echo '<div class="bg-success text-center text-white rounded" style="widht:100%;">
                                                <p>Aktif</p>
                                              </div>';
                      } ?></td>
                      <td> <?php if ($d->Status == 0) { ?>
                      <a href="<?php echo base_url('dashboard/price/active/'.$d->Id.''); ?>" class="btn btn-success">Aktifkan</a>
                    <?php } else {
        ?>
                      <a href="<?php echo base_url('dashboard/price/active/'.$d->Id.''); ?>" class="btn btn-danger">Non Aktifkan</a>
                    <?php
    } ?>
                    <a href="<?php echo base_url('dashboard/price/edit/'.$d->Id.''); ?>" class="btn btn-primary">Edit</a>
                  </td>
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
