<!doctype html>
<html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url()."assets_new1/";?>css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()."assets_new1/";?>css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <link
      href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet">

    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="<?=base_url()."assets_new1/";?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=base_url()."assets_new1/";?>css/owl.theme.default.min.css">
    <title>A2M</title>

    <script src="https://kit.fontawesome.com/32e0ca3872.js" crossorigin="anonymous"></script>
  </head>

  <body class="sports">
    <!-- nav start -->
    <div class="container-fluid">
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
                <!-- Button trigger modal -->
                <button type="button" class="btn border-orange bg-orange log_btn" data-bs-toggle="modal"
                  data-bs-target="#exampleModal">
                  Sign Up
                </button>
              </li>
              <li class="nav-item">
                <!-- Button trigger modal -->
                <button type="button" class="btn border-orange text-orange log_btn" data-bs-toggle="modal"
                  data-bs-target="#exampleModal">
                  Login
                </button>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    <!-- nav end -->

    <!-- banner start -->
    <style>
      .video-container {
        position: relative;
        padding-bottom: 50.25%;
        /* 16:9 */
        height: 0;
      }

      .video-container iframe {
        position: absolute;
        top: 0;
        left: 1;
        width: 98%;
        height: 60%;
        border-radius: 33px;
      }

      @import url(https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic,900);

      * {
        box-sizing: border-box;
      }


      video {
        position: absolute;
        /*background-color: black;*/
        /*opacity: 0.4;*/
        top: 0;
        left: 1%;
        right: 15px;
        width: 98%;
        height: 72%;
        border-radius: 33px;
        margin-top: 115px;
        -o-object-fit: cover;
        object-fit: cover;
        -o-object-position: center;
        object-position: center;
      }

      .overlay {
        min-height: 0vh;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
      }

      .overlay,
      .videotage,
      .videobtn {
        color: white;
        font-weight: 600;
        margin: 2rem 3rem 0;
        mix-blend-mode: overlay;
        padding: 5px 15px;
        text-align: center;
      }
    </style>
    <section class=" mx-3 pt-5">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="banner_content text-start text-light pl-30 pt-3 pb-2">
              <div class="container">
                <video playsinline autoplay muted loop>
                  <source src="<?=base_url()."assets_new1/";?>video/Otilia -  Bilionera (Dee Pete remix).mp4" type="video/mp4">
                  Your browser does not support the video tag. I suggest you upgrade your browser.
                </video>
              </div>

              <div class="overlay">
              </div>
              <h1 class="font-45 videotage">Your Badminton Community.</h1>
              <p class="font-15 videotage">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint.
                Velit<br /> officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.
              </p>
              <br />
              <div class="row">
                <div class="col-4 col-12"></div>
                <div class="col-4 col-12">

                  <a class="btn_banner videobtn text-center" href="#popup1" type="button">Request a demo</a>
                </div>
                <div class="col-4 col-12"></div>

              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="banner_content text-start text-light pt-3 pb-2 relative">

            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- banner end -->

    <!--seven banner start -->
    <div class="bg-white">
      <div class="container-fluid">
        <div class="row">
          <div class="heading seven_banner text-center pt-5 pb-5">
            <h1>Featured Tournaments / Leagues / Events</h1>
          </div>
        </div>
        <div class="row">
          <div id="owl-one" class="owl-carousel owl-theme Testimonials">
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
    <!--fourth banner start -->
    <div class="banner_pagetwo_  mx-3 pt-5 mb-5 ">
      <div class="container">
        <div class="row banner_pagetwo_two">
          <div class="col-lg-8 pb-4">
            <div class="banner_two_content pl-30 pt-4 mx-3">
              <h1 class="mb-2">Challenge Players</h1>
              <p class="mb-3 mt-3">Can't wait till the next tournament? You can "Challenge" <br> other players to play
                with you. We will reward you everytime <br> you challenge someone with more points towards your A2M
                <br>Score'.</p>
              <a href="#" class="btn_orange">Become a A2M Club Member</a>
            </div>
          </div>
          <div class="col-lg-4 p-0">
            <div class="banner_img text-center">
              <img src="<?=base_url()."assets_new1/";?>images/image 30.png" class="w-100 brb_r">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--fourth banner end -->



    <!--seven banner start -->
    <div class="bg-blue pb-5">
      <div class="container-fluid">
        <div class="row">
          <div class="heading text-center pt-5 pb-5">
            <h1>Top Rated Badminton Players</h1>
          </div>
        </div>
        <div class="row">
          <div id="owl-one1" class="owl-carousel owl-theme Testimonials">
            <div class="item  ">
              <!-- d-flex justify-content-between -->
              <div class="players_box bg-white px-4 pt-4 pb-4">
                <div class="img mt-3  mb-4 d-flex align-items-center justify-content-between">
                  <img src="<?=base_url()."assets_new1/";?>images/player_1.png" class="player_img">
                  <img src="<?=base_url()."assets_new1/";?>images/rank_1.png" class="player_ig">
                </div>
                <div class="palyer_names d-flex justify-content-between">
                  <div class="name">
                    <p class="mb-0 gry">Name</p>
                    <h6 class="">Michael Snyder</h6>
                  </div>
                  <div class="name text-end">
                    <p class="mb-0 gry">A2M Rating</p>
                    <h6 class="">532</h6>
                  </div>
                </div>
                <div class="club_name">
                  <p class="mb-0 gry">Club</p>
                  <h6 class="mb-0">Atlanta Badminton Club</h6>
                </div>
              </div>
            </div>

            <div class="item  ">
              <!-- d-flex justify-content-between -->
              <div class="players_box bg-white px-4 pt-4 pb-4">
                <div class="img mt-3  mb-4 d-flex align-items-center justify-content-between">
                  <img src="<?=base_url()."assets_new1/";?>images/player_2.png" class="player_img">
                  <img src="<?=base_url()."assets_new1/";?>images/rank_2.png" class="player_ig">
                </div>
                <div class="palyer_names d-flex justify-content-between">
                  <div class="name">
                    <p class="mb-0 gry">Name</p>
                    <h6 class="">Jacob Jones</h6>
                  </div>
                  <div class="name text-end">
                    <p class="mb-0 gry">A2M Rating</p>
                    <h6 class="">512</h6>
                  </div>
                </div>
                <div class="club_name">
                  <p class="mb-0 gry">Club</p>
                  <h6 class="mb-0">Atlanta Badminton Club</h6>
                </div>
              </div>
            </div>

            <div class="item  ">
              <!-- d-flex justify-content-between -->
              <div class="players_box bg-white px-4 pt-4 pb-4">
                <div class="img mt-3  mb-4 d-flex align-items-center justify-content-between">
                  <img src="<?=base_url()."assets_new1/";?>images/player_3.png" class="player_img">
                  <img src="<?=base_url()."assets_new1/";?>images/rank_3.png" class="player_ig">
                </div>
                <div class="palyer_names d-flex justify-content-between">
                  <div class="name">
                    <p class="mb-0 gry">Name</p>
                    <h6 class="">Albert Flores</h6>
                  </div>
                  <div class="name text-end">
                    <p class="mb-0 gry">A2M Rating</p>
                    <h6 class="">532</h6>
                  </div>
                </div>
                <div class="club_name">
                  <p class="mb-0 gry">Club</p>
                  <h6 class="mb-0">Atlanta Badminton Club</h6>
                </div>
              </div>
            </div>
            <div class="item  ">
              <!-- d-flex justify-content-between -->
              <div class="players_box bg-white px-4 pt-4 pb-4">
                <div class="img mt-3  mb-4 d-flex align-items-center justify-content-between">
                  <img src="<?=base_url()."assets_new1/";?>images/player_4.png" class="player_img">
                  <img src="<?=base_url()."assets_new1/";?>images/rank_4.png" class="player_ig">
                </div>
                <div class="palyer_names d-flex justify-content-between">
                  <div class="name">
                    <p class="mb-0 gry">Name</p>
                    <h6 class="">Guy Hawkins</h6>
                  </div>
                  <div class="name text-end">
                    <p class="mb-0 gry">A2M Rating</p>
                    <h6 class="">442</h6>
                  </div>
                </div>
                <div class="club_name">
                  <p class="mb-0 gry">Club</p>
                  <h6 class="mb-0">Atlanta Badminton Club</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="sport_blue_btn col-lg-12 mt-5">
            <div class="btn_blue text-center">
              <a href="#" class="blue_btn">View All Players</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--seven banner end -->


    <!--active banner start -->
    <div class="bg-white bg-fig pb-5">
      <div class="container-fluid">
        <div class="row">
          <div class="heading text-center pt-5 pb-5">
            <h1>Most Active Teams</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div id="owl-one2" class="owl-carousel owl-theme Testimonials">
              <div class="item  ">
                <div class="Active_box bg-white px-4 pt-4 pb-4">
                  <div class="img mb-3 bg-grey">
                    <center><img src="<?=base_url()."assets_new1/";?>images/1537152895_20827898-removebg-preview.png" style="height: auto; width:45%;">
                    </center>
                  </div>
                  <div class="actie_content text-center">
                    <h3>Atlanta Eagles</h3>
                    <p class="gry">4.8 (62 reviews)</p>
                    <div class="text-center d-flex justify-content-center align-items-center rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <div class="group_img mt-3 mb-2 d-flex justify-content-center">
                      <img src="<?=base_url()."assets_new1/";?>images/p (1).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (2).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (3).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (4).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (5).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (6).png">
                    </div>
                  </div>


                </div>
              </div>
              <div class="item  ">
                <div class="Active_box bg-white px-4 pt-4 pb-4">
                  <div class="img mb-3 bg-grey">
                    <center><img src="<?=base_url()."assets_new1/";?>images/1537152895_20827898-removebg-preview.png" style="height: auto; width:45%;">
                    </center>
                  </div>
                  <div class="actie_content text-center">
                    <h3>Atlanta Eagles</h3>
                    <p class="gry">4.8 (62 reviews)</p>
                    <div class="text-center d-flex justify-content-center align-items-center rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <div class="group_img mt-3 mb-2 d-flex justify-content-center">
                      <img src="<?=base_url()."assets_new1/";?>images/p (1).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (2).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (3).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (4).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (5).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (6).png">
                    </div>
                  </div>


                </div>
              </div>
              <div class="item  ">
                <div class="Active_box bg-white px-4 pt-4 pb-4">
                  <div class="img mb-3 bg-grey">
                    <center><img src="<?=base_url()."assets_new1/";?>images/1537152895_20827898-removebg-preview.png" style="height: auto; width:45%;">
                    </center>
                  </div>
                  <div class="actie_content text-center">
                    <h3>Atlanta Eagles</h3>
                    <p class="gry">4.8 (62 reviews)</p>
                    <div class="text-center d-flex justify-content-center align-items-center rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <div class="group_img mt-3 mb-2 d-flex justify-content-center">
                      <img src="<?=base_url()."assets_new1/";?>images/p (1).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (2).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (3).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (4).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (5).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (6).png">
                    </div>
                  </div>


                </div>
              </div>
              <div class="item  ">
                <div class="Active_box bg-white px-4 pt-4 pb-4">
                  <div class="img mb-3 bg-grey">
                    <center><img src="<?=base_url()."assets_new1/";?>images/1537152895_20827898-removebg-preview.png" style="height: auto; width:45%;">
                    </center>
                  </div>
                  <div class="actie_content text-center">
                    <h3>Atlanta Eagles</h3>
                    <p class="gry">4.8 (62 reviews)</p>
                    <div class="text-center d-flex justify-content-center align-items-center rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <div class="group_img mt-3 mb-2 d-flex justify-content-center">
                      <img src="<?=base_url()."assets_new1/";?>images/p (1).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (2).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (3).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (4).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (5).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (6).png">
                    </div>
                  </div>


                </div>
              </div>
              <div class="item  ">
                <div class="Active_box bg-white px-4 pt-4 pb-4">
                  <div class="img mb-3 bg-grey">
                    <center><img src="<?=base_url()."assets_new1/";?>images/1537152895_20827898-removebg-preview.png" style="height: auto; width:45%;">
                    </center>
                  </div>
                  <div class="actie_content text-center">
                    <h3>Atlanta Eagles</h3>
                    <p class="gry">4.8 (62 reviews)</p>
                    <div class="text-center d-flex justify-content-center align-items-center rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <div class="group_img mt-3 mb-2 d-flex justify-content-center">
                      <img src="<?=base_url()."assets_new1/";?>images/p (1).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (2).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (3).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (4).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (5).png">
                      <img src="<?=base_url()."assets_new1/";?>images/p (6).png">
                    </div>
                  </div>


                </div>
              </div>
            </div>

          </div>
          <div class="col-lg-12">
            <div class="btn_blue text-center">
              <a href="#" class="orange_btn">View All Players</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--active banner end -->


    <!--sreach banner start -->
    <div class="banner_pagetwo_  pt-5 mb-5 ">
      <div class="container">
        <div class="row ">
          <div class="col-lg-6">
            <div class="banner_two_content orange_pic p-5 sreach_orange_bg">
              <h1 class="mb-2">Search Easily</h1>
              <p class="mb-3 mt-3">Search for Players, Matches and<br> Tournaments</p>
              <a href="#" class="btn_orange text-center w-50">Search now</a>
            </div>
            <div class="sreach_img text-center">
              <img src="<?=base_url()."assets_new1/";?>images/sreach.png" class="w-100">
            </div>

          </div>


          <div class="col-lg-6">
            <div class="banner_two_content blue_pic p-5 sreach_blue_bg">
              <h1 class="mb-2">Add Live Score</h1>
              <p class="mb-3 mt-3">You played a match without actually
                creating or registering it, you can still add it to your profile here.</p>
              <a href="#" class="btn_orange text-center w-50">Add score</a>
            </div>
            <div class="sreach_img text-center">
              <img src="<?=base_url()."assets_new1/";?>images/Socre.png" class="w-100">
            </div>

          </div>

        </div>
      </div>
    </div>
    <!--sreach banner end -->





    <!--Clubs banner start -->
    <div class="bg-white bg-fig pb-5">
      <div class="container-fluid">
        <div class="row">
          <div class="heading text-center pt-5 pb-5">
            <h1>Top Rated Clubs</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div id="owl-one3" class="owl-carousel owl-theme Testimonials">
              <div class="item activ_box ">
                <div class="Active_box bg-white px-4 pt-4">
                  <div class="club_img mb-3 d-flex justify-content-between">
                    <img src="<?=base_url()."assets_new1/";?>images/clubb.png">
                    <h4 class="mt-2">Atlanta Recreation Club</h4>
                  </div>
                  <div class="club_content text-start">
                    <div class="text-start mb-2 d-flex justify-content-start align-items-start rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <p class="gry">4.8 (62 reviews)</p>
                    <p class="club_info d-flex justify-content-start align-items-center mb-2"><img
                        src="<?=base_url()."assets_new1/";?>images/location.png"> Cumming, Georgia</p>
                    <p class="club_info d-flex justify-content-start align-items-center mb-0 pb-2"><img
                        src="<?=base_url()."assets_new1/";?>images/label.png"> Starting at $10.00/hr</p>
                  </div>
                </div>
                <a href="#" class="club_btn">Book a Session</a>
              </div>

              <div class="item activ_box ">
                <div class="Active_box bg-white px-4 pt-4">
                  <div class="club_img mb-3 d-flex justify-content-between">
                    <img src="<?=base_url()."assets_new1/";?>images/clubb.png">
                    <h4 class="mt-2">Atlanta Recreation Club</h4>
                  </div>
                  <div class="club_content text-start">
                    <div class="text-start mb-2 d-flex justify-content-start align-items-start rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <p class="gry">4.8 (62 reviews)</p>
                    <p class="club_info d-flex justify-content-start align-items-center mb-2"><img
                        src="<?=base_url()."assets_new1/";?>images/location.png"> Cumming, Georgia</p>
                    <p class="club_info d-flex justify-content-start align-items-center mb-0 pb-2"><img
                        src="<?=base_url()."assets_new1/";?>images/label.png"> Starting at $10.00/hr</p>
                  </div>
                </div>
                <a href="#" class="club_btn">Book a Session</a>
              </div>
              <div class="item activ_box ">
                <div class="Active_box bg-white px-4 pt-4">
                  <div class="club_img mb-3 d-flex justify-content-between">
                    <img src="<?=base_url()."assets_new1/";?>images/clubb.png">
                    <h4 class="mt-2">Atlanta Recreation Club</h4>
                  </div>
                  <div class="club_content text-start">
                    <div class="text-start mb-2 d-flex justify-content-start align-items-start rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <p class="gry">4.8 (62 reviews)</p>
                    <p class="club_info d-flex justify-content-start align-items-center mb-2"><img
                        src="<?=base_url()."assets_new1/";?>images/location.png"> Cumming, Georgia</p>
                    <p class="club_info d-flex justify-content-start align-items-center mb-0 pb-2"><img
                        src="<?=base_url()."assets_new1/";?>images/label.png"> Starting at $10.00/hr</p>
                  </div>
                </div>
                <a href="#" class="club_btn">Book a Session</a>
              </div>
              <div class="item activ_box ">
                <div class="Active_box bg-white px-4 pt-4">
                  <div class="club_img mb-3 d-flex justify-content-between">
                    <img src="<?=base_url()."assets_new1/";?>images/clubb.png">
                    <h4 class="mt-2">Atlanta Recreation Club</h4>
                  </div>
                  <div class="club_content text-start">
                    <div class="text-start mb-2 d-flex justify-content-start align-items-start rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <p class="gry">4.8 (62 reviews)</p>
                    <p class="club_info d-flex justify-content-start align-items-center mb-2"><img
                        src="<?=base_url()."assets_new1/";?>images/location.png"> Cumming, Georgia</p>
                    <p class="club_info d-flex justify-content-start align-items-center mb-0 pb-2"><img
                        src="<?=base_url()."assets_new1/";?>images/label.png"> Starting at $10.00/hr</p>
                  </div>
                </div>
                <a href="#" class="club_btn">Book a Session</a>
              </div>
              <div class="item activ_box ">
                <div class="Active_box bg-white px-4 pt-4">
                  <div class="club_img mb-3 d-flex justify-content-between">
                    <img src="<?=base_url()."assets_new1/";?>images/clubb.png">
                    <h4 class="mt-2">Atlanta Recreation Club</h4>
                  </div>
                  <div class="club_content text-start">
                    <div class="text-start mb-2 d-flex justify-content-start align-items-start rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <p class="gry">4.8 (62 reviews)</p>
                    <p class="club_info d-flex justify-content-start align-items-center mb-2"><img
                        src="<?=base_url()."assets_new1/";?>images/location.png"> Cumming, Georgia</p>
                    <p class="club_info d-flex justify-content-start align-items-center mb-0 pb-2"><img
                        src="<?=base_url()."assets_new1/";?>images/label.png"> Starting at $10.00/hr</p>
                  </div>
                </div>
                <a href="#" class="club_btn">Book a Session</a>
              </div>


            </div>

          </div>
          <div class="col-lg-12">
            <div class="btn_blue text-center">
              <a href="#" class="orange_btn">View All Clubs</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Clubs banner end -->



    <!-- Rated  banner start -->
    <div class="bg-blue1 pb-5">
      <div class="container-fluid">
        <div class="row">
          <div class="heading text-center pt-5 pb-5">
            <h1>Top Rated Coaches</h1>
          </div>
        </div>
        <div class="row">
          <div id="owl-one4" class="owl-carousel owl-theme Testimonials">
            <div class="item ">
              <div class="players_box bg-white px-4 pt-4 pb-4">
                <div class="img mt-3  mb-4 d-flex align-items-center justify-content-between">
                  <img src="<?=base_url()."assets_new1/";?>images/player_1.png" class="player_img">
                  <div class="">
                    <div class="text-end mb-2 d-flex justify-content-end align-items-end rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <p class="gry">4.8 (62 reviews)</p>
                  </div>
                </div>
                <div class="palyer_names d-flex justify-content-between">
                  <div class="name">
                    <p class="mb-0 gry">Name</p>
                    <h6 class="">Michael Snyder</h6>
                  </div>
                  <div class="name text-end">
                    <p class="mb-0 gry">Batches</p>
                    <h6 class="">Individual <br> & Group</h6>
                  </div>
                </div>
                <div class="club_name mt-3">
                  <p class="club_info d-flex justify-content-start align-items-center mb-2"><img
                      src="<?=base_url()."assets_new1/";?>images/location.png"> Cumming, Georgia</p>
                  <p class="club_info d-flex justify-content-start align-items-center mb-0 pb-2"><img
                      src="<?=base_url()."assets_new1/";?>images/label.png"> Starting at $10.00/hr</p>
                </div>
              </div>
            </div>

            <div class="item ">
              <div class="players_box bg-white px-4 pt-4 pb-4">
                <div class="img mt-3  mb-4 d-flex align-items-center justify-content-between">
                  <img src="<?=base_url()."assets_new1/";?>images/player_2.png" class="player_img">
                  <div class="">
                    <div class="text-end mb-2 d-flex justify-content-end align-items-end rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <p class="gry">4.8 (62 reviews)</p>
                  </div>
                </div>
                <div class="palyer_names d-flex justify-content-between">
                  <div class="name">
                    <p class="mb-0 gry">Name</p>
                    <h6 class="">Michael Snyder</h6>
                  </div>
                  <div class="name text-end">
                    <p class="mb-0 gry">Batches</p>
                    <h6 class="">Individual <br> & Group</h6>
                  </div>
                </div>
                <div class="club_name mt-3">
                  <p class="club_info d-flex justify-content-start align-items-center mb-2"><img
                      src="<?=base_url()."assets_new1/";?>images/location.png"> Cumming, Georgia</p>
                  <p class="club_info d-flex justify-content-start align-items-center mb-0 pb-2"><img
                      src="<?=base_url()."assets_new1/";?>images/label.png"> Starting at $10.00/hr</p>
                </div>
              </div>
            </div>


            <div class="item ">
              <div class="players_box bg-white px-4 pt-4 pb-4">
                <div class="img mt-3  mb-4 d-flex align-items-center justify-content-between">
                  <img src="<?=base_url()."assets_new1/";?>images/player_3.png" class="player_img">
                  <div class="">
                    <div class="text-end mb-2 d-flex justify-content-end align-items-end rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <p class="gry">4.8 (62 reviews)</p>
                  </div>
                </div>
                <div class="palyer_names d-flex justify-content-between">
                  <div class="name">
                    <p class="mb-0 gry">Name</p>
                    <h6 class="">Michael Snyder</h6>
                  </div>
                  <div class="name text-end">
                    <p class="mb-0 gry">Batches</p>
                    <h6 class="">Individual <br> & Group</h6>
                  </div>
                </div>
                <div class="club_name mt-3">
                  <p class="club_info d-flex justify-content-start align-items-center mb-2"><img
                      src="<?=base_url()."assets_new1/";?>images/location.png"> Cumming, Georgia</p>
                  <p class="club_info d-flex justify-content-start align-items-center mb-0 pb-2"><img
                      src="<?=base_url()."assets_new1/";?>images/label.png"> Starting at $10.00/hr</p>
                </div>
              </div>
            </div>


            <div class="item ">
              <div class="players_box bg-white px-4 pt-4 pb-4">
                <div class="img mt-3  mb-4 d-flex align-items-center justify-content-between">
                  <img src="<?=base_url()."assets_new1/";?>images/player_4.png" class="player_img">
                  <div class="">
                    <div class="text-end mb-2 d-flex justify-content-end align-items-end rating ">
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star" id="star"></i>
                      <i class="fa fa-star-half-empty" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                      <i class="fa fa-star-half-o" id="star"></i>
                    </div>
                    <p class="gry">4.8 (62 reviews)</p>
                  </div>
                </div>
                <div class="palyer_names d-flex justify-content-between">
                  <div class="name">
                    <p class="mb-0 gry">Name</p>
                    <h6 class="">Michael Snyder</h6>
                  </div>
                  <div class="name text-end">
                    <p class="mb-0 gry">Batches</p>
                    <h6 class="">Individual <br> & Group</h6>
                  </div>
                </div>
                <div class="club_name mt-3">
                  <p class="club_info d-flex justify-content-start align-items-center mb-2"><img
                      src="<?=base_url()."assets_new1/";?>images/location.png"> Cumming, Georgia</p>
                  <p class="club_info d-flex justify-content-start align-items-center mb-0 pb-2"><img
                      src="<?=base_url()."assets_new1/";?>images/label.png"> Starting at $10.00/hr</p>
                </div>
              </div>
            </div>

          </div>
          <div class="rated_btn col-lg-12 mt-5">
            <div class="btn_blue text-center">
              <a href="#" class="orange_btn">View All Coaches</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Rated  banner end -->





    <!--Eight banner start -->
    <div class="mx-3 mb-5 mt-5 eight_banner">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="heading text-center pt-5 pb-5">
              <h1>Join a team. Compete in a tournament. <br> Connect to players and coaches. </h1>
            </div>

            <div class="tabs position-relative">
              <div class="tab_btn">
                <button class="filter mixitup-control-active" type="button"
                  data-filter=".category-a">Tournaments</button>
                <button class="filter" type="button" data-filter=".category-b">Players</button>
                <button class="filter" type="button" data-filter=".category-c">Teams</button>
                <button class="filter" type="button" data-filter=".category-d">Clubs</button>
                <button class="filter" type="button" data-filter=".category-e">Coaches</button>
              </div>
              <div class="tab_content">
                <div class="item_1 mix category-a" data-order="1">
                  <div class="row mt-5">
                    <div class="col-lg-10 offset-lg-1">
                      <div class="bg-white p-3">
                        <div class="head d-flex justify-content-between align-items-center">
                          <h4 class="gry mb-0">Filter</h4>
                          <div class="input-group w-30 mb-3 sreach_filter">
                            <button class="btn btn-outline-secondary border-orange bg-orange" type="button"
                              id="button-addon1">Sreach</button>
                            <input type="text" class="form-control" placeholder="Search by Name,City,State"
                              aria-label="Example text with button addon" aria-describedby="button-addon1">
                          </div>
                        </div>
                        <div class="middle d-flex justify-content-between align-items-center">
                          <div class="Filter_middle_box d-flex align-items-center justify-content-start">
                            <p class="mb-0">Tournament Type</p>
                            <ul class="filter">
                              <li class="nav-item dropdown">
                                <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                  aria-expanded="false">All <img src="<?=base_url()."assets_new1/";?>images/downarrow.png"></a>
                                <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="#">Action</a></li>
                                  <li><a class="dropdown-item" href="#">Another action</a></li>
                                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                                  <li>
                                    <hr class="dropdown-divider">
                                  </li>
                                  <li><a class="dropdown-item" href="#">Separated link</a></li>
                                </ul>
                              </li>
                            </ul>
                          </div>
                          <div class="Filter_middle_box align-items-center  d-flex justify-content-start">
                            <p class="mb-0">Tournament Date</p>
                            <ul class="filter">
                              <li class="nav-item dropdown">
                                <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                  aria-expanded="false">This Year <img src="<?=base_url()."assets_new1/";?>images/downarrow.png"></a>
                                <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="#">Action</a></li>
                                  <li><a class="dropdown-item" href="#">Another action</a></li>
                                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                                  <li>
                                    <hr class="dropdown-divider">
                                  </li>
                                  <li><a class="dropdown-item" href="#">Separated link</a></li>
                                </ul>
                              </li>
                            </ul>
                          </div>
                          <div class="Filter_middle_box align-items-center d-flex justify-content-start">
                            <p class="mb-0">Registration Status</p>
                            <ul class="filter">
                              <li class="nav-item dropdown">
                                <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                  aria-expanded="false">Closed <img src="<?=base_url()."assets_new1/";?>images/downarrow.png"></a>
                                <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="#">Action</a></li>
                                  <li><a class="dropdown-item" href="#">Another action</a></li>
                                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                                  <li>
                                    <hr class="dropdown-divider">
                                  </li>
                                  <li><a class="dropdown-item" href="#">Separated link</a></li>
                                </ul>
                              </li>
                            </ul>
                          </div>
                          <div class="Filter_middle_box d-flex align-items-center justify-content-start">
                            <p class="mb-0">Tournament Type</p>
                            <ul class="filter">
                              <li class="nav-item dropdown">
                                <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                  aria-expanded="false"><img src="<?=base_url()."assets_new1/";?>images/country.png" class="mx-0"> <img
                                    src="<?=base_url()."assets_new1/";?>images/downarrow.png"></a>
                                <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="#">Action</a></li>
                                  <li><a class="dropdown-item" href="#">Another action</a></li>
                                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                                  <li>
                                    <hr class="dropdown-divider">
                                  </li>
                                  <li><a class="dropdown-item" href="#">Separated link</a></li>
                                </ul>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="table_content relative">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">Tournment</th>
                                <th scope="col">City</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                                <th scope="col">Contact</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="names_table align-items-center d-flex">
                                    <img src="<?=base_url()."assets_new1/";?>images/tab_1.png">
                                    <p class="mb-0">YONEX Batle of Atlanta</p>
                                  </div>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Atlanta</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Geogia</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">10/07/2017</p>
                                </td>
                                <td>
                                  <p class="mt-3 mb-0">Raj Kosaraju</p>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="sing_up_theme">
                            <div class="text-center text_bottom">
                              <h1 class="text-light mb-5">Sign up for Complete Access</h1>
                              <div class="btn_blue text-center">
                                <a href="#" class="white_btn">Sign Up</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="item_1 mix category-b" data-order="2">
                  <h1>Empty 2</h1>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <!--Eight banner end -->









      <!--Eight banner start -->
      <div class="mx-3 mb-5 d_show">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6">
              <div class="heading text-center pt-5 pb-5">
                <h1>A2M Latest News</h1>
              </div>
              <div class="Latest_newa p-4 ">
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
              <div class="heading text-center pt-5 pb-5">
                <h1>Global News</h1>
              </div>
              <div class="sreach_blue_bg p-4 b-29r">
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
      <div class="bg_nine mt-5 mb-5 m_show">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-10 offset-lg-1">
              <div class="bg-orange b-29r p-5 text-center text-light">
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



      <!--gallery banner start -->
      <div class="gallery pt-5 pb-5 ">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="heading text-center pt-5 pb-5">
                <h1>Gallery</h1>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="galler_img">
                <img src="<?=base_url()."assets_new1/";?>images/g (4).png" class="w-100">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="row">
                <div class="col-6">
                  <img src="<?=base_url()."assets_new1/";?>images/g (2).png" class="w-100 mb-3">
                </div>
                <div class="col-6">
                  <img src="<?=base_url()."assets_new1/";?>images/g (3).png" class="w-100 mb-3">
                </div>
                <div class="col-6">
                  <img src="<?=base_url()."assets_new1/";?>images/g (1).png" class="w-100 mt-2">
                </div>
                <div class="col-6">
                  <img src="<?=base_url()."assets_new1/";?>images/g (5).png" class="w-100 mt-2">
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="gallery_card text-center pt-4 pb-4">
                <img src="<?=base_url()."assets_new1/";?>images/g_logo.png" class="mb-3">
                <h4>Player of the Month</h4>
                <img src="<?=base_url()."assets_new1/";?>images/player_of_the_month.png" class="w-80 player-month mt-2 mb-2">
                <h4 class="mt-3">David Hollifield</h4>
                <p class="club_info d-flex justify-content-center align-items-center mb-2"><img
                    src="<?=base_url()."assets_new1/";?>images/location.png">
                  Cumming, Georgia</p>
                <p class="club_info d-flex justify-content-center align-items-center mb-0 pb-2"><img
                    src="<?=base_url()."assets_new1/";?>images/date.png"> Oct, 2018</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--gallery banner end -->



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
      <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>



      <!-- Option 2: Separate Popper and Bootstrap JS -->
      <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
      <script src="<?=base_url()."assets_new1/";?>js/jquery.min.js"></script>
      <script src="<?=base_url()."assets_new1/";?>js/owl.carousel.js"></script>
      <script>
        $(document).ready(function () {
          var owl = $('#owl-one');
          owl.owlCarousel({
            margin: 50,
            nav: true,
            loop: true,
            responsive: {
              0: {
                items: 1
              },
              600: {
                items: 1
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
          var owl_ = $('#owl-one1');
          owl_.owlCarousel({
            margin: 20,
            nav: true,
            loop: true,
            responsive: {
              0: {
                items: 1
              },
              600: {
                items: 1
              },
              1000: {
                items: 4
              }
            }
          })
        })
      </script>


      <script>
        $(document).ready(function () {
          var owl_ = $('#owl-one2');
          owl_.owlCarousel({
            margin: 20,
            nav: true,
            loop: true,
            responsive: {
              0: {
                items: 1
              },
              600: {
                items: 1
              },
              1000: {
                items: 4
              }
            }
          })
        })
      </script>


      <script>
        $(document).ready(function () {
          var owl_ = $('#owl-one3');
          owl_.owlCarousel({
            margin: 20,
            nav: true,
            loop: true,
            responsive: {
              0: {
                items: 1
              },
              600: {
                items: 1
              },
              1000: {
                items: 4
              }
            }
          })
        })
      </script>



      <script>
        $(document).ready(function () {
          var owl_ = $('#owl-one4');
          owl_.owlCarousel({
            margin: 20,
            nav: true,
            loop: true,
            responsive: {
              0: {
                items: 1
              },
              600: {
                items: 1
              },
              1000: {
                items: 4
              }
            }
          })
        })
        document.addEventListener("DOMContentLoaded", function () {
          // add padding top to show content behind navbar
          navbar_height = document.querySelector('.navbar').offsetHeight;
          document.body.style.paddingTop = navbar_height + 'px';
        });
      </script>
      <script src="<?=base_url()."assets_new1/";?>js/highlight.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
      <script src='https://www.google.com/recaptcha/api.js'></script>
      <script src="https://kit.fontawesome.com/140af656c6.js" crossorigin="anonymous"></script>
      <script src="<?=base_url()."assets_new1/";?>js/slick.min.js"></script>
      <script src="<?=base_url()."assets_new1/";?>js/mixitup.min.js"></script>
      <!-- Option 1: Bootstrap Bundle with Popper -->

      <script src="<?=base_url()."assets_new1/";?>js/app.js"></script>
  </body>

</html>