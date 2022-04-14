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
                <form <?php if ($page == 'edit') { ?>
                   action="<?php echo base_url('dashboard/price/update') ?>"
                <?php } else { ?> action="<?php echo base_url('dashboard/price/submit') ?>" <?php } ?> method="post" enctype="multipart/form-data">
              <div class="form-group row mb-4">
                <input type="hidden" name="Id" value="<?php if ($page == 'edit'): echo $data->Id; ?>

                <?php endif; ?>">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Price 1</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="Price" required value="<?php if ($page == 'edit') {echo $data->Price;} ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Price 2</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="Price2" required value="<?php if ($page == 'edit') {echo $data->Price2;} ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">MarkUp</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="MarkUp" required value="<?php if ($page == 'edit') {echo $data->MarkUp;} ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Group</label>
                <div class="col-sm-12 col-md-7">
                  <select class="form-control selectric" name="GroupName">
                    <?php
                    $dataGroup = $this->db->get('groups')->result();
                    foreach ($dataGroup as $d): ?>
                    <option <?php if ($page == 'edit') { if ($d->name == $data->GroupName) {  echo "selected";  } } ?> value="<?php echo $d->name; ?>"><?php echo $d->name; ?></option>
                    <?php endforeach; ?>


                  </select>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                <div class="col-sm-12 col-md-7">
                  <select class="form-control selectric" name="Status">
                    <option <?php if ($page == 'edit') {
        if ($data->Status == 1) {
            echo "selected";
        }
    } ?> value="1">Active</option>
                    <option <?php if ($page == 'edit') {
        if ($data->Status == 0) {
            echo "selected";
        }
    } ?> value="0">Non Active</option>
                  </select>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                  <button type="submit" class="btn btn-primary">Submit</button>
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
