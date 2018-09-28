<?php
$form = array(
	'no_employee' => array(
		'name'=>'no_employee',
		//'size'=>'30',
		'class'=>'form-control input-sm',
		'value'=>set_value('no_employee', isset($form_value['no_employee']) ? $form_value['no_employee'] : '')
		),
	'name' => array(
		'name'=>'name',
		//'size'=>'30',
		'class'=>'form-control input-sm',
		'value'=>set_value('name', isset($form_value['name']) ? $form_value['name'] : '')
		),
	'place_of_birth' => array(
		'name'=>'place_of_birth',
		//'size'=>'30',
		'class'=>'form-control input-sm',
		'value'=>set_value('place_of_birth', isset($form_value['place_of_birth']) ? $form_value['place_of_birth'] : '')
		),
	'date_of_birth' => array(
		'id' => 'datepicker_datebirth',
		'name'=>'date_of_birth',
		//'size'=>'30',
		'class'=>'form-control input-sm pull-right',
		'value'=>set_value('date_of_birth', isset($form_value['date_of_birth']) ? $form_value['date_of_birth'] : '')
		),
	'photo' => array(
		//'id' => 'imgInp',
		'name'=>'userfile',
		'onchange' => "readURL(this);",
	 	//'size'=>'30',
	 	//'class'=>'form-control input-sm',
		'value'=>set_value('photo', isset($form_value['photo']) ? $form_value['photo'] : '')
		),
	'school_majors' => array(
		'name'=>'school_majors',
		//'size'=>'30',
		'class'=>'form-control input-sm',
		'value'=>set_value('school_majors', isset($form_value['school_majors']) ? $form_value['school_majors'] : '')
		),
	'school_name' => array(
		'name'=>'school_name',
		//'size'=>'30',
		'class'=>'form-control input-sm',
		'value'=>set_value('school_name', isset($form_value['school_name']) ? $form_value['school_name'] : '')
		),
	'year_graduation'    => array(
		'name'=>'year_graduation',
		//'size'=>'30',
		'class'=>'form-control input-sm',
		'value'=>set_value('year_graduation', isset($form_value['year_graduation']) ? $form_value['year_graduation'] : '')
		),
	'address'    => array(
		'name'=>'address',
		//'size'=>'30',
		'rows' => '2',
		'class'=>'form-control input-sm',
		'value'=>set_value('address', isset($form_value['address']) ? $form_value['address'] : '')
		),
	'child'    => array(
		'name'=>'child',
		//'size'=>'30',
		'class'=>'form-control input-sm',
		'value'=>set_value('child', isset($form_value['child']) ? $form_value['child'] : '')
		),
	'no_hp'    => array(
		'name'=>'no_hp',
		//'size'=>'30',
		'class'=>'form-control input-sm',
		'value'=>set_value('no_hp', isset($form_value['no_hp']) ? $form_value['no_hp'] : '')
		),
	'no_telp'    => array(
		'name'=>'no_telp',
		//'size'=>'30',
		'class'=>'form-control input-sm',
		'value'=>set_value('no_telp', isset($form_value['no_telp']) ? $form_value['no_telp'] : '')
		),
	'existing_job'    => array(
		'name'=>'existing_job',
		//'size'=>'30',
		'class'=>'form-control input-sm',
		'value'=>set_value('existing_job', isset($form_value['existing_job']) ? $form_value['existing_job'] : '')
		),
	'join_date' => array(
		'id' => 'datepicker_join_date',
		'name'=>'join_date',
		//'size'=>'30',
		'class'=>'form-control input-sm pull-right',
		'value'=>set_value('join_date', isset($form_value['join_date']) ? $form_value['join_date'] : '')
		),
	'resign_date' => array(
		'id' => 'datepicker_resign_date',
		'name'=>'resign_date',
		//'size'=>'30',
		'class'=>'form-control input-sm pull-right',
		'value'=>set_value('resign_date', isset($form_value['resign_date']) ? $form_value['resign_date'] : '')
		),
	'prob_start' => array(
		'id' => 'datepicker_prob_date',
		'name'=>'prob_start',
		//'size'=>'30',
		'class'=>'form-control input-sm pull-right',
		'value'=>set_value('prob_date', isset($form_value['prob_date']) ? $form_value['prob_date'] : '')
		),
	'end_date' => array(
		'id' => 'datepicker_end_date',
		'name'=>'end_date',
		//'size'=>'30',
		'class'=>'form-control input-sm pull-right',
		'value'=>set_value('end_date', isset($form_value['end_date']) ? $form_value['end_date'] : '')
		),
	'contract1_start' => array(
		'id' => 'datepicker_contract1_date',
		'name'=>'contract1_start',
		//'size'=>'30',
		'class'=>'form-control input-sm pull-right',
		'value'=>set_value('contract1_start', isset($form_value['contract1_start']) ? $form_value['contract1_start'] : '')
		),
	'contract2_start' => array(
		'id' => 'datepicker_contract2_date',
		'name'=>'contract2_start',
		//'size'=>'30',
		'class'=>'form-control input-sm pull-right',
		'value'=>set_value('contract2_start', isset($form_value['contract2_start']) ? $form_value['contract2_start'] : '')
		),
	'contract3_start' => array(
		'id' => 'datepicker_contract3_date',
		'name'=>'contract3_start',
		//'size'=>'30',
		'class'=>'form-control input-sm pull-right',
		'value'=>set_value('contract3_start', isset($form_value['contract3_start']) ? $form_value['contract3_start'] : '')
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
			<?php if (! empty($pesan)) : ?>
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-check"></i> <?php echo $pesan; ?></h4>
				</div>
			<?php endif ?>
			<!-- pesan end -->
			<!-- <div class="row"> -->
			<!-- left column -->
			<!-- <div class="col-md-6"> -->
			<!-- general form elements -->
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo $breadcrumb ?></h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<?php $attributes = array('class' => '', 'id' => 'form_employee'); ?>
				<?php echo form_open_multipart($form_action, $attributes); ?>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-lg-3">
									<div class="form-group">
										<?php echo form_label('Employee No.', 'no_employee'); ?>
										<?php echo form_input($form['no_employee']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('no_employee');?>
											</span>
										</div>
									</div>
								</div>
								<div class="col-lg-9">
									<div class="form-group">
										<?php echo form_label('Name', 'name'); ?>
										<?php echo form_input($form['name']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('name');?>
											</span>
										</div>
									</div>
								</div>							
							</div>						
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<?php echo form_label('Place Of Birth', 'place_of_birth'); ?>
										<?php echo form_input($form['place_of_birth']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('place_of_birth');?>
											</span>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Date</label>
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<?php echo form_input($form['date_of_birth']); ?>
										</div>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('date_of_birth');?>
											</span>
										</div>
										<!-- /.input group -->
									</div>
								</div>
							</div>
							<div class="form-group">
								<?php echo form_label('Gender', 'gender'); ?>
								<?php echo form_dropdown('gender', $opt_gender, set_value('gender', isset($form_value['gender']) ? $form_value['gender'] : ''), 
								['class'=>'form-control input-sm select2']); ?>
								<div class="form-group has-error">
									<span class="help-block">
										<?php echo form_error('gender');?>
									</span>
								</div>
							</div>
							<div class="form-group">
								<?php echo form_label('Address', 'address'); ?>
								<?php echo form_textarea($form['address']); ?>
								<div class="form-group has-error">
									<span class="help-block">
										<?php echo form_error('address');?>
									</span>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<?php echo form_label('Religion', 'id_religion'); ?>
										<?php echo form_dropdown('id_religion', $opt_religion, set_value('id_religion', isset($form_value['id_religion']) ? $form_value['id_religion'] : ''), 
										['class'=>'form-control input-sm select2']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('id_religion');?>
											</span>
										</div>
									</div>
								</div>
								<div class="col-lg-5">
									<div class="form-group">
										<?php echo form_label('Marital Status', 'id_marital_status'); ?>
										<?php echo form_dropdown('id_marital_status', $opt_marital, set_value('id_marital_status', isset($form_value['id_marital_status']) ? $form_value['id_marital_status'] : ''), 
										['class'=>'form-control input-sm select2']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('id_marital_status');?>
											</span>
										</div>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<?php echo form_label('Child', 'child'); ?>
										<?php echo form_input($form['child']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('child');?>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<?php echo form_label('No. HP', 'no_hp'); ?>
										<?php echo form_input($form['no_hp']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('no_hp');?>
											</span>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<?php echo form_label('No. Telp', 'no_telp'); ?>
										<?php echo form_input($form['no_telp']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('no_telp');?>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="userfile">Photo</label>
										<?php echo form_upload($form['photo']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('photo');?>
											</span>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<!-- <label for="img_preview">Preview Image</label> -->
										<!-- <img name="img_preview" id="img_preview" src="#" alt="" /> -->
										<?php  
										$value = isset($form_value['photo']) ? $form_value['photo'] : '';
										?>
										
										<img name="img_preview" id="img_preview" src="<?php echo base_url('./assets/uploads/employee/thumbs/'). $value ;?>" alt="" />
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<?php echo form_label('Last Education', 'id_last_education'); ?>
										<?php echo form_dropdown('id_last_education', $opt_education, set_value('id_last_education', isset($form_value['id_last_education']) ? $form_value['id_last_education'] : ''), 
										['class'=>'form-control input-sm select2']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('id_last_education');?>
											</span>
										</div>
									</div>
								</div>
								<div class="col-lg-8">
									<div class="form-group">
										<?php echo form_label('School Majors', 'school_majors'); ?>
										<?php echo form_input($form['school_majors']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('school_majors');?>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-8">
									<div class="form-group">
										<?php echo form_label('School Name', 'school_name'); ?>
										<?php echo form_input($form['school_name']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('school_name');?>
											</span>
										</div>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<?php echo form_label('Year Graduation', 'year_graduation'); ?>
										<?php echo form_input($form['year_graduation']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('year_graduation');?>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<?php echo form_label('Existing Job', 'existing_job'); ?>
										<?php echo form_input($form['existing_job']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('existing_job');?>
											</span>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Join Date</label>
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<?php echo form_input($form['join_date']); ?>
										</div>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('join_date');?>
											</span>
										</div>
										<!-- /.input group -->
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<?php echo form_label('Department', 'id_department'); ?>
										<?php echo form_dropdown('id_department', $opt_department, set_value('id_department', isset($form_value['id_department']) ? $form_value['id_department'] : ''), 
										['class'=>'form-control input-sm select2']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('id_department');?>
											</span>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<?php echo form_label('Employment', 'id_employment'); ?>
										<?php echo form_dropdown('id_employment', $opt_employment, set_value('id_employment', isset($form_value['id_employment']) ? $form_value['id_employment'] : ''), 
										['class'=>'form-control input-sm select2']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('id_employment');?>
											</span>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<?php echo form_label('Employee Status', 'id_employee_status'); ?>
										<?php echo form_dropdown('id_employee_status', $opt_employee_status, set_value('id_employee_status', isset($form_value['id_employee_status']) ? $form_value['id_employee_status'] : ''), 
										['id'=>'select_employee_status', 'class'=>'form-control input-sm select2']); ?>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('id_employee_status');?>
											</span>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group" id="show_resigndate">
										<label>Resign Date</label>
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<?php echo form_input($form['resign_date']); ?>
										</div>
										<div class="form-group has-error">
											<span class="help-block">
												<?php echo form_error('resign_date');?>
											</span>
										</div>
										<!-- /.input group -->
									</div>
								</div>
							</div>
							<div id="show_contract">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label>Probation Start Date</label>
											<div class="input-group date">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<?php echo form_input($form['prob_start']); ?>
											</div>
											<div class="form-group has-error">
												<span class="help-block">
													<?php echo form_error('prob_start');?>
												</span>
											</div>
											<!-- /.input group -->
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label>End Date</label>
											<div class="input-group date">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<?php echo form_input($form['end_date']); ?>
											</div>
											<div class="form-group has-error">
												<span class="help-block">
													<?php echo form_error('end_date');?>
												</span>
											</div>
											<!-- /.input group -->
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label>Contract 1 Start Date</label>
											<div class="input-group date">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<?php echo form_input($form['contract1_start']); ?>
											</div>
											<div class="form-group has-error">
												<span class="help-block">
													<?php echo form_error('contract1_start');?>
												</span>
											</div>
											<!-- /.input group -->
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label>Contract 2 Start Date</label>
											<div class="input-group date">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<?php echo form_input($form['contract2_start']); ?>
											</div>
											<div class="form-group has-error">
												<span class="help-block">
													<?php echo form_error('contract2_start');?>
												</span>
											</div>
											<!-- /.input group -->
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label>Contract 3 Start Date</label>
											<div class="input-group date">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<?php echo form_input($form['contract3_start']); ?>
											</div>
											<div class="form-group has-error">
												<span class="help-block">
													<?php echo form_error('contract3_start');?>
												</span>
											</div>
											<!-- /.input group -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /.box-body -->

				<div class="box-footer">
					<?php echo form_submit($form['submit']); ?>
					<?php echo anchor('employee','Cancel', array('class' => 'btn btn-default btn-sm btn-flat')) ?>
				</div>
				<?php echo form_close(); ?>
				<!-- /.form end -->
			</div>
			<!-- /.box -->
				<!-- </div>
			</div> -->
			<!--/.col (left) -->
		</section>
		<!-- /.content -->


		<script type="text/javascript">

			function readURL(input) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						$('#img_preview')
						.attr('src', e.target.result)
						// .width(150)
                    	.height(150);
					}

					reader.readAsDataURL(input.files[0]);
				}
			}
		</script>