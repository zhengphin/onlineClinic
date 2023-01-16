<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8">
    <title>
      We Care For Your Health
    </title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="stylesheet" href="<?= base_url('landingPage/css/main.css')?>">
    <link rel="stylesheet" href="<?= base_url('landingPage/css/bootstrap-icons.css')?>">
    <link rel="stylesheet" href="<?= base_url('landingPage/css/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('landingPage/css/owl.theme.default.min.css')?>">
  <style>
.map-container{
  overflow:hidden;
  padding-bottom:56.25%;
  position:relative;
  height:0;
}
.map-container iframe{
  left:0;
  top:0;
  height:100%;
  width:100%;
  position:absolute;
}
</style>
  </head>
  <body>
    <header class="position-relative dark-background-color" style="background-color:#0864fc;">
      <div class="background position-absolute w-100 h-100"  >
        <div class="filter dark-filter-diagonal d-lg-none" ></div>
      </div>
      <div class="container position-relative z-index-1" >
        <nav class="navbar navbar-expand-lg navbar-dark py-4" >
          <a class="navbar-brand" href="#">
          <h1 class="h3 mt-0">
            Mediklink 18 JAM
          </h1></a><button class="navbar-toggler" type="button" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse" aria-controls="navbarSupportedContent" aria-expanded="false"
          aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse ms-lg-5 mt-4 mt-lg-0" id="navbarSupportedContent">
            <ul class="navbar-nav align-items-center">
              <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Home')?>"><span>Home</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Home/aboutUs')?>"><span>About Us</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Home/services')?>"><span>Services</span></a>
              </li>
			   <li class="nav-item">
         <a class="nav-link" href="<?= base_url('Home/newsEvent')?>"><span>News & Events</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Home/location')?>"><span>Location</span></a>
              </li>
            </ul>
            <ul class="navbar-nav mt-4 mt-lg-0 ms-auto align-items-center">
              <li class="nav-item">
              <?php if(session()->has('loggedUser')):?>
                <a class="nav-link light-text-color" href="<?= base_url('PatientDash/home')?>"><strong>Dashboard</strong></a>
            <?php endif ?>
            <?php if(!session()->has('loggedUser')):?>
                <a class="nav-link light-text-color" href="<?= base_url('Auth')?>"><strong>Login</strong></a>
            <?php endif ?>
            </li>
              <li class="nav-item ms-lg-4 mt-4 mt-lg-0">
              <?php if(!session()->has('loggedUser')):?>
                <button class="btn primary-color" onclick="location.href='<?= base_url('Auth/register')?>'"><span class="btn-text light-text-color">Sign Up</span>
                <i class="bi bi-arrow-right-short icn-xs light-text-color" style=
                "margin-left: 15px"></i></button>
                <?php endif ?>
              </li>
            </ul>
          </div>
        </nav>
      </div>