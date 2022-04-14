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
                   action="<?php echo base_url('dashboard/item/update') ?>"
                <?php } else { ?> action="<?php echo base_url('dashboard/item/submit') ?>" <?php } ?> method="post" enctype="multipart/form-data">
              <div class="form-group row mb-4">
                <input type="hidden" name="Id" value="<?php if ($page == 'edit'): echo $data->Id; ?>

                <?php endif; ?>">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Item Name</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="ItemName" required value="<?php if ($page == 'edit') {echo $data->ItemName;} ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Item Sku</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="ItemSku" required value="<?php if ($page == 'edit') {echo $data->ItemSku;} ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Item Price</label>
                <div class="col-sm-12 col-md-7">
                  <input type="number" class="form-control" name="ItemPrice" required value="<?php if ($page == 'edit') {echo $data->ItemPrice;} ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Platform</label>
                <div class="col-sm-12 col-md-7">
                  <select class="form-control" name="ProductCode">
                    <?php $dataProduct = $this->db->where('ProductType','0')->get('data_product')->result(); ?>
                    <?php foreach ($dataProduct as $d): ?>
                      <option <?php if ($page == 'edit') { if ($data->ProductCode == $d->ProductCode){ echo "selected"; } }  ?> value="<?php echo $d->ProductCode; ?>"><?php echo $d->ProductName.' | '.$d->ProductCode; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                <div class="col-sm-12 col-md-7">
                  <select class="form-control selectric" name="Status">
                    <option <?php if ($page == 'edit') {
        if ($data->ItemStatus == 1) {
            echo "selected";
        }
    } ?> value="1">Active</option>
                    <option <?php if ($page == 'edit') {
        if ($data->ItemStatus == 0) {
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
