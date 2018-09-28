<style type="text/css" media="screen">
	.td_no{
		width: 4%;
	}
	.td_department_id{
		width: 10%;
	}
	.td_action{
		width: 12%;
	}	
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo $breadcrumb ?>
			<small>Data</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $breadcrumb ?></li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- pesan flash message start -->
		<?php $flash_pesan = $this->session->flashdata('pesan')?>
		<?php if (! empty($flash_pesan)) : ?>
			<div class="alert alert-success alert-dismissible" id="alert">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-check"></i> <?php echo $flash_pesan; ?></h4>
			</div>
		<?php endif ?>
		<!-- pesan flash message end -->

		<!-- pesan start -->
		<?php if (! empty($pesan)) : ?>
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-check"></i> <?php echo $pesan; ?></h4>				
			</div>
		<?php endif ?>
		<!-- pesan end -->
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">List Of <?php echo $breadcrumb ?></h3>

						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

								<div class="input-group-btn">
									<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive">
						<!-- tabel data start -->
						<?php if (! empty($tabel_data)) : ?>
							<?php echo $tabel_data; ?>
						<?php endif ?>
						<!-- tabel data end -->
					</div>
					<!-- /.box-body -->
					<div class="box-footer clearfix">
						<?php echo anchor('department/tambah/','Add Data', array('class' => 'btn btn-primary btn-sm btn-flat pull-left')) ?>
						<!-- pagination start -->
						<?php if (! empty($pagination)) : ?>							
							<?php echo $pagination; ?>
						<?php endif ?>
						<!-- paginatin end -->	
					</div>
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>







