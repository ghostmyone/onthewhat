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
            <!-- <div class="card-header">
              <h4><?php echo $title; ?></h4>
            </div> -->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>InvoiceId</th>
                      <th>Payment Method</th>
                      <th>Status</th>
                      <th>Tanggal</th>
                    </tr>
                  </thead>
                  <tbody>
										<?php $i =0; ?>
										<?php foreach ($data->data as $d):?>
											<?php $i++ ?>
                    <tr>
                      <td><?php echo $d->customer_name; ?></td>
                      <td><p class="bg-info text-center text-white rounded"><?php echo $d->merchant_ref; ?></p> </td>
                      <td><?php echo $d->payment_name.' | '."Rp " . number_format($d->amount_received, 2, ',', '.'); ?></td>
                      <td><?php if ($d->status == 'PAID') {
                        echo '<div class="bg-success text-white text-center rounded" style="widht:100%;">
                                              <p>'.$d->status.'</p>
                                            </div>';
                      }elseif ($d->status == 'EXPIRED') {
                        echo '<div class="bg-primary text-white text-center rounded" style="widht:100%;">
                                              <p>'.$d->status.' | '.$d->note.'</p>
                                            </div>';
                      } ?>
                        </td>
                      <td><?php echo $d->created_at; ?></td>
                    </tr>
										<?php endforeach;?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
			  </div>
  </section>
</div>

<?php $this->load->view('_layout/footer'); ?>
