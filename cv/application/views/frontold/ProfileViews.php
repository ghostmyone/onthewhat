<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view('front/_layout/Head'); ?>
  <style media="screen">
  .input-group-sm>.input-group-append>select.btn:not([size]):not([multiple]), .input-group-sm>.input-group-append>select.input-group-text:not([size]):not([multiple]), .input-group-sm>.input-group-prepend>select.btn:not([size]):not([multiple]), .input-group-sm>.input-group-prepend>select.input-group-text:not([size]):not([multiple]), .input-group-sm>select.form-control:not([size]):not([multiple]), select.form-control-sm:not([size]):not([multiple]){
    height: calc(2.25rem + 2px);
  }
  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }
  a:not([href]):not([tabindex]){
    color: white;
  }
    a.readmore{
      cursor: pointer;
      color: white;
      border-color:white;
    }
    .readmorea{
      cursor: pointer;
    }
    .readmore:hover {
      color: red;

    }
  </style>
</head>

<body class="bg-white text-white">

  <!-- ======= Navbar ======= -->
  <?php $this->load->view('front/_layout/Navbar'); ?>

  <main id="main">

    <section class="section pt-4">

        <div class="container">
          <div class="p-1">
            <div class="mvstyle row rounded ">
              <h3 class="text-white m-0">Profile Setting</h3>
            </div>
            <form class="" action="<?php echo base_url('profile/update'); ?>" method="post">
            <div class="col-md-12 col-12 mt-4 mvstyle p-1 rounded">
              <p class="text-white">First Name</p>
              <input value="<?php echo $this->ion_auth->user()->row()->first_name; ?>"  style="background:#212529!important;" type="text" placeholder="First Name" name="fname" class="form-control bg-dark text-white" required>
              <input value="<?php echo $this->ion_auth->user()->row()->id; ?>"  style="background:#212529!important;" type="hidden" placeholder="First Name" name="id" class="form-control bg-dark text-white" required>
            </div>
            <div class="col-md-12 col-12 mt-4 mvstyle p-1 rounded">
              <p class="text-white">Last Name</p>
              <input value="<?php echo $this->ion_auth->user()->row()->last_name; ?>"  style="background:#212529!important;" type="text" placeholder="Last Name" name="lname" class="form-control bg-dark text-white" required>
            </div>
            <div class="col-md-12 col-12 mt-4 mvstyle p-1 rounded">
              <p class="text-white">Company Name</p>
              <input value="<?php echo $this->ion_auth->user()->row()->company; ?>"  style="background:#212529!important;" type="text" placeholder="Company Name" name="companyname" class="form-control bg-dark text-white" required>
            </div>
            <div class="col-md-12 col-12 mt-4 mvstyle p-1 rounded">
              <p class="text-white">Phone</p>
              <input value="<?php echo $this->ion_auth->user()->row()->phone; ?>"  style="background:#212529!important;" type="number" placeholder="Phone" name="phone" class="form-control bg-dark text-white" required>
            </div>
            <div class="col-md-12 col-12 mt-4 mvstyle p-1 rounded">
              <p class="text-white">Password: (if changing password)</p>
              <input value="" minlength="8" style="background:#212529!important;" type="text" placeholder="Password" name="password1" class="form-control bg-dark text-white">
            </div>
            <div class="col-md-12 col-12 mt-4 mvstyle p-1 rounded">
              <p class="text-white">Confirm Password: (if changing password)</p>
              <input value="" minlength="8" style="background:#212529!important;" type="text" placeholder="Repeat password" name="password2" class="form-control bg-dark text-white">
            </div>
            <div class="col-md-12 col-12 mt-4 mvstyle p-1 rounded">
              <p style="width:100%;margin:0px;" class="text-center p-0">
                <button type="submit" class="readmore text-center bg-dark text-white col-md-12 m-0" name="button">UPDATE</button>
              </p>
            </div>
          </form>
          </div>


        </div>
    </section>
  </main>


  <!-- ======= Footer ======= -->

  <!-- Vendor JS Files -->
  <?php $this->load->view('front/_layout/Footer'); ?>
  <script type="text/javascript">
  $( document ).ready(function() {
    console.log( "ready!" );

    function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}
  });
  </script>

</body>

</html>
