<!doctype html>
<html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?=base_url()."assets_new1/";?>css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet">

    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="<?=base_url()."assets_new1/";?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=base_url()."assets_new1/";?>css/owl.theme.default.min.css">
    <title>A2M</title>
    <script src="<?=base_url()."assets_new1/";?>js/jquery.min.js"></script>
    <script src="<?=base_url()."assets_new1/";?>js/owl.carousel.js"></script>
    <style type="text/css">

    </style>
  </head>

  <body>

    <!-- nav end -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light  justify-content-end">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="<?=base_url()."assets_new1/";?>images/logo.png"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav">
          <ul class="navbar-nav mx-4">
            <li class="nav-item dropdown ml-20">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink_one" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Clubs Features <i class="fas fa-chevron-down"></i>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink_one">
                <li><a class="dropdown-item" href="#"> Clubs Features 1 </a></li>
                <li><a class="dropdown-item" href="#"> Clubs Features 2 </a></li>
              </ul>
            </li>
            <li class="nav-item dropdown ml-20">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink_two" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Players Features <i class="fas fa-chevron-down"></i>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink_two">
                <li><a class="dropdown-item" href="#"> Players Features 1 </a></li>
                <li><a class="dropdown-item" href="#"> Players Features 2 </a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Calendar</a>
            </li>

            <li class="nav-item dropdown ml-20 mr-auto">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink_two" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Sports <i class="fas fa-chevron-down"></i>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink_two">
                <li><a class="dropdown-item" href="#"> Sports 1 </a></li>
                <li><a class="dropdown-item" href="#"> Sports 2 </a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">Search</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Help</a>
            </li>
            <li class="nav-item">
              <button type="button" class="btn log_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Login
              </button>
            </li>
          </ul>
        </div>
      </div>
      </div>
    </nav>

    <!-- banner start -->

    <section class="banner mx-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="banner_content text-start text-light pl-30 pt-3 pb-2">
              <div class="m_show s_hide">
                <img src="<?=base_url()."assets_new1/";?>images/Pickleball - Graphic.png" class="mb-3">
              </div>
              <h1 class="font-45">Simple and smart tool to connect with players, <br>coaches, clubs & more!</h1>
              <p class="font-15">Our world class Sports Club Platform comes with Membership Management, Tournament and
                League Organization, Pay and Play (reservations), Club Ratings, Player Performance Tracking, Event
                Management and more! We even host your website and offer branded mobile app for the clubs with all these
                features built-in!</p>
              <a class="btn_banner " href="#popup1" type="button">Request a demo</a>
            </div>

          </div>
          <div class="col-lg-6">
            <div class="banner_content text-start text-light pt-3 pb-2 relative">
              <div class="d-flex justify-content-between play_btn w-60 p-3">

                <a onclick="lightbox_open();" style="cursor: pointer;"><img src="<?=base_url()."assets_new1/";?>images/play.png"
                    style="cursor: pointer;"></a>
                <p class="mb-0 mt-3 mx-3">Watch how A2M connects the sports enthusiasts</p>

              </div>
              <div id="slider d_show">
                <div class="slides ">
                  <img src="<?=base_url()."assets_new1/";?>images/men.png" width="100%" height="70%" class="slidrimg" />
                </div>
                <div class="slides">
                  <img src="<?=base_url()."assets_new1/";?>images/chino-rocha-2FKTyJqfWX8-unsplash-removebg-preview (1).png" class="slidrimg"
                    width="100%" height="70%" />
                </div>
                <div class="slides">
                  <img src="<?=base_url()."assets_new1/";?>images/men.png" width="100%" height="70%" class="slidrimg" />
                </div>
                <div id="dot"><span class="dot"></span><span class="dot"></span><span class="dot"></span><span
                    class="dot"></span><span class="dot"></span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div id="light">
      <a class="boxclose" id="boxclose" onclick="lightbox_close();"></a>
      <video id="VisaChipCardVideo" width="600" controls>
        <source src="<?=base_url()."assets_new1/";?>images/Otilia -  Bilionera (Dee Pete remix).mp4" type="video/mp4">
        <!--Browser does not support <video> tag -->
      </video>
    </div>

    <div id="fadevedio" onClick="lightbox_close();"></div>

    <div>
      <!-- banner end -->

      <!--second banner start -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="heading second_banner text-center pt-5 pb-5">
              <h1>Become an A2M Premium Club Member</h1>
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="banner_two  mx-3 pt-5 mb-5 ">
       <div class="container-fluid">
         <div class="row">
           <div class="col-lg-6">
             <div class="banner_two_content pl-30 pt-5 mx-3">
               <h1>Organize Events,<br>Tournaments & Leagues</h1>
               <p>If you are a Coach trying to organize classes for different <br> groups, a team captain trying to manage.</p>
               <a href="#" class="btn_orange">Become a A2M Club Member</a>
             </div>
           </div>
           <div class="col-lg-6">
             <div class="banner_img text-center">
               <img src="<?=base_url()."assets_new1/";?>images/mobile.png" class="w-50">
             </div>
           </div>
         </div>
       </div>
     </div> -->
      <style type="text/css">
        .carousel-indicators [data-bs-target] {
          box-sizing: content-box;
          flex: 0 1 auto;
          width: 20px;
          border-radius: 50%;
          height: 20px;
          padding: 0;
          margin-right: 3px;
          margin-left: 3px;
          text-indent: -999px;
          cursor: pointer;
          background-color: #774CFA;
          background-clip: padding-box;
          border: 0;
          border-top: 10px solid transparent;
          border-bottom: 10px solid transparent;
          transition: opacity .6s ease;
        }

        .carousel-indicators .active {
          box-sizing: content-box;
          flex: 0 1 auto;
          width: 20px;
          border-radius: 50%;
          height: 20px;
          padding: 0;
          margin-right: 3px;
          margin-left: 3px;
          text-indent: -999px;
          cursor: pointer;
          background-color: #F57549;
          background-clip: padding-box;
          border: 0;
          border-top: 10px solid transparent;
          border-bottom: 10px solid transparent;
          transition: opacity .6s ease;
        }
      </style>
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="banner_two  mx-3 pt-5 mb-5 ">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-lg-6 pl-100 col-12 col-sm-12">
                    <div class="banner_two_content pl-30 pt-5 mx-3">
                      <h1>Organize Events,<br>Tournaments & Leagues</h1>
                      <p>If you are a Coach trying to organize classes for different <br> groups, a team captain trying
                        to manage.</p>
                      <a href="#" class="btn_orange">Become a A2M Club Member</a>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="banner_img text-center">
                      <img src="<?=base_url()."assets_new1/";?>images/mobile.png" class="w-50">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="banner_two  mx-3 pt-5 mb-5 ">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-lg-6 pl-100">
                    <div class="banner_two_content pl-30 pt-5 mx-3">
                      <h1>Organize Events,<br>Tournaments & Leagues</h1>
                      <p>If you are a Coach trying to organize classes for different <br> groups, a team captain trying
                        to manage.</p>
                      <a href="#" class="btn_orange">Become a A2M Club Member</a>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="banner_img text-center">
                      <img src="<?=base_url()."assets_new1/";?>images/mobile.png" class="w-50">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!--second banner end -->
      <!--third banner start -->

      <div id="carouselExampleCaptions2" class="carousel slide third_banner" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleCaptions2" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions2" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions2" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="mx-3 pt-5 mb-5 ">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="pt-5 px-5 banner_three_one text-center text-light">
                      <h2>Court Reservations</h2>
                      <p class="mb-5">200+ Available courts to book</p>
                      <img src="<?=base_url()."assets_new1/";?>images/mob_2.png" class="w-60">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="pt-5 px-5 banner_three_two text-center">
                      <h2>Membership <br>Management System</h2>
                      <p class="mb-5">If you are a Coach trying to organize classes for different</p>
                      <img src="<?=base_url()."assets_new1/";?>images/desktop.png" class="w-60">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="  mx-3 pt-5 mb-5 ">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="pt-5 px-5 banner_three_one text-center text-light">
                      <h2>Court Reservations</h2>
                      <p class="mb-5">200+ Available courts to book</p>
                      <img src="<?=base_url()."assets_new1/";?>images/mob_2.png" class="w-60">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="pt-5 px-5 banner_three_two text-center">
                      <h2>Membership <br>Management System</h2>
                      <p class="mb-5">If you are a Coach trying to organize classes for different</p>
                      <img src="<?=base_url()."assets_new1/";?>images/desktop.png" class="w-60">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
      <!--third banner end -->
      <!--fourth banner start -->
      <div class="banner_two second  mx-3 pt-5 mb-5 ">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6">
              <div class="banner_two_content fourth pl-30 pt-5 mx-3">
                <h1>Sell Equipment or <br> Merchandise </h1>
                <p>If you are a Coach trying to organize classes for different</p>
                <a href="#" class="btn_orange">Become a A2M Club Member</a>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="banner_img text-center">
                <img src="<?=base_url()."assets_new1/";?>images/mobile.png" class="w-50">
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--fourth banner end -->

      <!--seven banner start -->
      <div class="bg-white">
        <div class="container-fluid">
          <div class="row">
            <div class="heading text-center pt-5 pb-5">
              <h1>Featured Tournaments / Leagues / Events</h1>
            </div>
          </div>
          <div class="row">
            <div id="feature" class="owl-carousel  owl-theme Testimonials">
              <div class="item  ">
                <!-- d-flex justify-content-between -->
                <div class="d-flex feature_box">
                  <div class="feature_left bg-white p-3">
                    <div class="d-flex justify-content-start"><img src="<?=base_url()."assets_new1/";?>images/tennis.svg" class="w-10">
                      <h6 class="uppercase mb-0 mx-3"> Table tennis</h6>
                    </div>
                    <div class="day d-flex mt-1 mb-1">
                      <h1 class="mb-0">30</h1>
                      <h6 class="mx-3 mb-0">June <br>7:30 PM</h6>
                    </div>
                    <h6>ARC Table Tennis<br> League (Saturdays)</h6>
                    <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new1/";?>images/location.svg" class="w-10">
                      <p class="uppercase mb-0 mx-1"> Cumming, Georgia</p>
                    </div>
                    <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new1/";?>images/league.svg" class="w-10">
                      <p class="uppercase mb-0 mx-1">League</p>
                    </div>
                    <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new1/";?>images/team.svg" class="w-10">
                      <p class="uppercase mb-0 mx-1"> 20 Teams</p>
                    </div>
                  </div>
                  <div class="feature_right">
                    <div class="feature_img">
                      <img src="<?=base_url()."assets_new1/";?>images/feature.png" class="w-242">
                    </div>
                  </div>
                </div>
              </div>

              <div class="item  ">
                <!-- d-flex justify-content-between -->
                <div class="d-flex feature_box">
                  <div class="feature_left bg-white p-3">
                    <div class="d-flex justify-content-start"><img src="<?=base_url()."assets_new1/";?>images/tennis.svg" class="w-10">
                      <h6 class="uppercase mb-0 mx-3"> Table tennis</h6>
                    </div>
                    <div class="day d-flex mt-1 mb-1">
                      <h1 class="mb-0">30</h1>
                      <h6 class="mx-3 mb-0">June <br>7:30 PM</h6>
                    </div>
                    <h6>ARC Table Tennis<br> League (Saturdays)</h6>
                    <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new1/";?>images/location.svg" class="w-10">
                      <p class="uppercase mb-0 mx-1"> Cumming, Georgia</p>
                    </div>
                    <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new1/";?>images/league.svg" class="w-10">
                      <p class="uppercase mb-0 mx-1">League</p>
                    </div>
                    <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new1/";?>images/team.svg" class="w-10">
                      <p class="uppercase mb-0 mx-1"> 20 Teams</p>
                    </div>
                  </div>
                  <div class="feature_right">
                    <div class="feature_img">
                      <img src="<?=base_url()."assets_new1/";?>images/feature (1).jpeg" class="w-242">
                    </div>
                  </div>
                </div>
              </div>

              <div class="item  ">
                <!-- d-flex justify-content-between -->
                <div class="d-flex feature_box">
                  <div class="feature_left bg-white p-3">
                    <div class="d-flex justify-content-start"><img src="<?=base_url()."assets_new1/";?>images/tennis.svg" class="w-10">
                      <h6 class="uppercase mb-0 mx-3"> Table tennis</h6>
                    </div>
                    <div class="day d-flex mt-1 mb-1">
                      <h1 class="mb-0">30</h1>
                      <h6 class="mx-3 mb-0">June <br>7:30 PM</h6>
                    </div>
                    <h6>ARC Table Tennis<br> League (Saturdays)</h6>
                    <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new1/";?>images/location.svg" class="w-10">
                      <p class="uppercase mb-0 mx-1"> Cumming, Georgia</p>
                    </div>
                    <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new1/";?>images/league.svg" class="w-10">
                      <p class="uppercase mb-0 mx-1">League</p>
                    </div>
                    <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new1/";?>images/team.svg" class="w-10">
                      <p class="uppercase mb-0 mx-1"> 20 Teams</p>
                    </div>
                  </div>
                  <div class="feature_right">
                    <div class="feature_img">
                      <img src="<?=base_url()."assets_new1/";?>images/feature (2).jpeg" class="w-242">
                    </div>
                  </div>
                </div>
              </div>
              <div class="item  ">
                <!-- d-flex justify-content-between -->
                <div class="d-flex feature_box">
                  <div class="feature_left bg-white p-3">
                    <div class="d-flex justify-content-start"><img src="<?=base_url()."assets_new1/";?>images/tennis.svg" class="w-10">
                      <h6 class="uppercase mb-0 mx-3"> Table tennis</h6>
                    </div>
                    <div class="day d-flex mt-1 mb-1">
                      <h1 class="mb-0">30</h1>
                      <h6 class="mx-3 mb-0">June <br>7:30 PM</h6>
                    </div>
                    <h6>ARC Table Tennis<br> League (Saturdays)</h6>
                    <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new1/";?>images/location.svg" class="w-10">
                      <p class="uppercase mb-0 mx-1"> Cumming, Georgia</p>
                    </div>
                    <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new1/";?>images/league.svg" class="w-10">
                      <p class="uppercase mb-0 mx-1">League</p>
                    </div>
                    <div class="d-flex justify-content-start mb-1"><img src="<?=base_url()."assets_new1/";?>images/team.svg" class="w-10">
                      <p class="uppercase mb-0 mx-1"> 20 Teams</p>
                    </div>
                  </div>
                  <div class="feature_right">
                    <div class="feature_img">
                      <img src="<?=base_url()."assets_new1/";?>images/feature.png" class="w-242">
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
      <!--seven banner end -->
      <!--fifth banner start -->

      <!--fifth banner end -->

      <!--seven banner start -->
      <div class="Latest_newa  m_show">
        <div class="container-fluid">
          <div class="row">
            <div class="heading text-center pt-5 pb-5">
              <h1>A2M Latest News</h1>
            </div>
          </div>
          <div class="row">
            <div id="Testimonials1" class="owl-carousel owl-theme Testimonials">
              <div class="item  ">
                <div class="latest_card d-flex mb-4 justify-content-between">
                  <div class="latest_img">
                    <img src="<?=base_url()."assets_new1/";?>images/Thumbmail.png" class="w-100">
                    <!-- <span class="date_upload">May 4, 2021</span> -->
                  </div>
                  <div class="latest_content p-4 bg-white">
                    <h5>We are heading to South Carolina for Summer Pickleball Tournament! Detai</h5>
                    <p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Amet minim mollit non
                      Amet minim mollit non</p>
                    <a href="#">Read more</a>
                  </div>
                </div>
              </div>
              <div class="item  ">
                <div class="latest_card d-flex mb-4 justify-content-between">
                  <div class="latest_img">
                    <img src="<?=base_url()."assets_new1/";?>images/Thumbmail.png" class="w-100">
                    <!-- <span class="date_upload">May 4, 2021</span> -->
                  </div>
                  <div class="latest_content p-4 bg-white">
                    <h5>We are heading to South Carolina for Summer Pickleball Tournament! Detai</h5>
                    <p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Amet minim mollit non
                      Amet minim mollit non</p>
                    <a href="#">Read more</a>
                  </div>
                </div>
              </div>
              <div class="item  ">
                <div class="latest_card d-flex mb-4 justify-content-between">
                  <div class="latest_img">
                    <img src="<?=base_url()."assets_new1/";?>images/Thumbmail.png" class="w-100">
                    <!-- <span class="date_upload">May 4, 2021</span> -->
                  </div>
                  <div class="latest_content p-4 bg-white">
                    <h5>We are heading to South Carolina for Summer Pickleball Tournament! Detai</h5>
                    <p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Amet minim mollit non
                      Amet minim mollit non</p>
                    <a href="#">Read more</a>
                  </div>
                </div>
              </div>
              <div class="item  ">
                <div class="latest_card d-flex mb-4 justify-content-between">
                  <div class="latest_img">
                    <img src="<?=base_url()."assets_new1/";?>images/Thumbmail.png" class="w-100">
                    <!-- <span class="date_upload">May 4, 2021</span> -->
                  </div>
                  <div class="latest_content p-4 bg-white">
                    <h5>We are heading to South Carolina for Summer Pickleball Tournament! Detai</h5>
                    <p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Amet minim mollit non
                      Amet minim mollit non</p>
                    <a href="#">Read more</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--seven banner end -->

      <!--six banner start -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="heading text-center pt-5 pb-5">
              <h1>Premium Clubs</h1>
            </div>
          </div>
        </div>
      </div>
      <div class="six_banner_details mx-3 mb-5">
        <div class="container-fluid">
          <div class="row">
            <div id="company" class="owl-carousel owl-theme Testimonials">
              <div class="item  ">
                <div class="company">
                  <img src="<?=base_url()."assets_new1/";?>images/c_logo (1).png">
                </div>
              </div>
              <div class="item  ">
                <div class="company">
                  <img src="<?=base_url()."assets_new1/";?>images/c_logo (2).png">
                </div>
              </div>
              <div class="item  ">
                <div class="company">
                  <img src="<?=base_url()."assets_new1/";?>images/c_logo (3).png">
                </div>
              </div>
              <div class="item  ">
                <div class="company">
                  <img src="<?=base_url()."assets_new1/";?>images/c_logo (4).png">
                </div>
              </div>
              <div class="item  ">
                <div class="company">
                  <img src="<?=base_url()."assets_new1/";?>images/c_logo (5).png">
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <!-- <section class="customer-logos slider">
      <div class="slide"></div>
      <div class="slide"><img src="<?=base_url()."assets_new1/";?>images/c_logo (2).png"></div>
      <div class="slide"><img src="<?=base_url()."assets_new1/";?>images/c_logo (3).png"></div>
      <div class="slide"><img src="<?=base_url()."assets_new1/";?>images/c_logo (4).png"></div>
      <div class="slide"><img src="<?=base_url()."assets_new1/";?>images/c_logo (5).png"></div>
      <div class="slide"><img src="<?=base_url()."assets_new1/";?>images/c_logo (1).png"></div>
      <div class="slide"><img src="<?=base_url()."assets_new1/";?>images/c_logo (2).png"></div>
      <div class="slide"><img src="<?=base_url()."assets_new1/";?>images/c_logo (3).png"></div>
   </section> -->
            </div>
          </div>
        </div>
      </div>
      <!--six banner end -->
      <!--seven banner start -->
      <div class="bg-white">
        <div class="container-fluid">
          <div class="row">
            <div class="heading text-center pt-5 pb-5">
              <h1>Testimonials</h1>
            </div>
          </div>
          <div class="row">
            <div id="Testimonials" class="owl-carousel owl-theme Testimonials">
              <div class="item  ">
                <div class="testimonials_box">
                  <div class=" p-4">
                    <img src="<?=base_url()."assets_new1/";?>images/coma.png" class="w-10 mb-3">
                    <p>I have seen the coaching here and it's really amazing how passionate they are about their kids.
                      Very dedicated and hardworking team. I'm sure they will bring the best out of the kids. </p>
                    <div class="review_name d-flex justify-content-start align-items-center">
                      <img src="<?=base_url()."assets_new1/";?>images/name.png" class="w-15">
                      <h6 class="mx-3">Raj Kosaraju</h6>
                    </div>
                  </div>
                </div>
              </div>

              <div class="item  ">
                <div class="testimonials_box">
                  <div class=" p-4">
                    <img src="<?=base_url()."assets_new1/";?>images/coma.png" class="w-10 mb-3">
                    <p>I have seen the coaching here and it's really amazing how passionate they are about their kids.
                      Very dedicated and hardworking team. I'm sure they will bring the best out of the kids. </p>
                    <div class="review_name d-flex justify-content-start align-items-center">
                      <img src="<?=base_url()."assets_new1/";?>images/name.png" class="w-15">
                      <h6 class="mx-3">Raj Kosaraju</h6>
                    </div>
                  </div>
                </div>
              </div>

              <div class="item  ">
                <div class="testimonials_box">
                  <div class=" p-4">
                    <img src="<?=base_url()."assets_new1/";?>images/coma.png" class="w-10 mb-3">
                    <p>I have seen the coaching here and it's really amazing how passionate they are about their kids.
                      Very dedicated and hardworking team. I'm sure they will bring the best out of the kids. </p>
                    <div class="review_name d-flex justify-content-start align-items-center">
                      <img src="<?=base_url()."assets_new1/";?>images/name.png" class="w-15">
                      <h6 class="mx-3">Raj Kosaraju</h6>
                    </div>
                  </div>
                </div>
              </div>

              <div class="item  ">
                <div class="testimonials_box">
                  <div class=" p-4">
                    <img src="<?=base_url()."assets_new1/";?>images/coma.png" class="w-10 mb-3">
                    <p>I have seen the coaching here and it's really amazing how passionate they are about their kids.
                      Very dedicated and hardworking team. I'm sure they will bring the best out of the kids. </p>
                    <div class="review_name d-flex justify-content-start align-items-center">
                      <img src="<?=base_url()."assets_new1/";?>images/name.png" class="w-15">
                      <h6 class="mx-3">Raj Kosaraju</h6>
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
      <!--seven banner end -->



      <!--Eight banner start -->
      <div class="container-fluid d_show">
        <div class="row">
          <div class="col-lg-12">
            <div class="heading text-center pt-5 pb-5">
              <h1>A2M Latest News</h1>
            </div>
          </div>
        </div>
      </div>
      <div class="eight_banner_details mx-3 mb-5">
        <div class="container-fluid d_show">
          <div class="row">
            <div class="col-lg-6">
              <div class="Latest_newa" style="padding: 1.5rem 1.5rem 1.5rem 1.5rem !important;">
                <div class="latest_card d-flex mb-4 justify-content-between">
                  <div class="latest_img">
                    <img src="<?=base_url()."assets_new1/";?>images/latest.png" class="w-100">
                    <span class="date_upload">May 4, 2021</span>
                  </div>
                  <div class="latest_content p-4 bg-white">
                    <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                    <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit
                      non <br> Amet minim mollit non</p>
                    <a href="#">Read more</a>
                  </div>
                </div>
                <div class="latest_card d-flex mb-4 justify-content-between">
                  <div class="latest_img">
                    <img src="<?=base_url()."assets_new1/";?>images/latest.png" class="w-100">
                    <span class="date_upload">May 4, 2021</span>
                  </div>
                  <div class="latest_content p-4 bg-white">
                    <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                    <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit
                      non <br> Amet minim mollit non</p>
                    <a href="#">Read more</a>
                  </div>
                </div>
                <div class="latest_card d-flex mb-4 justify-content-between">
                  <div class="latest_img">
                    <img src="<?=base_url()."assets_new1/";?>images/latest.png" class="w-100">
                    <span class="date_upload">May 4, 2021</span>
                  </div>
                  <div class="latest_content p-4 bg-white">
                    <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                    <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit
                      non <br> Amet minim mollit non</p>
                    <a href="#">Read more</a>
                  </div>
                </div>
                <div class="latest_card d-flex justify-content-between">
                  <div class="latest_img">
                    <img src="<?=base_url()."assets_new1/";?>images/latest.png" class="w-100">
                    <span class="date_upload">May 4, 2021</span>
                  </div>
                  <div class="latest_content p-4 bg-white">
                    <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                    <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit
                      non <br> Amet minim mollit non</p>
                    <a href="#">Read more</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="Latest_newa" style="padding: 1.5rem 1.5rem 1.5rem 1.5rem !important;">
                <div class="latest_card d-flex mb-4 justify-content-between">
                  <div class="latest_img">
                    <img src="<?=base_url()."assets_new1/";?>images/latest.png" class="w-100">
                    <span class="date_upload">May 4, 2021</span>
                  </div>
                  <div class="latest_content p-4 bg-white">
                    <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                    <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit
                      non <br> Amet minim mollit non</p>
                    <a href="#">Read more</a>
                  </div>
                </div>
                <div class="latest_card d-flex mb-4 justify-content-between">
                  <div class="latest_img">
                    <img src="<?=base_url()."assets_new1/";?>images/latest.png" class="w-100">
                    <span class="date_upload">May 4, 2021</span>
                  </div>
                  <div class="latest_content p-4 bg-white">
                    <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                    <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit
                      non <br> Amet minim mollit non</p>
                    <a href="#">Read more</a>
                  </div>
                </div>
                <div class="latest_card d-flex mb-4 justify-content-between">
                  <div class="latest_img">
                    <img src="<?=base_url()."assets_new1/";?>images/latest.png" class="w-100">
                    <span class="date_upload">May 4, 2021</span>
                  </div>
                  <div class="latest_content p-4 bg-white">
                    <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                    <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit
                      non <br> Amet minim mollit non</p>
                    <a href="#">Read more</a>
                  </div>
                </div>
                <div class="latest_card d-flex justify-content-between">
                  <div class="latest_img">
                    <img src="<?=base_url()."assets_new1/";?>images/latest.png" class="w-100">
                    <span class="date_upload">May 4, 2021</span>
                  </div>
                  <div class="latest_content p-4 bg-white">
                    <h5>We are heading to South Carolina for <br> Summer Pickleball Tournament! Detai</h5>
                    <p>Amet minim mollit non deserunt ullamco est sit <br> aliqua dolor do amet sint. Amet minim mollit
                      non <br> Amet minim mollit non</p>
                    <a href="#">Read more</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <!--Eight banner end -->


      <!--Nine banner start -->
      <div class="bg_nine mt-5 mb-5">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-10 offset-lg-1">
              <div class="bg_app p-5 text-center text-light">
                <h1 class="mb-5">Find A2M Sports<br>app on your mobile</h1>
                <div class="app_imges">
                  <img src="<?=base_url()."assets_new1/";?>images/Apple - App Store.png">
                  <img src="<?=base_url()."assets_new1/";?>images/Google - Play Store.png">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Nine banner end -->







      <div class="bg_fotter pt-5 pb-5">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6">
              <div class="heading pb-3 text-center">
                <h1>Comments/Feedback</h1>
              </div>
              <div class="row">
                <div class="col-lg-8 offset-lg-2">

                  <form class="row g-3">
                    <div class="col-md-12">
                      <input type="text" class="form-control" id="inputl4" placeholder="Full Name">
                    </div>
                    <div class="col-md-12">
                      <input type="email" class="form-control" id="inputEmail4" placeholder="Email Address">
                    </div>
                    <div class="col-12">
                      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                        placeholder="Add Your Message (optional)"></textarea>
                    </div>

                    <div class="form-group">
                      <div class="g-recaptcha" data-sitekey="6LfKURIUAAAAAO50vlwWZkyK_G2ywqE52NU7YO0S"
                        data-callback="verifyRecaptchaCallback" data-expired-callback="expiredRecaptchaCallback"></div>
                      <input class="form-control d-none" data-recaptcha="true" required
                        data-error="Please complete the Captcha">
                      <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-12">
                      <button type="submit" class="btn btn_orange w-100 pt-2 pb-2">Sign in</button>
                    </div>

                  </form>


                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="heading pb-3 text-center">
                <h1>Contact Us</h1>
              </div>
              <div class="row">
                <div class="col-lg-8 offset-lg-2">
                  <div class="contact d-flex justify-content-center align-items-center">
                    <p><img src="<?=base_url()."assets_new1/";?>images/phone.png">
                      +1 470 533 8707</p>
                  </div>
                  <div class="socil text-center">
                    <a href="#"><img src="<?=base_url()."assets_new1/";?>images/Facebook.png"></a>
                    <a href="#"><img src="<?=base_url()."assets_new1/";?>images/TwitterLogo.png"></a>
                    <a href="#"><img src="<?=base_url()."assets_new1/";?>images/InstagramLogo.png"></a>
                  </div>



                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyright pt-4 pb-4">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <p class="text-center text-light mb-0">Copyright © 2021 A2M Sports. All Rights Reserved.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- popup start -->
      <div id="popup1" class="overlay">
        <div class="popup">
          <h2>Here i am</h2>
          <a class="close" href="#">&times;</a>
          <div class="content">
            Thank to pop me out of that button, but now i'm done so you can close this window.
          </div>
        </div>
      </div>
      <!-- popup start end-->


      <!-- Optional JavaScript; choose one of the two! -->
      <script src="<?=base_url()."assets_new1/";?>https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
      </script>
      <!-- Option 1: Bootstrap Bundle with Popper -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
      </script>

      <!-- Option 2: Separate Popper and Bootstrap JS -->
      <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
      <script>
        $(document).ready(function () {
          var owl = $('#feature');
          owl.owlCarousel({
            margin: 50,
            nav: true,
            loop: true,
            autoplay: true,
            responsive: {
              0: {
                items: 1
              },
              600: {
                items: 3
              },
              1000: {
                items: 3
              }
            }
          })
        })
      </script>




      <script>
        $(document).ready(function () {
          var owl = $('#Testimonials');
          owl.owlCarousel({
            margin: 50,
            nav: true,
            loop: true,
            autoplay: true,
            responsive: {
              0: {
                items: 1
              },
              600: {
                items: 3
              },
              1000: {
                items: 3
              }
            }
          })
        })
      </script>
      <script>
        $(document).ready(function () {
          var owl = $('#Testimonials1');
          owl.owlCarousel({
            margin: 50,
            nav: true,
            loop: true,
            autoplay: true,
            responsive: {
              0: {
                items: 1
              },
              600: {
                items: 3
              },
              1000: {
                items: 3
              }
            }
          })
        })
      </script>
      <script>
        $(document).ready(function () {
          var owl = $('#company');
          owl.owlCarousel({
            margin: 50,
            nav: true,
            loop: true,
            autoplay: true,
            responsive: {
              0: {
                items: 1
              },
              600: {
                items: 3
              },
              1000: {
                items: 5
              }
            }
          })
        })
      </script>
      <!--     <script>
    
    $(document).ready(function(){
        $('.customer-logos').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: false,
            dots: false,
            pauseOnHover:false,
            responsive: [{
                breakpoint: 768,
                setting: {
                    slidesToShow:4
                }
            }, {
                breakpoint: 520,
                setting: {
                    slidesToShow: 3
                }
            }]
        });
    });

    </script> -->
      <script src="<?=base_url()."assets_new1/";?>js/highlight.js"></script>
      <script src="<?=base_url()."assets_new1/";?>js/app.js"></script>
      <script src="https://kit.fontawesome.com/140af656c6.js" crossorigin="anonymous"></script>
  </body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="<?=base_url()."assets_new1/";?>validator.js"></script>
<script src="<?=base_url()."assets_new1/";?>contact.js"></script>

<script type="text/javascript">
  $(document).ready(function () {
    $('.customer-logos').slick({
      slidesToShow: 6,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 1500,
      arrows: false,
      dots: false,
      pauseOnHover: false,
      responsive: [{
        breakpoint: 768,
        settings: {
          slidesToShow: 4
        }
      }, {
        breakpoint: 520,
        settings: {
          slidesToShow: 3
        }
      }]
    });
  });
  var index = 0;
  var slides = document.querySelectorAll(".slides");
  var dot = document.querySelectorAll(".dot");

  function changeSlide() {

    if (index < 0) {
      index = slides.length - 1;
    }

    if (index > slides.length - 1) {
      index = 0;
    }

    for (let i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
      dot[i].classList.remove("active");
    }

    slides[index].style.display = "block";
    dot[index].classList.add("active");

    index++;

    setTimeout(changeSlide, 3000);

  }

  changeSlide();

  window.document.onkeydown = function (e) {
    if (!e) {
      e = event;
    }
    if (e.keyCode == 27) {
      lightbox_close();
    }
  }

  function lightbox_open() {
    var lightBoxVideo = document.getElementById("VisaChipCardVideo");
    window.scrollTo(0, 0);
    document.getElementById('light').style.display = 'block';
    document.getElementById('fadevedio').style.display = 'block';
    lightBoxVideo.play();
  }

  function lightbox_close() {
    var lightBoxVideo = document.getElementById("VisaChipCardVideo");
    document.getElementById('light').style.display = 'none';
    document.getElementById('fadevedio').style.display = 'none';
    lightBoxVideo.pause();
  }
  document.addEventListener("DOMContentLoaded", function () {
    // add padding top to show content behind navbar
    navbar_height = document.querySelector('.navbar').offsetHeight;
    document.body.style.paddingTop = navbar_height + 'px';
  });
</script>