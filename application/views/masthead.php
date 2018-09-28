<?php
$login    = $this->session->userdata('logged_in');
$level    = $this->session->userdata('level');
$username = $this->session->userdata('name_user');
$photo    = $this->session->userdata('photo');
?>
<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('dashboard'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->

      <img src="<?php echo base_url('assets/simalariacustomstyle/image/brandnew.png');?>" style="
    height: 80%;
    width: auto;
    padding: initial;" >
      
      <!-- <span class="logo-mini"><b>S</b>M</span> -->

      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Surveilans</b> Malaria</span>
      
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top ">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="<?php echo base_url('assets/dist/img/user2-160x160.jpg');?>" class="user-image" alt="User Image"> -->
              <img src="<?php echo base_url('assets/uploads/employee/thumbs/'. $photo);?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $username ?></span> 
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url('assets/uploads/employee/thumbs/'. $photo);?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $username ?> - <?php echo $level ?>
                  <small><!-- Member since Nov. 2012 --><?php echo $level ?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <!-- <a href="#" class="btn btn-default btn-flat">Profile</a> -->
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>