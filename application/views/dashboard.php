<div class="content-wrapper" style="min-height: 916px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Analisis<small>Summary</small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3><?php echo $sum_suspek + 0; ?></h3>
            <p>Total Suspek</p>
          </div>
          <div class="icon">
            <i class="fa fa-fw fa-users"></i>
          </div>
          <a href="#" class="small-box-footer">  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3><?php echo $sum_sd_diperiksa + 0; ?></h3>
            <p>Total SD. Diperiksa</p>
          </div>
          <div class="icon">
            <i class="fa fa-fw fa-medkit"></i>
          </div>
          <a href="#" class="small-box-footer">  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><?php echo $count_kasuspositif; ?></h3>
            <p>Total Kasus Positif</p>
          </div>
          <div class="icon">
            <i class="fa fa-fw fa-bed"></i>
          </div>
          <a href="#" class="small-box-footer">  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?php echo $count_indigenous; ?></h3>
            <p>Total Kasus Indigenous</p>
          </div>
          <div class="icon">
            <i class="fa fa-fw fa-bed"></i>
          </div>
          <a href="#" class="small-box-footer">  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-teal">
          <div class="inner">
            <h3><?php echo $count_kasusimpor; ?></h3>
            <p>Total Kasus Impor</p>
          </div>
          <div class="icon">
            <i class="fa fa-fw fa-bed"></i>
          </div>
          <a href="#" class="small-box-footer">  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-olive">
          <div class="inner">
            <h3><?php echo $api_dashboard; ?></h3>
            <p>Kasus Malaria per 1000 Penduduk</p>
          </div>
          <div class="icon">
            <i class="fa fa-fw fa-bed"></i>
          </div>
          <a href="#" class="small-box-footer">  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3><?php echo $count_jenis_tp; ?></h3>
            <p>Jumlah Jenis TP</p>
          </div>
          <div class="icon">
            <i class="fa fa-fw fa-bed"></i>
          </div>
          <a href="#" class="small-box-footer">  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3><?php echo $count_jenis_kendali; ?></h3>
            <p>Jumlah Jenis Kendali</p>
          </div>
          <div class="icon">
            <i class="fa fa-fw fa-bed"></i>
          </div>
          <a href="#" class="small-box-footer">  <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->  
  </section>




  <!-- /.content -->
</div>