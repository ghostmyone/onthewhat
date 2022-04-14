<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_layout/HeaderNew'); ?>

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo lang('create_user_heading');?></h1>
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
        <p><?php echo lang('create_user_subheading');?></p>
      </p> -->
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4><?php echo lang('create_user_heading');?> | <?php echo lang('create_user_subheading');?></h4>
            </div>
            <?php echo form_open("dashboard/auth/create_user");?>
            <div class="card-body">
              <div class="form-group">
                <label><?php echo lang('create_user_fname_label', 'first_name');?></label>
                <?php echo form_input($first_name);?>
              </div>
              <div class="form-group">
                <label><?php echo lang('create_user_lname_label', 'last_name');?></label>
                <?php echo form_input($last_name);?>
              </div>
              <?php
              if($identity_column!=='email') {
                  echo '<p>';
                  echo lang('create_user_identity_label', 'identity');
                  echo '<br />';
                  echo form_error('identity');
                  echo form_input($identity);
                  echo '</p>';
              }
              ?>
              <div class="form-group">
                <label><?php echo lang('create_user_company_label', 'company');?></label>
                <?php echo form_input($company);?>
              </div>
              <div class="form-group">
                <label><?php echo lang('create_user_email_label', 'email');?></label>
                <?php echo form_input($email);?>
              </div>
              <div class="form-group">
                <label><?php echo lang('create_user_phone_label', 'phone');?></label>
                <?php echo form_input($phone);?>
              </div>
              <div class="form-group">
                <label><?php echo lang('create_user_password_label', 'password');?></label>
                <?php echo form_input($password);?>
              </div>
              <div class="form-group">
                <label><?php echo lang('create_user_password_confirm_label', 'password_confirm');?></label>
                <?php echo form_input($password_confirm);?>
              </div>
              <?php echo form_submit('submit', lang('create_user_submit_btn'),"class='btn btn-primary'");?>
            </div>
            <?php echo form_close();?>
          </div>



        </div>

      </div>
    </div>
  </section>
</div>








<?php $this->load->view('_layout/footer'); ?>
