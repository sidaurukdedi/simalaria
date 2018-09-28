
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Profil Pasien
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#"><?php echo $breadcrumb ?></a></li>
      <li class="active"><?php echo $sub_breadcrumb ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Informasi Personal</h3>
          </div>
          <div class="box-body box-profile">
            <!-- <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/uploads/employee/thumbs/'.$employee['photo']);?>" alt="User profile picture"> -->
            <!-- <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/dist/img/user4-128x128.jpg');?>" alt="User profile picture"> -->

            <h3 class="profile-username text-center"><?php echo $pasien['nm_pasien']?></h3>

            <!-- <p class="text-muted text-center"><?php echo $pasien['jns_kerja']?></p> -->

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>ID Pasien</b> <a class="pull-right"><?php echo $pasien['id_pasien']?></a>
              </li>
              <li class="list-group-item">
                <b>Pekerjaan</b> <p class="pull-right"><?php echo $pasien['jns_kerja']?></p>
              </li>
              <li class="list-group-item">
                <b>Jenis Kelamin</b> <p class="pull-right"><?php echo $pasien['nama_kelamin']?></p>
              </li>
              <li class="list-group-item">
                <b>Umur</b> <p class="pull-right"><?php echo $pasien['umur']?></p>
              </li>
              <li class="list-group-item">
                <b>Tanggal Riwayat</b> <p class="pull-right"><?php echo $pasien['tgl_riwayat']?></p>
              </li>
              <li class="list-group-item">
                <b>Tanggal Sakit</b> <p class="pull-right"><?php echo $pasien['tgl_sakit']?></p>
              </li>
              <li class="list-group-item">
                <b>Tanggal Kunjungan</b> <p class="pull-right"><?php echo $pasien['tgl_kunjung']?></p>
              </li>
              <li class="list-group-item">
                <b>Tanggal Obat</b> <p class="pull-right"><?php echo $pasien['tgl_obat']?></p>
              </li>
            </ul>

            <!-- <a href="" class="btn btn-primary btn-block"><b><?php echo $employee['employee_status']?></b></a> -->
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->


        <!-- sampah start-->
        <!-- About Me Box -->
        <!-- <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Personal Information</h3>
          </div> -->
          <!-- /.box-header -->
          <!-- <div class="box-body">
            <strong><i class="fa fa-birthday-cake margin-r-5"></i> Tgl. Riwayat</strong>
            <p class="text-muted">
              <?php echo $pasien['tgl_riwayat']?>
            </p>
            
            <hr> -->

              <!-- <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p>

              <hr> -->  
            <!-- </div> -->
            <!-- /.box-body -->
          <!-- </div> -->
          <!-- /.box -->
          <!-- sampah end -->



        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab1" data-toggle="tab">Alamat</a></li>
              <li><a href="#tab2" data-toggle="tab">Diagnosa</a></li>
              <li><a href="#tab3" data-toggle="tab">Hasil Pengobatan</a></li>
            </ul>
            <div class="tab-content">
              <!-- tab-pane tab1-->
              <div class="active tab-pane" id="tab1">
                <div class="box-body">
                  <dl class="dl-horizontal text-left">
                    <dt>Asal Kegiatan</dt>
                    <dd class="text-justify"><?php echo $pasien['nama_keg']?></dd>
                    <br>
                    <dt>Dusun</dt>
                    <dd><?php echo $pasien['dusun']?></dd>
                    <br>
                    <dt>Desa</dt>
                    <dd ><?php echo $pasien['desa'] ?></dd>
                    <br>
                    <dt>Lintang</dt>
                    <dd ><?php echo $pasien['lintang'] ?></dd>
                    <br>
                    <dt>Bujur</dt>
                    <dd ><?php echo $pasien['bujur'] ?></dd>
                  </dl>
                </div>
              </div>
              <!-- /.tab-pane tab1-->
              <!-- /.tab-pane -->

              <!-- tab-pane tab2-->
              <div class="tab-pane" id="tab2">
                <div class="box-body">
                  <dl class="dl-horizontal text-left">
                    <dt>Jenis Konfirmasi</dt>
                    <dd><?php echo $pasien['jns_konfirmasi']?></dd>
                    <br>
                    <dt>Jenis Parasit</dt>
                    <dd><?php echo $pasien['jenis_parasit']?></dd>
                    <br>
                    <dt>Jenis Obat</dt>
                    <dd><?php echo $pasien['jenis_obat']?></dd>
                    <br>
                    <dt>Klasifikasi</dt>
                    <dd ><?php echo $pasien['klas_kasus'] ?></dd>
                    <br>
                    <dt>Kondisi Pasien</dt>
                    <dd ><?php echo $pasien['kondisi_pasien'] ?></dd>
                    <br>
                    <dt>Jenis Perawatan</dt>
                    <dd ><?php echo $pasien['jenis_rawatan'] ?></dd>
                    <br>
                    <dt>Hasil Fu4</dt>
                    <dd ><?php echo $pasien['hasil_fu4'] ?></dd>
                    <br>
                    <dt>Hasil Fu14</dt>
                    <dd ><?php echo $pasien['hasil_fu14'] ?></dd>
                    <br>
                    <dt>Hasil Fu28</dt>
                    <dd ><?php echo $pasien['hasil_fu28'] ?></dd>
                    <br>
                    <dt>Hasil Fu3bl</dt>
                    <dd ><?php echo $pasien['hasil_fu3bl'] ?></dd>
                    
                  </dl>
                </div>
              </div>
              <!-- /.tab-pane tab2-->
              <!-- /.tab-pane -->

              <!-- tab-pane tab3-->
              <div class="tab-pane" id="tab3">
                <div class="box-body">
                  <dl class="dl-horizontal text-left">
                    <dt>Asal Rujuan</dt>
                    <dd><?php echo $pasien['asal_rujuk']?></dd>
                    <br>
                    <dt>Tujuan Rujukan</dt>
                    <dd><?php echo $pasien['tujuan_rujuk']?></dd>
                    <br>
                    <dt>Hasil Pengobatan</dt>
                    <dd><?php echo $pasien['hasil_pengobatan']?></dd>
                    <br>
                    <dt>Nama Puskesmas</dt>
                    <dd><?php echo $pasien['nama_pkm']?></dd>
                    <br>
                    <dt>Bulan</dt>
                    <dd><?php echo $pasien['bulan']?></dd>
                  </dl>
                </div>
              </div>
              <!-- /.tab-pane tab3-->
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->