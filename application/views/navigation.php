<?php
$login = $this->session->userdata('logged_in');
$level = $this->session->userdata('level');
$username = $this->session->userdata('name_user');
$photo    = $this->session->userdata('photo');

?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <!-- <img src="<?php echo base_url('assets/dist/img/user2-160x160.jpg');?>" class="img-circle" alt="User Image"> -->
        <img src="<?php echo base_url('assets/uploads/employee/thumbs/'. $photo);?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $username ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $level ?></a>
      </div>
    </div>
    <!-- search form -->
    <!-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form> -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MENU NAVIGASI</li>
      

      <?php if ($level == "Admin") {?>
      <li class="treeview <?php if (!empty($tree_menu_lapor)): echo $tree_menu_lapor; elseif (empty($tree_menu_lapor)): echo ''; endif ?>">
        <a href="<?php echo base_url('lapor'); ?>">
          <i class="fa fa-edit"></i> <span>Lapor</span>
        </a>
      </li>
      <li class="treeview <?php if (!empty($tree_menu_master)): echo $tree_menu_master; elseif (empty($tree_menu_master)): echo ''; endif ?>">
        <a href="<?php echo base_url('dashboard'); ?>">
          <i class="fa fa-edit"></i> <span>Ringkasan</span>
        </a>
      </li>
      <li class="treeview <?php if (!empty($tree_menu_master)): echo $tree_menu_master; elseif (empty($tree_menu_master)): echo ''; endif ?>">
        <a href="#">
          <i class="fa fa-edit"></i> <span>Analisis</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">  
          <li class="<?php if (!empty($nav_pasien)): echo $nav_pasien; elseif (empty($nav_pasien)): echo ''; endif ?>">
            <a href="<?php echo base_url('pasien'); ?>"><i class="fa fa-circle-o text-red"></i> Pasien</a>
          </li>
          <li class="<?php if (!empty($nav_pasienklas)): echo $nav_pasienklas; elseif (empty($nav_pasienklas)): echo ''; endif ?>">
            <a href="<?php echo base_url('pasienklas'); ?>"><i class="fa fa-circle-o text-red"></i> Klasifikasi Pasien</a>
          </li>
          <li class="<?php if (!empty($nav_kegiatan)): echo $nav_kegiatan; elseif (empty($nav_kegiatan)): echo ''; endif ?>">
            <a href="<?php echo base_url('kegiatan'); ?>"><i class="fa fa-circle-o text-red"></i> Kegiatan</a>
          </li>
          <li class="<?php if (!empty($nav_obat)): echo $nav_obat; elseif (empty($nav_obat)): echo ''; endif ?>">
            <a href="<?php echo base_url('obat'); ?>"><i class="fa fa-circle-o text-red"></i> Logistik Obat</a>
          </li>
          <li class="<?php if (!empty($nav_vektor)): echo $nav_vektor; elseif (empty($nav_vektor)): echo ''; endif ?>">
            <a href="<?php echo base_url('vektor'); ?>"><i class="fa fa-circle-o text-red"></i> Vektor</a>
          </li>
          <li class="<?php if (!empty($nav_pemetaan)): echo $nav_pemetaan; elseif (empty($nav_pemetaan)): echo ''; endif ?>">
            <a href="<?php echo base_url('pemetaan'); ?>"><i class="fa fa-circle-o text-red"></i> Pemetaan</a>
          </li>
        </ul>
      </li>
      <?php  }
      elseif ($level == "Staff") { ?>
      <li class="treeview <?php if (!empty($tree_menu_master)): echo $tree_menu_master; elseif (empty($tree_menu_master)): echo ''; endif ?>">
        <a href="#">
          <i class="fa fa-edit"></i> <span>User Management</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">  
          <li class="<?php if (!empty($nav_user_management)): echo $nav_user_management; elseif (empty($nav_user_management)): echo ''; endif ?>">
            <a href="<?php echo base_url('user_management'); ?>"><i class="fa fa-circle-o text-aqua"></i> User</a>
          </li>
        </ul>
      </li>
      <?php  }
      elseif ($level == "HR") { ?>
      <li class="treeview <?php if (!empty($tree_menu_master)): echo $tree_menu_master; elseif (empty($tree_menu_master)): echo ''; endif ?>">
        <a href="#">
          <i class="fa fa-edit"></i> <span>Master Data</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">  
          <li class="<?php if (!empty($nav_department)): echo $nav_department; elseif (empty($nav_department)): echo ''; endif ?>">
            <a href="<?php echo base_url('department'); ?>"><i class="fa fa-circle-o text-red"></i> Department</a>
          </li>
          <li class="<?php if (!empty($nav_education)): echo $nav_education; elseif (empty($nav_education)): echo ''; endif ?>">
            <a href="<?php echo base_url('education'); ?>"><i class="fa fa-circle-o text-red"></i> Education</a>
          </li>
          <li class="<?php if (!empty($nav_employment)): echo $nav_employment; elseif (empty($nav_employment)): echo ''; endif ?>">
            <a href="<?php echo base_url('employment'); ?>"><i class="fa fa-circle-o text-red"></i> Employment</a>
          </li>
          <li class="<?php if (!empty($nav_employee_status)): echo $nav_employee_status; elseif (empty($nav_employee_status)): echo ''; endif ?>">
            <a href="<?php echo base_url('employee_status'); ?>"><i class="fa fa-circle-o text-red"></i> Employee Status</a>
          </li>
          <li class="<?php if (!empty($nav_marital)): echo $nav_marital; elseif (empty($nav_marital)): echo ''; endif ?>">
            <a href="<?php echo base_url('marital_status'); ?>"><i class="fa fa-circle-o text-red"></i> Marital Status</a>
          </li>
          <li class="<?php if (!empty($nav_religion)): echo $nav_religion; elseif (empty($nav_religion)): echo ''; endif ?>">
            <a href="<?php echo base_url('religion'); ?>"><i class="fa fa-circle-o text-red"></i> Religion</a>
          </li>
        </ul>
      </li>
      <li class="treeview <?php if (!empty($tree_menu_employee)): echo $tree_menu_employee; elseif (empty($tree_menu_employee)): echo ''; endif ?>">
        <a href="#">
          <i class="fa fa-edit"></i> <span>Employee</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php if (!empty($nav_employee)): echo $nav_employee; elseif (empty($nav_employee)): echo ''; endif ?>">
            <a href="<?php echo base_url('employee'); ?>"><i class="fa fa-circle-o text-aqua"></i> Employee</a>
          </li>
        </ul>
      </li>
      <?php  } ?>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>