
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=(isset($pageTitle))?$pageTitle:'Document';?></title>
<base href="/">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
        <a href="index3.html" class="nav-link">Home</a>
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

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="landingPage/img/kunkun.jfif" alt="Mendidik 18 JAM Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Mendiklinik 18 JAM</span>
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
          <a class="d-block"><?=$userInfo['name']?></a>
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
     
          <li class="nav-item">
            <a href="<?=route_to('patient.home');?>" class="nav-link 
            <?=(current_url()==base_url('patient/home'))?'active':'';?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?=route_to('patient.profile');?>" class="nav-link
            <?=(current_url()==base_url('patient/profile'))?'active':'';?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Profile
              </p>
            </a>
          </li>
        
          <li class="nav-item">
            <a href="<?=route_to('patient.appointment');?>" class="nav-link
            <?=(current_url()==base_url('patient/appointment'))?'active':'';?>">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Appointment   <span class="left badge badge-danger">Now</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=route_to('patient.payment');?>" class="nav-link
            <?=(current_url()==base_url('patient/payment'))?'active':'';?>">
              <i class="nav-icon fab fa-cc-visa"></i>
              <p>
                Payment
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=route_to('patient.lab');?>" class="nav-link
            <?=(current_url()==base_url('patient/lab'))?'active':'';?>">
              <i class="nav-icon fab fa fa-file"></i>
              <p>
                Laboratory Report
              </p>
            </a>
          </li>
         <?php
         $patientKey=readPatientKeyByIC($userInfo['ic']);
        $isIn=checkIntheQueue($patientKey);
        ?>
        <?php
        if($isIn==true){?>
  <li class="nav-item">
            <a href="<?=route_to('patient.number');?>" class="nav-link
            <?=(current_url()==base_url('patient.number'))?'active':'';?>">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Position
              </p>
            </a>
          </li>
        <?php }?>
        <?php
        if($isIn==false){?>
  <li class="nav-item">
            <a  onclick="myFunction()" class="nav-link
            <?=(current_url()==base_url('patient.number'))?'active':'';?>">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Position
              </p>
            </a>
          </li>
        <?php }?>
          <li class="nav-item">
            <a href="<?=route_to('patient.consult');?>" class="nav-link
            <?=(current_url()==base_url('patient.consult'))?'active':'';?>">
              <i class="nav-icon fas fa-user-md"></i>
              <p>
                E-Consult Room
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=route_to('patient.history');?>" class="nav-link
            <?=(current_url()==base_url('patient.history'))?'active':'';?>">
              <i class="nav-icon fa fa-history"></i>
              <p>
                Visit History
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=route_to('patient.logout');?>" class="nav-link 
            <?=(current_url()==base_url('patient/logout'))?'active':'';?>">
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
<script>
function myFunction() {
  alert("Sorry you cannot view because you are not in the queue lists please make an appointment or go to the clinic our staff will serve you.");
}
</script>
</body>
</html>
