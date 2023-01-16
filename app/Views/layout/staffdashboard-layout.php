
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js'></script>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=(isset($pageTitle))?$pageTitle:'Document';?></title>
<base href="/">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>

.navbar-nav .active{  color:red !important;
}



  </style>
  <script src="https://code.iconify.design/iconify-icon/1.0.2/iconify-icon.min.js"></script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

   <!-- Navbar -->
   <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link"><?=$userInfo['position']?> Panel</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

    
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" onclick="var el = document.getElementById('element'); el.requestFullscreen();"  role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
     
    </ul>
  </nav>
  <!-- /.navbar -->
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-info">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="landingPage/img/kunkun.jfif" alt="Mendidik 18 JAM Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-dark">Mediklinik  18 JAM</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <?php if(isset($userInfo['img'])&&!empty($userInfo['img'])):?>
          <img src="<?=$userInfo['img']?>" class="img-circle elevation-2" alt="User Image">

  
                  <?php endif ?>
                  <?php if(!isset($userInfo['img'])||empty($userInfo['img'])):?>
                    <img src="dist/img/usericon.png" class="img-circle elevation-2" alt="User Image">

                  <?php endif ?>
        </div>  
        <div class="info">
          <a class="d-block text-dark"><?=$userInfo['name']?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
     
          <li class="nav-item ">
            <a href="<?=route_to('staff.home');?>" class="nav-link  text-light 
            <?=(current_url()==base_url('staff/home'))?'active bg-dark':'';?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?=route_to('staff.profile');?>" class="nav-link text-light
            <?=(current_url()==base_url('staff/profile'))?'active bg-light':'';?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Profile
              </p>
            </a>
          </li>
          <?php if($userInfo['position']=="Receiptionist"){?>
              
              <li class="nav-item">
                <a href="<?=route_to('staff.queuePanel');?>" class="nav-link text-light
                <?=(current_url()==base_url('Queuing/'))?'active bg-light':'';?>">
 
                <i class="fa fa-tv" aria-hidden="true"></i>
                  <p>&nbsp;&nbsp;&nbsp;Queuing Panel</p>
                </a>
              </li> 
         
              <li class="nav-item ">
            <a href="" class="nav-link text-light">
            <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Manage Patient
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?=route_to('patient.register');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/register'))?'active bg-light':'';?>">
 
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                  <p>Patient Register</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="<?=route_to('patient.view');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/view'))?'active bg-light':'';?>">
 
                <i class="fa fas fa-search" aria-hidden="true"></i>
                  <p>View Patient</p>
                </a>
              </li> 
            </ul>
          </li>
          <li class="nav-item ">
            <a href="" class="nav-link text-light 
           ">
            <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Manage Appointment
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=route_to('staff.pending');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/pending'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Pending Appointment</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?=route_to('staff.approvedAppointment');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/approvedAppointment'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Approved Appointment</p>
                </a>
              </li>
            </ul>
          </li>

<li class="nav-item ">
            <a href="" class="nav-link text-light 
           ">
           <i class="fas fa-box"></i>
                         <p>
                Inventory Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=route_to('staff.addInventory');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/addInventory'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Add Inventory</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=route_to('staff.inventory');?>" class="nav-link text dark
                <?=(current_url()==base_url('Inventory/'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Update Inventory</p>
                </a>
              </li>
    
            </ul>
          </li>
          <li class="nav-item ">
            <a href="" class="nav-link text-light 
           ">
           <i class="fas fa-newspaper"></i>
                         <p>
                Events Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=route_to('staff.postEvent');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/postEvent'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Post Event</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=route_to('staff.eventManage');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/eventManage'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Update Event</p>
                </a>
              </li>
    
            </ul>
          </li>
          <li class="nav-item ">
            <a href="" class="nav-link text-light 
           ">
           <i class="fa fa-cog" aria-hidden="true"></i>
                         <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=route_to('staff.holiday');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/holiday'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Holiday</p>
                </a>
              </li>
            </ul>
          </li>
          <?php 
          }
          ?>
          <?php if($userInfo['position']=="Pharmacist"){?>

<li class="nav-item">
  <a href="<?=route_to('staff.medicineCollect');?>" class="nav-link text-light
  <?=(current_url()==base_url('Checkout/'))?'active bg-light':'';?>">

  <i class='fas fa-capsules' style='font-size:20px;color:red'></i>

    <p>&nbsp;&nbsp;&nbsp;Medical Collection</p>
  </a>
</li> 
<li class="nav-item">
                <a href="<?=route_to('staff.queuePanel');?>" class="nav-link text-light
                <?=(current_url()==base_url('Queuing/'))?'active bg-light':'';?>">
 
                <i class="fa fa-tv" aria-hidden="true"></i>
                  <p>&nbsp;&nbsp;&nbsp;Queuing Panel</p>
                </a>
              </li> 
              <li class="nav-item ">
            <a href="" class="nav-link text-light">
            <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Manage Patient
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?=route_to('patient.register');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/register'))?'active bg-light':'';?>">
 
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                  <p>Patient Register</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="<?=route_to('patient.view');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/view'))?'active bg-light':'';?>">
 
                <i class="fa fas fa-search" aria-hidden="true"></i>
                  <p>View Patient</p>
                </a>
              </li> 
            </ul>
          </li>


<li class="nav-item ">
            <a href="" class="nav-link text-light 
           ">
           <i class="fas fa-box"></i>
                         <p>
                Inventory Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=route_to('staff.addInventory');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/addInventory'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Add Inventory</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=route_to('staff.inventory');?>" class="nav-link text dark
                <?=(current_url()==base_url('Inventory/'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Update Inventory</p>
                </a>
              </li>
    
            </ul>
          </li>
          <li class="nav-item ">
            <a href="" class="nav-link text-light 
           ">
           <i class="fas fa-newspaper"></i>
                         <p>
                Events Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=route_to('staff.postEvent');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/postEvent'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Post Event</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=route_to('staff.eventManage');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/eventManage'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Update Event</p>
                </a>
              </li>
    
            </ul>
          </li>
          <li class="nav-item ">
            <a href="" class="nav-link text-light 
           ">
           <i class="fa fa-cog" aria-hidden="true"></i>
                         <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=route_to('staff.holiday');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/holiday'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Holiday</p>
                </a>
              </li>
            </ul>
          </li>
<?php }?>
         <?php if($userInfo['position']=="Doctor"){?>
          <li class="nav-item">
                <a href="<?=route_to('staff.consult');?>" class="nav-link text-light
                <?=(current_url()==base_url('staff/consult'))?'active bg-light':'';?>">
 
                
                <i class="nav-icon fas fa-user-md"></i>
                  <p class="">E-consultation &nbsp;
                  <span class="left badge badge-danger"><?=readAllMeetToday()?></span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=route_to('staff.queue');?>" class="nav-link text-light
                <?=(current_url()==base_url('queue/manage'))?'active bg-light':'';?>">
 
                <i class="fa fa-users" aria-hidden="true"></i>
                  <p>Queue Management</p>
                </a>
              </li>    
              
              <li class="nav-item">
                <a href="<?=route_to('staff.queuePanel');?>" class="nav-link text-light
                <?=(current_url()==base_url('Queuing/'))?'active bg-light':'';?>">
 
                <i class="fa fa-tv" aria-hidden="true"></i>
                  <p>&nbsp;&nbsp;&nbsp;Queuing Panel</p>
                </a>
              </li> 
         
              <li class="nav-item ">
            <a href="" class="nav-link text-light">
            <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Manage Patient
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?=route_to('patient.register');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/register'))?'active bg-light':'';?>">
 
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                  <p>Patient Register</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="<?=route_to('patient.view');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/view'))?'active bg-light':'';?>">
 
                <i class="fa fas fa-search" aria-hidden="true"></i>
                  <p>View Patient</p>
                </a>
              </li> 
            </ul>
          </li>
          <li class="nav-item ">
            <a href="" class="nav-link text-light 
           ">
            <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Manage Appointment
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=route_to('staff.pending');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/pending'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Pending Appointment</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?=route_to('staff.approvedAppointment');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/approvedAppointment'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Approved Appointment</p>
                </a>
              </li>
            </ul>
          </li>

<li class="nav-item ">
            <a href="" class="nav-link text-light 
           ">
           <i class="fas fa-box"></i>
                         <p>
                Inventory Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=route_to('staff.addInventory');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/addInventory'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Add Inventory</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=route_to('staff.inventory');?>" class="nav-link text dark
                <?=(current_url()==base_url('Inventory/'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Update Inventory</p>
                </a>
              </li>
    
            </ul>
          </li>
          <li class="nav-item ">
            <a href="" class="nav-link text-light 
           ">
           <i class="fas fa-newspaper"></i>
                         <p>
                Events Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=route_to('staff.postEvent');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/postEvent'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Post Event</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=route_to('staff.eventManage');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/eventManage'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Update Event</p>
                </a>
              </li>
    
            </ul>
          </li>
          <li class="nav-item ">
            <a href="" class="nav-link text-light 
           ">
           <i class="fa fa-cog" aria-hidden="true"></i>
                         <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=route_to('staff.holiday');?>" class="nav-link text dark
                <?=(current_url()==base_url('staff/holiday'))?'active bg-light':'';?>">
                  <i class="far fa fa-circle	"></i>
                  <p>&nbsp;Holiday</p>
                </a>
              </li>
            </ul>
          </li>
        <?php }?>
         
          <li class="nav-item">
            <a href="<?=base_url('staff/logout');?>" class="nav-link  text-dark
            <?=(current_url()==base_url('staff/logout'))?'active':'';?>">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Sign Out
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?=(isset($pageTitle))?$pageTitle:'Document';?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=route_to('patient.home');?>">Home</a></li>
              <li class="breadcrumb-item active"><?=(isset($pageTitle))?$pageTitle:'Document';?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <?=$this->renderSection('content');?>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy;2022 <a href="<?= base_url();?>">Mediklinik 18 JAM</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Firebase Config App -->

<script src="dist/js/config.js"></script>

</body>
</html>
