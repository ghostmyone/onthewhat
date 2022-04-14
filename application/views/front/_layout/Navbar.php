<nav class="navbar navbar-dark maincolor fixed-top " style="border-bottom: 1px solid red;padding-top:0px;padding-bottom:0px;">
  <a class="navbar-brand p-0"  href="<?php echo base_url(); ?>"><img style="height:50px;"  src="<?php echo base_url('assets/upload/home/logo.png'); ?>" alt=""></a>
  <span class="navbar-text">

    </span>
  <button style="color:white;border:none;font-size:25px;" class="navbar-toggler collapsed p-0 mr-2" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-collapse collapse seccolor" id="navbarsExample01" style="">
    <ul class="navbar-nav mr-auto">
      <li class=" nav-item p-3 active"><a href="<?php echo base_url(); ?>" class="text-white">Home</a></li>
      <!-- <li><a href="http://wa.me/+6281336469236" class="text-dark">Contact us</a></li> -->
      <?php if (!$this->ion_auth->logged_in()): ?>

        <li class="nav-item p-3"><a href="<?php echo base_url(); ?>login" class="text-white">Login</a></li>
        <li class="nav-item p-3"><a href="<?php echo base_url(); ?>register" class="text-white">Register</a></li>
      <?php endif; ?>
      <?php if ($this->ion_auth->logged_in()): ?>
        <li class="nav-item p-3 text-white">
          <?php echo $this->ion_auth->user()->row()->email ?> | <?php echo "Rp " . number_format($this->ion_auth->user()->row()->Balance, 2, ',', '.'); ?> | <?php $group = 'resseler'; echo($this->ion_auth->get_users_groups($this->ion_auth->user()->row()->id)->row()->name); ?>
        </li>
        <li class="nav-item p-3"><a href="<?php echo base_url('profile'); ?>" class="text-white">Profile</a></li>
        <li class="nav-item p-3"><a href="<?php echo base_url('deposit'); ?>" class="text-white">Deposit</a></li>
        <li class="nav-item p-3"><a href="<?php echo base_url('transaksi'); ?>" class="text-white">Riwayat Transaksi</a></li>
        <li class="nav-item p-3"><a href="<?php echo base_url('dashboard/auth/logout'); ?>" class="text-white">Logout</a></li>
      <?php endif; ?>
      <?php if ($this->ion_auth->is_admin()): ?>
        <li class="nav-item p-3"><a href="<?php echo base_url('dashboard/home'); ?>" class="text-white">Admin</a></li>
      <?php endif; ?>
      <li class="nav-item p-3"><a href="<?php echo base_url('listharga'); ?>" class="text-white">Daftar Harga</a></li>
      <li class="nav-item p-3"><a href="<?php echo base_url('pesanan'); ?>" class="text-white">Cek Order</a></li>
    </ul>
    <!-- <form class="form-inline my-2 my-md-0">
      <input class="form-control" type="text" placeholder="Search" aria-label="Search">
    </form> -->
  </div>
</nav>
<div class="" style="height:70px;width:100%;">

</div>
