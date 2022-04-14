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

            <div class="card-body">
                <form action="<?php echo base_url('dashboard/setting/update') ?>" method="post" enctype="multipart/form-data">
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Site Name</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="SiteName" required value="<?php echo $data->SiteName; ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bonus Register</label>
                <div class="col-sm-12 col-md-7">
                  <input type="number" class="form-control" name="BonusRegist" required value="<?php echo $data->BonusRegist; ?>">
                </div>
              </div>
              <!-- <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Resseler Dibawah Rp. 90.000</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="Resseler1" required value="<?php echo $data->Resseler1; ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Member Dibawah Rp. 90.000</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="Member1" required value="<?php echo $data->Member1; ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Resseler Diatas Rp. 90.000</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="Resseler2" required value="<?php echo $data->Resseler2; ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Member Diatas Rp. 90.000</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="Member2" required value="<?php echo $data->Member2; ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga VIP</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="Api" required value="<?php echo $data->Api; ?>">
                </div>
              </div> -->
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div></div>
    </div>
  </section>
</div>

<?php $this->load->view('_layout/footer'); ?>
