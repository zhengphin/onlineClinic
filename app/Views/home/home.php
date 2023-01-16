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
  
  </head>
  <body>
    <header class="position-relative light-background-color">
      <div class="background position-absolute w-100 h-100">
        <img class="w-100" src="<?= base_url('landingPage/img/hero-9-bg-shape-cover-dark.png')?>" alt="">
        <div class="filter dark-filter-diagonal d-lg-none"></div>
      </div>
      <div class="container position-relative z-index-1">
        <nav class="navbar navbar-expand-lg navbar-dark py-4">
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
              <li class="nav-item ms-lg-4 mt-4 mt-lg-0" >
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
      <div class="container-fluid px-0 position-relative z-index-1">
        <div class="row justify-content-between align-items-center mx-0">
          <div class="col-lg-5 col-xl-4 offset-lg-1 my-5 px-5 px-md-0 text-center text-lg-start">
            <h5 class="h5 light-text-gray-2">
              Join Us
            </h5>
            <h1 class="h1 light-text-color" style="margin-top: 35px">
              Meet the Best Doctors
            </h1>
            <h4 class="h4 light-text-color" style="margin-top: 35px">
              We are always fully focused on helping your child and you
            </h4>
            <div class="cta" style="margin-top: 35px">
              <button class="btn primary-color"><span class="btn-text">Appointment Now</span>
			  </button><button class="btn primary-color btn-outline" style="margin-left: 10px"><span class=
              "btn-text light-text-color text-center">Learn More</span></button>
            </div>
          </div>
          <div class="col-lg-6 mb-5 mb-lg-0 px-0">
            <img class="cover" src="<?= base_url('landingPage/img/hero-cover-1.png') ?>" alt="">
          </div>
        </div>
      </div>
    </header>
    
    <div class="light-background-color">
      <div class="container py-7 py-lg-2 position-relative">
        <div class="row align-items-center justify-content-between">
          <div class="col-lg-5 my-5 my-lg-0">
            <div class="primary-color" style="height: 7px; width: 94px"></div>
            <h2 class="h2 text-color" style="margin-top: 35px">
              Our Services
            </h2>
            <p class="paragraph second-text-color" style="margin-top: 35px">
			We provide more than 20 kinds of services such as medical check-Up, minor surgery , nutrition, and dietary counseling and etc.
            </p><a class="d-flex flex-row justify-content-start align-items-center" href="#" style="margin-top: 35px"><span class="link primary-text-color">Learn More</span><i class=
            "bi bi-chevron-right icn-xs primary-text-color" style="margin-left: 10px"></i></a>
          </div>
          <div class="row col-lg-6">
            <div class="col-lg-6 d-flex flex-column justify-content-center">
              <div class="light-background-color accentued-drop-shadow" style="padding: 35px 40px">
                <div class="faded-primary-color radius-10" style="padding: 22px 19px; width: 70px">
                  <img src="<?= base_url('landingPage/img/cool-icon-123.svg') ?>" alt="">
                
                </div>
                <h5 class="h5 text-color" style="margin-top: 20px">
                  General Medical Consultation and Treatment
                </h5>
                <div class="danger-color" style="margin-top: 15px; height: 2px; width: 50px"></div>
                <p class="paragraph second-text-color" style="margin-top: 10px">
				  Our doctors to track the progress of your condition, manage disease or disability
                </p>
              </div>
              <div class="light-background-color accentued-drop-shadow" style="margin-top: 24px; padding: 35px 40px">
                <div class="faded-secondary-color-1 radius-10" style="padding: 22px 19px; width: 70px">
                  <img src="<?= base_url('landingPage/img/cool-icon-1525.svg') ?>" alt="">
                </div>
                <h5 class="h5 text-color" style="margin-top: 20px">
                  Online Appoinment
                </h5>
                <div class="danger-color" style="margin-top: 15px; height: 2px; width: 50px"></div>
                <p class="paragraph second-text-color" style="margin-top: 10px">
                  Book, schedule or cancel your appointment through our clinic system.
                </p>
              </div>
            </div>
            <div class="col-lg-6 d-flex flex-column justify-content-center mt-4 mt-lg-0">
              <div class="light-background-color accentued-drop-shadow" style="padding: 35px 40px">
                <div class="faded-secondary-color-2 radius-10" style="padding: 22px 19px; width: 70px">
                  <img src="<?= base_url('landingPage/img/cool-icon-154851.svg') ?>" alt="">
                </div>
                <h5 class="h5 text-color" style="margin-top: 20px">
                 Online Consultation
                </h5>
                <div class="danger-color" style="margin-top: 15px; height: 2px; width: 50px"></div>
                <p class="paragraph second-text-color" style="margin-top: 10px">
                  You can contact the doctors of our clinic for consultation via the Internet.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<div class="light-background-color">
<div class="container py-2 py-lg-2 position-relative">
<div class="row align-items-center justify-content-between">
<div class="row col-lg-6">
<img src="<?= base_url('landingPage/img/leading.png') ?>" alt="">
</div>
<div class="col-lg-5 my-5 my-lg-0">
<div class="primary-color" style="height: 7px; width: 94px"></div>
<h2 class="h2 text-color" style="margin-top: 35px">
  A LEADING HEALTHCARE PROVIDER
</h2>
<p class="paragraph second-text-color" style="margin-top: 35px">
MEDIVIRON GROUP OF CLINICS is one of the largest chain clinics in Malaysia with over 250 clinics strategically located in residential, commercial and industrial areas across 8 states on the west coast of the Peninsular.
</p><a class="d-flex flex-row justify-content-start align-items-center" href="#" style="margin-top: 35px"><span class="link primary-text-color">Learn More</span><i class="bi bi-chevron-right icn-xs primary-text-color" style="margin-left: 10px"></i></a>
</div>
</div>
</div>
</div>
   

    <section class="light-background-color">
      <div class="container py-7 py-lg-7 position-relative">
        <div class="row">
          <div class="col-lg-6">
            <h6 class="h6 primary-text-color">
              Practice Advice
            </h6>
            <h2 class="h2 text-color" style="margin-top: 10px">
              See Our Impressions
            </h2>
            <p class="paragraph second-text-color" style="margin-top: 10px">
              Our patients are impressed with our service and giving us the review on our services.
            </p>
          </div>
        </div>
        <div class="row align-items-stretch justify-content-center mt-5 mt-md-0">
          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="light-background-color d-flex flex-column align-items-center" style="padding: 25px">
              <div class="card-content text-center" style="padding: 30px">
                <div class="stars" style="margin-top: 15px">
                  <i class="bi bi-star-fill icn-sm text-warning"></i>
				  <i class="bi bi-star-fill icn-sm text-warning" style="margin-left: 5px"></i>
				  <i class="bi bi-star-fill icn-sm text-warning" style= "margin-left: 5px"></i>
				  <i class="bi bi-star-fill icn-sm text-warning" style="margin-left: 5px"></i>
				  <i class="bi bi-star-fill icn-sm text-warning" style="margin-left: 5px"></i>
                </div>
                <p class="paragraph second-text-color text-center" style="margin-top: 15px">
                  Very satisfied with the service and treatment provided. The doctor and staffs was very friendly and helpful.
                </p>
              </div>
              <div class="d-flex align-items-center">
                <div class="circle overflow-hidden" style="height: 50px; width: 50px">
              
                  <img src="<?= base_url('landingPage/img/review1.PNG') ?>" alt="">
                </div>
                <div class="d-flex flex-column justify-content-start align-items-start" style="margin-left: 15px">
                  <a class="link primary-text-color" href="#">Fatin Hazirah</a><small class="small text-color">Patient</small>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="light-background-color d-flex flex-column align-items-center" style="padding: 25px">
              <div class="card-content text-center" style="padding: 30px">
                <div class="stars" style="margin-top: 15px">
                  <i class="bi bi-star-fill icn-sm text-warning"></i><i class="bi bi-star-fill icn-sm text-warning" style="margin-left: 5px"></i><i class="bi bi-star-fill icn-sm text-warning" style=
                  "margin-left: 5px"></i><i class="bi bi-star-fill icn-sm text-warning" style="margin-left: 5px"></i><i class="bi bi-star icn-sm text-warning" style="margin-left: 5px"></i>
                </div>
                <p class="paragraph second-text-color text-center" style="margin-top: 15px">
                 My family and I always choose this Clinic because of helpful and friendly staff. Service provided was excellent. Good service. 
                </p>
              </div>
              <div class="d-flex align-items-center">
                <div class="circle overflow-hidden" style="height: 50px; width: 50px">
                  <img src="<?= base_url('landingPage/img/review2.PNG') ?>" alt="">
                </div>
                <div class="d-flex flex-column justify-content-start align-items-start" style="margin-left: 15px">
                  <a class="link primary-text-color" href="#">Khairi Md Zain </a><small class="small text-color">Patient</small>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="light-background-color d-flex flex-column align-items-center" style="padding: 25px">
              <div class="card-content text-center " style="padding: 30px">
                <div class="stars" style="margin-top: 15px">
                  <i class="bi bi-star-fill icn-sm text-warning"></i><i class="bi bi-star-fill icn-sm text-warning" style="margin-left: 5px"></i><i class="bi bi-star-fill icn-sm text-warning" style=
                  "margin-left: 5px"></i><i class="bi bi-star-fill icn-sm text-warning" style="margin-left: 5px"></i><i class="bi bi-star icn-sm text-warning" style="margin-left: 5px"></i>
                </div>
                <p class="paragraph second-text-color text-center" style="margin-top: 15px">
                  The staffs of this clinic are friendly and helpful whereas the doctors are highly professional. Although it is just a small clinic.

                </p>
              </div>
              <div class="d-flex align-items-center">
                <div class="circle overflow-hidden" style="height: 50px; width: 50px">
                  <img src="<?= base_url('landingPage/img/testimonial-user-cover-124.jpg') ?>" alt="">
                </div>
                <div class="d-flex flex-column justify-content-start align-items-start" style="margin-left: 15px">
                  <a class="link primary-text-color" href="#">Regina Miles</a><small class="small text-color">Patient</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <footer>
      <div class="position-relative dark-background-color">
        <div class="container py-5">
          <div class="row align-items-stretch">
            <div class="col-lg-3 col-md-4 mb-5 mb-lg-0">
              <h5 class="h5 light-text-color">
                Company Info
              </h5>
              <div class="links" style="margin-top: 20px">
                <a class="link d-block light-text-color" href="#">About Us</a><a class=
                "link d-block light-text-color" href="#" style="margin-top: 10px">Services</a><a class="link d-block light-text-color" href="#" style="margin-top: 10px">News And Events</a>
              </div>
            </div>
      
            <div class="col-lg-5 col-md-4 mb-5 mb-lg-0">
              <h5 class="h5 light-text-color">
                Operation Hours
              </h5>	
              <div class="links" style="margin-top: 20px">
                <p class="link d-block light-text-color" >Monday-Sunday 9am-11pm</p>
				<hr>
	            <p class="link d-block light-text-color" >Mediklinik Menglembu (KAMPAR) 18JAM is open for 16-18 hours, 7 days a week and 365-366 days a year.</p>

          
              </div>
            </div>
            
            <div class="col-lg-4 col-md-4 mb-5 mb-lg-0">
              <h5 class="h5 light-text-color">
                Get In Touch
              </h5>
              <div class="links" style="margin-top: 20px">
                <div class="feature-item d-flex align-items-center">
                  <i class="bi bi-telephone-fill icn-sm light-text-color"></i>
                  <h6 class="h6 light-text-color" style="margin-left: 10px">
                    013-760 1108
                  </h6>
                </div>
                <div class="feature-item d-flex align-items-center" style="margin-top: 10px">
                  <i class="bi bi-geo-alt icn-sm light-text-color"></i>
                  <h6 class="h6 light-text-color" style="margin-left: 10px">
                    2226, Jalan Batu Karang, Taman Bandar Baru, Bandar Baru, 31900 Kampar, Perak
                  </h6>
                </div>
                <div class="feature-item d-flex align-items-center" style="margin-top: 10px">
                  <i class="bi bi-envelope-fill icn-sm light-text-color"></i>
                  <h6 class="h6 light-text-color" style="margin-left: 10px">
                    mediklink18Jam@gmail.com
                  </h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="position-relative light-gray-1">
        <div class="container py-4">
          <div class="row justify-content-between align-items-center">
            <div class="col-md-7 mb-4 mb-md-0">
              <h6 class="h6 second-text-color">
                Made With HENG ZHENG PHIN All Right Reserved
              </h6>
            </div>
            <div class="col-md-3 text-start text-md-center">
              <div class="card-content py-2">
                <a class="facebook" href="https://www.facebook.com/MediklinikKampar/about">
				<i class="bi bi-facebook icn-sm primary-text-color"></i></a>
				<a class="instagram" href="https://www.instagram.com/medikampar/?fbclid=IwAR0yUW9XMcJ2Uc9ee9P7_62sFmVkZK5M7ZeGOsH89fafKF4t5pZQwSJxGvc"><i class="bi bi-instagram icn-sm primary-text-color" style=
                "margin-left: 20px"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
    
    <script src="<?= base_url('landingPage/js/jquery-3.4.1.min.js') ?>"></script> 
    <script src="<?= base_url('landingPage/js/bootstrap.bundle.min.js') ?>"></script> 
    <script src="<?= base_url('landingPage/js/owl.carousel.min.js') ?>"></script> 
    <script src="<?= base_url('landingPage/js/tools.js') ?>"></script>
  </body>
</html>