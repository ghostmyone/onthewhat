<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="<?php echo base_url(); ?>"><?php echo $this->db->get('data_setting')->row()->SiteName; ?></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="<?php echo base_url(); ?>">MV</a>
    </div>
    <ul class="sidebar-menu">
      <li class="<?php echo $this->uri->segment(2) == 'home' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo base_url(); ?>dashboard/home">
          <i class="far fa-square"></i>
          <span>Home</span>
        </a>
      </li>
      <li class="<?php echo $this->uri->segment(2) == 'setting' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo base_url(); ?>dashboard/setting">
          <i class="far fa-square"></i>
          <span>Website Setting</span>
        </a>
      </li>
      <li class="<?php echo $this->uri->segment(2) == 'price' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo base_url(); ?>dashboard/price">
          <i class="far fa-square"></i>
          <span>Price Setting</span>
        </a>
      </li>
      <li class="<?php echo $this->uri->segment(2) == 'auth' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo base_url(); ?>dashboard/auth">
          <i class="far fa-square"></i>
          <span>User Management</span>
        </a>
      </li>
      <li class="menu-header">Home Setting</li>
      <li class="<?php echo $this->uri->segment(2) == 'slide' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo base_url(); ?>dashboard/slide">
          <i class="far fa-square"></i>
          <span>Slide</span>
        </a>
      </li>
      <li class="<?php echo $this->uri->segment(2) == 'product' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo base_url(); ?>dashboard/product">
          <i class="far fa-square"></i>
          <span>Product</span>
        </a>
      </li>
      <li class="<?php echo $this->uri->segment(2) == 'item' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo base_url(); ?>dashboard/item">
          <i class="far fa-square"></i>
          <span>Item</span>
        </a>
      </li>
      <li class="menu-header">Transaksi Setting</li>
      <li class="<?php echo $this->uri->segment(2) == 'transaksi' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo base_url(); ?>dashboard/transaksi">
          <i class="far fa-square"></i>
          <span>Transaksi</span>
        </a>
      </li>
      <li class="<?php echo $this->uri->segment(2) == 'deposit' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo base_url(); ?>dashboard/deposit">
          <i class="far fa-square"></i>
          <span>Deposit</span>
        </a>
      </li>
      <li class="<?php echo $this->uri->segment(2) == 'payment' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo base_url(); ?>dashboard/payment">
          <i class="far fa-square"></i>
          <span>Payment Gateway</span>
        </a>
      </li>
      <!-- <li class="<?php echo $this->uri->segment(2) == 'deposit/list' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo base_url(); ?>dashboard/deposit/list">
          <i class="far fa-square"></i>
          <span>Acc Deposit</span>
        </a>
      </li> -->
    </ul>

    <!-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
      <a href="<?php echo base_url('example/index_0'); ?>" target="_blank" class="btn btn-primary btn-lg btn-block btn-icon-split">
        <i class="fas fa-rocket"></i> Documentation
      </a>
    </div> -->
  </aside>
</div>