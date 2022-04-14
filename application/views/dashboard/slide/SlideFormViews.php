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
            <div class="card-header">
              <h4>Write Your Slide</h4>
            </div>
            <div class="card-body">
                <form <?php if ($page == 'edit') { ?>
                   action="<?php echo base_url('dashboard/slide/update') ?>"
                <?php } else { ?> action="<?php echo base_url('dashboard/slide/submit') ?>" <?php } ?> method="post" enctype="multipart/form-data">
              <div class="form-group row mb-4">
                <input type="hidden" name="Id" value="<?php if ($page == 'edit'): echo $data->Id; ?>

                <?php endif; ?>">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Slide Name</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="NameSlide" required value="<?php if ($page == 'edit') {
        echo $data->NameSlide;
    } ?>">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Slide Deskripsi</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="DescSlide" required value="<?php if ($page == 'edit') {
        echo $data->DescSlide;
    } ?>">
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
                    <input type="file" name="imageslide" id="image-upload" <?php if ($page != 'edit') {
        echo "required";
    } ?>/>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                <div class="col-sm-12 col-md-7">
                  <select class="form-control selectric" name="StatusSlide">
                    <option <?php if ($page == 'edit') {
        if ($data->StatusSlide == 1) {
            echo "selected";
        }
    } ?> value="1">Active</option>
                    <option <?php if ($page == 'edit') {
        if ($data->StatusSlide == 0) {
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
