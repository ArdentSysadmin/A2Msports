<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
        <link rel="stylesheet" href="<?=base_url(); ?>assets_new/css/slick.css">
        <link rel="stylesheet" href="<?=base_url(); ?>assets_new/css/style_tournament.css">
        <link rel="stylesheet" href="<?=base_url(); ?>assets_new/css/responsive.css">

        <title>A2MSports</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </head>

    <body>
    <!-- nav end -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light  justify-content-end">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="<?=base_url(); ?>assets_new/images/logo.png"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav">
          <ul class="navbar-nav mx-4">
			  <li class="nav-item">
                <a class="nav-link" href="#clubFeatures">Club Features</a>
              </li>

			  <li class="nav-item dropdown ml-20">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink_two" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Player Features   <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink_two">
                  <li><a class="dropdown-item" href="<?php echo base_url();?>Addscore"> Add Score </a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>opponent"> Challenge </a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>clubs"> Pay and Play </a></li>
                </ul>
              </li>
			<?php if($this->session->userdata('user') != "") {?>
              <li class="nav-item dropdown ml-20">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink_one" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                 Create <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink_one">
                  <li><a class="dropdown-item" href="<?php echo base_url();?>ladder">Challenge Ladder</a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>events/add">Event</a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>league/bracket_generator">Free Brackets</a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>league">League</a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>teams">Team</a></li>
                  <li><a class="dropdown-item" href="<?php echo base_url();?>league">Tournament</a></li>
                </ul>
              </li>
           <?php } ?>  
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url();?>calendar">Calendar</a>
              </li>

              <li class="nav-item dropdown ml-20 mr-auto">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink_two" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Sports  <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink_two">
                  <li><a class="dropdown-item" href="<?=base_url(); ?>badminton"> Badminton </a></li>
                  <li><a class="dropdown-item" href="<?=base_url(); ?>pickleball"> Pickleball </a></li>
                  <li><a class="dropdown-item" href="<?=base_url(); ?>tt"> Table Tennis </a></li>
                  <li><a class="dropdown-item" href="<?=base_url(); ?>tennis"> Tennis </a></li>
                  <li><a class="dropdown-item" href="<?=base_url(); ?>sports"> More Sports </a></li>
                </ul>
              </li>
                            
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url();?>Search">Search</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url();?>Help">Help</a>
              </li>




<?php if($this->session->userdata('user') != "") {?>
<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink_two" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php 
$get_fname = explode(' ', $this->session->userdata('user'));
echo $get_fname[0];
?>
<i class="fas fa-chevron-down"></i>
                </a>

<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink_two" data-bs-popper="none">

<?php 
$child = $this->session->userdata('child_user_id');
if(!$child) { ?>
<li><a class="dropdown-item" href="<?php echo base_url();?>profile/add_profile"><span align='center'>Add Player</span></a></li> 
<?php } ?>

<li><a class="dropdown-item" href="<?php echo base_url();?>profile"><span align='center'>My Profile</span></a></li>
<li><a class="dropdown-item" href="<?php echo base_url();?>a2mteams"><span align='center'>My Teams</span></a></li>
<li><a class="dropdown-item" href="<?php echo base_url();?>play"><span align='center'>My Sports</span></a></li>

<?php if(isset($logout))
{ ?>
<li><a class="dropdown-item" href="<?php echo $logout;?>"><span align='center'>Logout</span></a></li>
<?php } else {?>
<li><a class="dropdown-item" href="<?php echo base_url();?>logout"><span align='center'>Logout</span></a></li>
<?php } ?>
</ul>

</div>
</div>
</div>
</li>
			  <?php } else { ?>
              <li class="nav-item">
                <!-- Button trigger modal -->
                <button type="button" id="log_btn" class="btn log_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                 Login
                </button>
              </li>
			  <?php } ?>
            </ul>
        </div>
      </div>
      </div>
    </nav>