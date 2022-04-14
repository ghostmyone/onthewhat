<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_layout/HeaderNew'); ?>

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo lang('create_group_heading');?></h1>
    </div>
    <div class="section-body">
      <?php
      if($this->session->flashdata('message') || $message){
      ?>
      <div class="alert alert-primary alert-has-icon">
        <div class="alert-icon">
          <i class="far fa-lightbulb"></i>
        </div>
        <div class="alert-body">
          <div class="alert-title"></div>
          <?php echo $message; ?>
        </div>
      </div>
      <?php
      unset($_SESSION['message']);
       ?>
      <?php
      }
      ?>
      <!-- <p class="section-lead">
        <p><?php echo lang('create_group_subheading');?></p>
      </p> -->
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4><?php echo lang('create_group_heading');?> | <?php echo lang('create_group_subheading');?></h4>
            </div>
            <?php echo form_open("dashboard/auth/create_group");?>
            <div class="card-body">
              <div class="form-group">
                <label><?php echo lang('create_group_name_label', 'group_name');?></label>
                <?php echo form_input($group_name);?>
              </div>
              <div class="form-group">
                <label><?php echo lang('create_group_desc_label', 'description');?></label>
                <?php echo form_input($description);?>
              </div>
              <?php echo form_submit('submit', lang('create_group_submit_btn'),"class='btn btn-primary'");?>
            </div>
            <?php echo form_close();?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php $this->load->view('_layout/footer'); ?>
