<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_layout/HeaderNew'); ?>

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?php echo lang('edit_user_heading');?></h1>
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
              <h4><?php echo lang('edit_user_heading');?> | <?php echo lang('edit_user_subheading');?></h4>
            </div>
            <?php echo form_open(uri_string());?>
            <?php echo form_hidden('id', $user->id);?>
            <?php echo form_hidden($csrf); ?>
            <div class="card-body">
              <div class="form-group">
                <label><?php echo lang('edit_user_fname_label', 'first_name');?></label>
                <?php echo form_input($first_name);?>
              </div>
              <div class="form-group">
                <label><?php echo lang('edit_user_lname_label', 'last_name');?></label>
                <?php echo form_input($last_name);?>
              </div>
              <!-- <?php
              if($identity_column!=='email') {
                  echo '<p>';
                  echo lang('create_user_identity_label', 'identity');
                  echo '<br />';
                  echo form_error('identity');
                  echo form_input($identity);
                  echo '</p>';
              }
              ?> -->
              <div class="form-group">
                <label><?php echo lang('edit_user_company_label', 'company');?></label>
                <?php echo form_input($company);?>
              </div>
              <div class="form-group">
                <label>Balance:</label>
                <?php echo form_input($balance);?>
              </div>
              <div class="form-group">
                <label><?php echo lang('edit_user_phone_label', 'phone');?></label>
                <?php echo form_input($phone);?>
              </div>
              <div class="form-group">
                <label><?php echo lang('edit_user_password_label', 'password');?></label>
                <?php echo form_input($password);?>
              </div>
              <div class="form-group">
                <label><?php echo lang('edit_user_password_confirm_label', 'password_confirm');?></label>
                <?php echo form_input($password_confirm);?>
              </div>
              <?php if ($this->ion_auth->is_admin()): ?>
                <div class="form-group">
                  <label><?php echo lang('edit_user_groups_heading');?></label>
                  <div class="selectgroup selectgroup-pills">
                  <?php foreach ($groups as $group):?>
                    <label class="selectgroup-item">
                      <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>" class="selectgroup-input" <?php echo (in_array($group, $currentGroups)) ? 'checked="checked"' : null; ?>>
                      <span class="selectgroup-button"><?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?></span>
                    </label>
                  <?php endforeach?>
                  </div>
                </div>
              <?php endif ?>
              <?php echo form_submit('submit', lang('edit_user_submit_btn'),"class='btn btn-primary'");?>
            </div>
            <?php echo form_close();?>
          </div>



        </div>

      </div>
    </div>
  </section>
</div>








<?php $this->load->view('_layout/footer'); ?>
