<div class="collapse navbar-collapse custom-navmenu text-dark" id="main-navbar" style="background:#22002a;">
  <div class="container py-2 py-md-5">
    <div class="row align-items-start">
      <div class="col-md-2">
        <ul class="custom-menu">
          <li class="active"><a href="<?php echo base_url(); ?>" class="text-white">Home</a></li>
          <!-- <li><a href="http://wa.me/+6281336469236" class="text-dark">Contact us</a></li> -->
          <?php if (!$this->ion_auth->logged_in()): ?>
            <li><a href="<?php echo base_url(); ?>login" class="text-white">Login</a></li>
            <li><a href="<?php echo base_url(); ?>register" class="text-white">Register</a></li>
          <?php endif; ?>
          <?php if ($this->ion_auth->logged_in()): ?>
            <li><a href="<?php echo base_url('profile'); ?>" class="text-white">Profile</a></li>
            <li><a href="<?php echo base_url('deposit'); ?>" class="text-white">Deposit</a></li>
            <li><a href="<?php echo base_url('transaksi'); ?>" class="text-white">Riwayat Transaksi</a></li>
            <li><a href="<?php echo base_url('dashboard/auth/logout'); ?>" class="text-white">Logout</a></li>
          <?php endif; ?>
          <?php if ($this->ion_auth->is_admin()): ?>
            <li><a href="<?php echo base_url('dashboard/home'); ?>" class="text-white">Admin</a></li>
          <?php endif; ?>
          <li><a href="<?php echo base_url('listharga'); ?>" class="text-white">Daftar Harga</a></li>
          <li><a href="<?php echo base_url('pesanan'); ?>" class="text-white">Cek Order</a></li>


          <!-- <li><a href="works.html" class="text-dark">Works</a></li>
          <li><a href="contact.html" class="text-dark">Contact</a></li> -->
        </ul>
      </div>
      <div class="col-md-6 d-none d-md-block  mr-auto text-dark">
        <div class="tweet d-flex">
          <!-- <span class="bi bi-twitter text-white mt-2 mr-3"></span> -->
          <!-- <div>
            <p class="text-dark"><em>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam necessitatibus incidunt ut officiis explicabo inventore. <br> <a class="text-dark" href="#">t.co/v82jsk</a></em></p>
          </div> -->
        </div>
      </div>
      <div class="col-md-4 d-none d-md-block">
        <h3 class="text-white">Contact us</h3>
        <p class="text-white">Indonesia, Jawa Timur, Sidoarjo, puri indah ED 20 | 081336469236 <br> <a class="text-white" href="#">mvteam.sda@gmail.com</a></p>
      </div>
    </div>
  </div>
</div>
<nav class="navbar navbar-light custom-navbar text-white pt-0">
  <div class="container">
    <a class="navbar-brand text-white" href="<?php echo base_url(); ?>">
      <!-- ukuran 500 x 250 -->
      <img style="width: 200px;max-width: 100%;height:100%;" src="<?php echo base_url() ?>assets/upload/home/DEMO.png" alt="">
    </a>
    <a href="#" class="burger" data-bs-toggle="collapse" data-bs-target="#main-navbar">
      <span style="background:#22002a;" class="text-white"></span>
    </a>
  </div>

</nav>
<div class="container">

  <div class="row mb-2 align-items-center p-1">
    <div class="col-md-12 col-lg-12 text-white rounded" style="background: #22002a;">
      <?php if ($this->ion_auth->logged_in()): ?>
        <p class="mb-0"><?php echo $this->ion_auth->user()->row()->email ?> <br> <?php echo "Rp " . number_format($this->ion_auth->user()->row()->Balance, 2, ',', '.'); ?> | <?php $group = 'resseler'; echo($this->ion_auth->get_users_groups($this->ion_auth->user()->row()->id)->row()->name); ?></p>
      <?php endif; ?>
    </div>
  </div>
  <div class="row align-items-center p-1">
    <div class="col-md-12 col-lg-12 text-dark rounded m-0 p-0">
      <?php
      if ($this->session->flashdata('message')) {
          ?>
      <div class="alert alert-danger alert-has-icon  flash m-0">
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
    </div>
  </div>
</div>
