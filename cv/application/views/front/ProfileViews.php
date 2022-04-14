<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php $this->load->view('front/_layout/Head'); ?>
  </head>
  <body class="maincolor">
    <?php $this->load->view('front/_layout/Navbar'); ?>
    <div class="maincolor m-0" >
      <div class="container">
        <div class="title text-left" style="margin-bottom:20px;">
          Profile Setting
        </div>
        <form class="" action="<?php echo base_url('profile/update'); ?>" method="post">
          <div class="mt-3">
            <p class="text-white">First Name</p>
            <input type="hidden" name="id" value="<?php echo $this->ion_auth->user()->row()->id; ?>" class="produkcolor inputid form-control text-white">
            <input type="text" placeholder="First Name" name="fname" value="<?php echo $this->ion_auth->user()->row()->first_name; ?>" class="produkcolor inputid form-control text-white">
          </div>
          <div class="mt-3">
            <p class="text-white">Last Name</p>
            <input type="text" placeholder="Last Name" name="lname" value="<?php echo $this->ion_auth->user()->row()->last_name; ?>" class="produkcolor inputid form-control text-white">
          </div>
          <div class="mt-3">
            <p class="text-white">Company Name</p>
            <input type="text" placeholder="Company Name" name="companyname" value="<?php echo $this->ion_auth->user()->row()->company; ?>" class="produkcolor inputid form-control text-white">
          </div>
          <div class="mt-3">
            <p class="text-white">Phone</p>
            <input type="text" placeholder="Phone" name="phone" value="<?php echo $this->ion_auth->user()->row()->phone; ?>" class="produkcolor inputid form-control text-white">
          </div>
          <div class="mt-3">
            <p class="text-white">Password: (if changing password)</p>
            <input type="text" minlength="8" placeholder="Password" name="password1" value="" class="produkcolor inputid form-control text-white">
          </div>
          <div class="mt-3">
            <p class="text-white">Confirm Password: (if changing password)</p>
            <input type="text" minlength="8" placeholder="Repeat password" name="password2" value="" class="produkcolor inputid form-control text-white">
          </div>
          <div class="mt-3">
            <button type="submit" name="button" class="btn btn-success">UPDATE</button>
          </div>
        </form>
      </div>
    </div>
    <?php $this->load->view('front/_layout/Footer'); ?>
    <script type="text/javascript">
    $( document ).ready(function() {
      console.log( "ready!" );


    });
    </script>
  </body>
</html>
