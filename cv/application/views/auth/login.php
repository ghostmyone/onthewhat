<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('_layout/HeaderNew');
?>
<body class="sec-mv">
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <a  href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/img/mv.png" alt="logo" width="100" class="shadow-dark rounded-circle"></a>

            </div>

            <div class="card" style="background-color: #0b0e2e;">
              <?php
              if($this->session->flashdata('message') || $message){
              ?>
              <div class="alert alert-warning m-1 alert-has-icon">
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
              }
              ?>
              <div class="card-header">
                <h4 class="text-white"><?php echo lang('login_heading');?></h4>
              </div>

              <div class="card-body">
                <?php echo form_open("dashboard/auth/login");?>
                  <div class="form-group">
                    <label for="identity"><?php echo lang('login_identity_label', 'identity" class="text-white"');?></label>
                    <?php echo form_input($identity);?>

                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label"><?php echo lang('login_password_label', 'password" class="text-white"');?></label>
                      <div class="float-right">
                        <a href="<?php echo base_url(); ?>dashboard/auth/forgot_password" class="text-small text-white">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <?php echo form_input($password);?>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <?php echo form_checkbox('remember', '1', FALSE, 'id="remember" class="custom-control-input"');?>

                      <label class="custom-control-label" for="remember">Remember Me</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-info btn-lg btn-block" style"background-color:white;');?>

                  </div>
                <?php echo form_close();?>
                <!-- <div class="text-center mt-4 mb-3">
                  <div class="text-job text-muted">
                    Login With Social
                  </div>
                </div> -->
                <!-- <div class="row sm-gutters">
                  <div class="col-6">
                    <a class="btn btn-block btn-social btn-facebook">
                      <span class="fab fa-facebook"></span> Facebook
                    </a>
                  </div>
                  <div class="col-6">
                    <a class="btn btn-block btn-social btn-twitter">
                      <span class="fab fa-twitter"></span> Twitter
                    </a>
                  </div>
                </div> -->

              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              Don't have an account? <a href="<?php echo base_url(); ?>register" class="text-white">Create One</a>
            </div>
            <div class="simple-footer">
              Copyright &copy; <?php echo $this->db->get('data_setting')->row()->SiteName; ?> 2021
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php $this->load->view('_layout/js'); ?>
