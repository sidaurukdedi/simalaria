<?php
$form = array(
	'id_religion' => array(
		'name'=>'id_religion',
		//'size'=>'30',
		'class'=>'form-control input-sm',
		'value'=>set_value('id_religion', isset($form_value['id_religion']) ? $form_value['id_religion'] : '')
		),
	'religion'    => array(
		'name'=>'religion',
		//'size'=>'30',
		'class'=>'form-control input-sm',
		'value'=>set_value('religion', isset($form_value['religion']) ? $form_value['religion'] : '')
		),
	'submit'   => array(
		'name'=>'submit',
		'class' => 'btn btn-success btn-sm btn-flat',
		'id'=>'submit',
		'value'=>'Save'
		)
	);
	?>

	<div class="content-wrapper" style="min-height: 946px;">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?php echo $breadcrumb ?>
				<!-- <small>Preview</small> -->
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active"><?php echo $breadcrumb ?></li>
			</ol>
		</section>
		

		<!-- Main content -->
		<section class="content">
			<!-- pesan start -->
			<?php $flash_pesan = $this->session->flashdata('pesan')?>
			<?php if (! empty($flash_pesan)) : ?>
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-check"></i> <?php echo $flash_pesan; ?></h4>
				</div>
			<?php endif ?>
			<!-- pesan end -->
			<div class="row">
				<!-- left column -->
				<div class="col-md-6">
					<!-- general form elements -->
					<div class="box box-success">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo $breadcrumb ?></h3>
						</div>
						<!-- /.box-header -->
						<!-- form start -->
						<?php $attributes = array('class' => '', 'id' => 'form_religion'); ?>
						<?php echo form_open($form_action, $attributes); ?>
						<div class="box-body">
							<div class="form-group">
								<?php echo form_label('Religion ID', 'id_religion'); ?>
								<?php echo form_input($form['id_religion']); ?>
								<div class="form-group has-error">
									<span class="help-block">
										<?php echo form_error('id_religion');?>
									</span>
								</div>
							</div>

							<div class="form-group">
								<?php echo form_label('Religion', 'religion'); ?>
								<?php echo form_input($form['religion']); ?>
								<div class="form-group has-error">
									<span class="help-block">
										<?php echo form_error('religion');?>
									</span>
								</div>
							</div>
						</div>
						<!-- /.box-body -->

						<div class="box-footer">
							<?php echo form_submit($form['submit']); ?>
							<?php echo anchor('religion','Cancel', array('class' => 'btn btn-default btn-sm btn-flat')) ?>
						</div>
						<?php echo form_close(); ?>
						<!-- /.form end -->
					</div>
					<!-- /.box -->
				</div>
			</div>
			<!--/.col (left) -->
		</section>
		<!-- /.content -->