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
                   action="<?php echo base_url('dashboard/product/update') ?>"
                <?php } else { ?> action="<?php echo base_url('dashboard/product/submit') ?>" <?php } ?> method="post" enctype="multipart/form-data">
              <div class="form-group row mb-4">
                <input type="hidden" name="Id" value="<?php if ($page == 'edit'): echo $data->Id; ?>

                <?php endif; ?>">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Product Name</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="ProductName" required value="<?php if ($page == 'edit') {echo $data->ProductName;} ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Product Code</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="ProductCode" required value="<?php if ($page == 'edit') {echo $data->ProductCode;} ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Product Category</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="ProductCat" required value="<?php if ($page == 'edit') {echo $data->ProductCat;} ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Product Tutor</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="ProductTutor" required value="<?php if ($page == 'edit') {echo $data->ProductTutor;} ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mode Transaksi</label>
                <div class="col-sm-12 col-md-7">
                  <select class="form-control" name="ProductType">
                    <option <?php if ($page == 'edit') { if ($data->ProductType == '0'){ echo "selected"; } }  ?> value="0">MANUAL</option>
                    <option <?php if ($page == 'edit') { if ($data->ProductType == '1'){ echo "selected"; } }   ?> value="1">OTOMATIS</option>
                  </select>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Product Link</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="ProductLink" required value="<?php if ($page == 'edit') {echo $data->ProductLink;} ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail 1080 * 300 <?php if ($page == 'edit'): ?>
                  Biarkan jika tidak dirubah.
                <?php endif; ?></label>
                <div class="col-sm-12 col-md-7">
                  <div id="image-preview" class="image-preview" <?php if ($page == 'edit'): ?>
                    style="background-image:url('<?php echo $foto ?>');background-size: cover;
                      background-position: center center;"
                  <?php endif; ?> >
                    <label for="image-upload" id="image-label">Choose File</label>
                    <input type="file" name="ImageUpload" id="image-upload" <?php if ($page != 'edit') {
        echo "required";
    } ?>/>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                <div class="col-sm-12 col-md-7">
                  <select class="form-control selectric" name="Status">
                    <option <?php if ($page == 'edit') {
        if ($data->ProductStatus == 1) {
            echo "selected";
        }
    } ?> value="1">Active</option>
                    <option <?php if ($page == 'edit') {
        if ($data->ProductStatus == 0) {
            echo "selected";
        }
    } ?> value="0">Non Active</option>
                  </select>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                  <button type="submit" class="btn btn-primary">Create Post</button>
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
