<div class="content-wrapper" style="min-height: 916px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Form<small><?php echo $breadcrumb ?></small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?php echo $breadcrumb ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="form-group has-error">
    <?php $attributes = array('id' => 'form_lapor'); ?>
    <?php echo form_open_multipart($form_action, $attributes); ?>
      <label for="exampleInputFile">File input</label>
      <input type="file" name="file" id="exampleInputFile" required>
<!--       <span class="help-block">
                        <?php echo form_error('file');?>
                      </span> -->

      <!-- <p class="help-block">Example block-level help text here.</p> -->
      <input type="submit" value="Upload file"/>
      <?php echo form_close(); ?>
    </div>

  </section>

  <!-- /.content -->
</div>
