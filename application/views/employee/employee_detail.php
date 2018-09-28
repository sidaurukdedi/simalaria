
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Employee Profile
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Examples</a></li>
      <li class="active">User profile</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/uploads/employee/thumbs/'.$employee['photo']);?>" alt="User profile picture">
            <!-- <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/dist/img/user4-128x128.jpg');?>" alt="User profile picture"> -->

            <h3 class="profile-username text-center"><?php echo $employee['name']?></h3>

            <p class="text-muted text-center"><?php echo $employee['employment']?></p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Employee No.</b> <a class="pull-right"><?php echo $employee['no_employee']?></a>
              </li>
            </ul>

            <a href="" class="btn btn-primary btn-block"><b><?php echo $employee['employee_status']?></b></a>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Personal Information</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <strong><i class="fa fa-birthday-cake margin-r-5"></i> Place / Date Of Birth</strong>
            <p class="text-muted">
              <?php echo $employee['place_of_birth']?>, <?php echo $employee['date_of_birth']?>
            </p>

            <!-- <hr> -->

            <strong><i class="fa fa-venus-mars margin-r-5"></i> Gender</strong>

            <p class="text-muted">
              <?php
              $gender = $employee['gender'];
              if ($gender == "F") {
                echo "Female";
              }
              else{
                echo "Male";
              }
              ?>
            </p>

            <!-- <hr> -->

            <strong><i class="fa fa-star margin-r-5"></i> Religion</strong>

            <p class="text-muted"><?php echo $employee['religion']?></p>

           <!--  <hr>
 -->
            <strong><i class="fa fa-heart margin-r-5"></i> Marital Status & Child</strong>

            <p class="text-muted">
              <?php echo $employee['marital_status']?>, <?php echo $employee['child']?> Child
            </p>

            <hr>

              <!-- <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p>

              <hr> -->  
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#contact" data-toggle="tab">Contact</a></li>
              <li><a href="#education" data-toggle="tab">Education</a></li>
              <li><a href="#employment" data-toggle="tab">Employment</a></li>
            </ul>
            <div class="tab-content">
              <!-- tab-pane contact-->
              <div class="active tab-pane" id="contact">
                <div class="box-body">
                  <dl class="dl-horizontal text-left">
                    <dt>Address</dt>
                    <dd class="text-justify"><?php echo $employee['address']?></dd>
                    <br>
                    <dt>No. Handphone</dt>
                    <dd><?php echo $employee['no_hp']?></dd>
                    <br>
                    <dt>No. Telp</dt>
                    <dd ><?php echo $employee['no_telp'] ?></dd>
                  </dl>
                </div>
              </div>
              <!-- /.tab-pane contact-->
              <!-- /.tab-pane -->

              <!-- tab-pane education-->
              <div class="tab-pane" id="education">
                <div class="box-body">
                  <dl class="dl-horizontal text-left">
                    <dt>Last Education</dt>
                    <dd><?php echo $employee['education']?></dd>
                    <br>
                    <dt>School Majors</dt>
                    <dd><?php echo $employee['school_majors']?></dd>
                    <br>
                    <dt>School Name</dt>
                    <dd><?php echo $employee['school_name']?></dd>
                    <br>
                    <dt>Year Graduation</dt>
                    <dd ><?php echo $employee['year_graduation'] ?></dd>
                  </dl>
                </div>
              </div>
              <!-- /.tab-pane education-->
              <!-- /.tab-pane -->

              <!-- tab-pane employment-->
              <div class="tab-pane" id="employment">
                <div class="box-body">
                  <dl class="dl-horizontal text-left">
                    <dt>Existing Job</dt>
                    <dd><?php echo $employee['existing_job']?></dd>
                    <br>
                    <dt>Join Date</dt>
                    <dd><?php echo $employee['join_date']?></dd>
                    <br>
                    <dt>Resign Date</dt>
                    <dd><?php echo $employee['resign_date']?></dd>
                    <br>
                    <dt>Probation Start Date</dt>
                    <dd><?php echo $employee['prob_date']?></dd>
                    <br>
                    <dt>Contract 1 Start Date</dt>
                    <dd><?php echo $employee['contract1_start']?></dd>
                    <br>
                    <dt>Contract 2 Start Date</dt>
                    <dd><?php echo $employee['contract2_start']?></dd>
                    <br>
                    <dt>Contract 3 Start Date</dt>
                    <dd><?php echo $employee['contract3_start']?></dd>
                    <br>
                    <dt>End Date</dt>
                    <dd><?php echo $employee['end_date']?></dd>
                    <br>

                    <dt>Department</dt>
                    <dd><?php echo $employee['department']?></dd>
                    <br>
                    <dt>Employment</dt>
                    <dd><?php echo $employee['employment']?></dd>
                    <br>
                    <dt>Employee Status</dt>
                    <dd ><?php echo $employee['employee_status'] ?></dd>
                  </dl>
                </div>
              </div>
              <!-- /.tab-pane employment-->
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