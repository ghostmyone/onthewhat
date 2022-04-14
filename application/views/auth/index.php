<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_layout/HeaderNew'); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
			<h1><?php echo lang('index_heading');?></h1>


    </div>

    <div class="section-body">
		<?php
    if ($this->session->flashdata('message')) {
        ?>
    <div class="alert alert-primary alert-has-icon">
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
            <div class="card-header">
              <h4><?php echo lang('index_heading');?> Data | <?php echo lang('sub_user_heading');?></h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center">
                        #
                      </th>
                      <th><?php echo lang('index_fname_th');?></th>
                      <th><?php echo lang('index_lname_th');?></th>
                      <th><?php echo lang('index_email_th');?></th>
                      <th><?php echo lang('index_groups_th');?></th>
                      <th><?php echo lang('index_status_th');?></th>
                      <th><?php echo lang('index_action_th');?></th>
                    </tr>
                  </thead>
                  <tbody>
										<?php $i =0; ?>
										<?php foreach ($users as $user):?>
											<?php $i++ ?>
                    <tr>
                      <td>
												<?php echo $i; ?>
                      </td>
                      <td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8');?></td>
                      <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8');?></td>
                      <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8');?></td>
                      <td>
												<?php foreach ($user->groups as $group):?>
													<?php echo anchor("dashboard/auth/edit_group/".$group->id, htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8')) ;?><br />
								        <?php endforeach?>
											</td>
                      <td>

                        	<?php echo ($user->active) ? anchor("dashboard/auth/deactivate/".$user->id, lang('index_active_link')) : anchor("dashboard/auth/activate/". $user->id, lang('index_inactive_link'));?>

                      </td>
                      <td><?php echo anchor("dashboard/auth/edit_user/".$user->id, 'Edit', "class='btn btn-info'") ;?></td>
                    </tr>
										<?php endforeach;?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>




			<p><?php echo anchor('dashboard/auth/create_user', lang('index_create_user_link'))?> | <?php echo anchor('dashboard/auth/create_group', lang('index_create_group_link'))?> | <a href="<?php echo base_url('dashboard/auth/mv') ?>">FLASH DATA</a> </p>
    </div>
  </section>
</div>

<?php $this->load->view('_layout/footer'); ?>
