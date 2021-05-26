<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>A2MSports - Sports Club</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

<meta name="keywords" content="Tennis, club, events, football, golf, non-profit, betting assistant, football, tennis, sport, soccer, goal, sports, volleyball, basketball,	charity, club, cricket, football, hockey, magazine, non profit, rugby, soccer, sport, sports, tennis" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet" type="text/css"/>
<!--<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->

<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,700,600,300' 
rel='stylesheet' type='text/css'/>
<link href='https://fonts.googleapis.com/css?family=Raleway:400,100,300,200,500,600,700,800,900' rel='stylesheet' type='text/css'/>
<link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css' />
<link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

<link href="<?php echo base_url();?>css/fonts/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!--Clients-->
<link href="<?php echo base_url();?>css/own/owl.carousel.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/own/owl.theme.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/jquery.bxslider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.jscrollpane.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/minislide/flexslider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/component.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/prettyPhoto.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/style_dir.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>images/favicon.png" rel="shortcut icon" type="image/png" />
<link href="<?php echo base_url();?>css/responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/animate.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/tabs.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" />

<link href="<?php echo base_url();?>css/grid.css" rel="stylesheet" />
 
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> 
<script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>

<script>
$(document).ready(function(){

	$('#div1').click(function(){
	$('#members').show();	
	});

	$(".adm_settings").click(function(){
		if($(".edit_links").css('display')=="none"){
			$(".edit_links").show();
			$(".show_links").hide();
		} else {
			$(".edit_links").hide();
			$(".show_links").show();
		}
	});
});
</script>

<style>
  #floatingMenuLinks {
	float: right;
	position: fixed;
	top: 150px;
	right: 0px;
	z-index: 150;
}
.floatingMenu {
	margin: 0px 0px 0px 4px;
}
.floatingMenu li {
	list-style: none;
}
.floatingMenu li.last {
}
/* Dropdown Button */
.dropbtn {
   background-color: transparent;
    color: white;
    padding: 12px;
    font-size: 16px;
    border: none;
    cursor: pointer;
	float:right;
	outline:none;
}

/* Dropdown button on hover & focus */
.dropbtn:hover, .dropbtn:focus {
    background-color: transparent;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #ffffff;
    z-index: 1;
	right: 0px;
    top: 43px;
	width:100%;
	text-align:left;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: #212121;
    padding: 12px 8px;
    text-decoration: none;
    display: block;
	border-bottom:1px solid #212121;
	font-size:13px;
	text-transform: uppercase;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {display:block;}

.dropdown{
		display:none
	}

@media (max-width : 767px){

	.dropdown{
		display:block;
		height:38px;
	}
	.show_links {
		display:none
	}
	.accadamyhead {
		padding:5px;
		margin:0px;
	}
}


@media (max-width : 479px) {

{


</style>

</head>
<body>

<section class="container">
	<div class="accadamyhead" align="center">
	<?php
	$act_menu = array();
	$act_menu =	json_decode($act_menu_list[0]->Active_Menu_Ids, true);
	?>
	<div id="icons" class="edit_links" style="display:none">
		<form name='upd_act_menu' method='POST' action='<?php echo base_url(); ?>academy/update_act_menu/<?php echo $org_details['Aca_ID']; ?>'>
		<a id="settings" class="adm_settings" style="cursor:pointer"><img src="<?php echo base_url();?>images/settings_icon.png"  /></a>
		<?php
		foreach($menu_list as $m=>$list) { ?>
		<input class="menu_chkbox" type="checkbox" name="active_menu[]" value="<?php echo $list->Menu_ID; ?>" 
		<?php if(in_array($list->Menu_ID, $act_menu)) { echo "checked='checked'"; }?> />
		<?php echo $list->Menu_Title; ?>
		<?php 
		if(count($menu_list) != ++$m)
		 echo "|";
		} ?>

		<input class="league-form-submit1 menu_chkbox" type="submit" name="sbt_menu_links" id="sbt_menu_links" value="Update" />

		<a href='<?php echo base_url(); ?>login' style="float:right; margin-right:5px">Login</a>
		</form>
	</div>

	<div id="icons" class="show_links">
	<a href='<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>' style="float:left; margin-left:5px; margin-top: -8px;">
	<?php if($org_details['Aca_logo'] != "" and $org_details['Aca_logo'] != NULL){ echo "<img src='".base_url()."org_logos/".$org_details['Aca_logo']."' width=35px height=35px />"; } else{ echo "Home"; } ?></a>
	<?php if($org_details['Aca_User_id'] == $this->session->userdata('users_id')){ ?>
	<a id="settings" class="adm_settings" style="cursor:pointer"><img src="<?php echo base_url();?>images/settings_icon.png"  /></a>
	<?php }
	$menu_ids =	json_decode($act_menu_list[0]->Active_Menu_Ids, true);
	$menu_ids = array_diff($menu_ids, $this->admin_menu_items);

	foreach($menu_ids as $m=>$list){

		$val = base_url().$org_details['Aca_URL_ShortCode']."/";
		switch ($list){
				case 1:
				$val .= "calendar";
				break;
				case 2:
				$val .= "courts/reserve";
				break;
				case 3:
				$val .= "coaches";
				break;
				case 4:
				$val .= "members";
				break;
				case 5:
				$val .= "league";
				break;
				case 6:
				$val .= "opponent";
				break;
				case 7:
				$val .= "events/add";
				break;
				case 8:
				$val .= "courts/list";
				break;
				default:
				echo "";
				}
	?>
	<a href="<?php echo $val;?>"><?php $get_name = $this->model_academy->get_menu_name($list);
	echo $get_name['Menu_Title']; ?></a>
	<?php
	if(count($menu_ids) != ++$m)
	{ echo "|"; }

	}
	?>
	<?php
if($this->session->userdata('user')!="") {?>
<li><a class="lnk-menu <?php 
$get_fname = explode(' ', $this->session->userdata('user'));echo $get_fname[0];?></a></li>
<?php } else { ?>
<li><a class="lnk-menu " href="<?php echo base_url();?>login">Login</a></li>
<?php
}
?>
<a href='<?php echo base_url(); ?>login' style="float:right; margin-right:5px">Login</a>
</div>


<!-- Mobile menu -->
<div class="dropdown">
<a href='<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>' style="float: left; margin-top: -8px;">
	<?php if($org_details['Aca_logo'] != "" and $org_details['Aca_logo'] != NULL){ echo "<img src='".base_url()."org_logos/".$org_details['Aca_logo']."' width=35px height=35px />"; } else{ echo "Home"; } ?></a>
<button onclick="myFunction()" class="dropbtn"><span>&equiv;</span> Menu</button>
	<div id="myDropdown" class="dropdown-content">
	
	<?php if($org_details['Aca_User_id'] == $this->session->userdata('users_id')){ ?>
	<a id="settings" class="adm_settings" style="cursor:pointer"><img src="<?php echo base_url();?>images/settings_icon.png"  /></a>

	
	<?php }
	$menu_ids =	json_decode($act_menu_list[0]->Active_Menu_Ids, true);
	$menu_ids = array_diff($menu_ids, $this->admin_menu_items);

	foreach($menu_ids as $m=>$list){

		$val = base_url().$org_details['Aca_URL_ShortCode']."/";
		switch ($list){
				case 1:
				$val .= "calendar";
				break;
				case 2:
				$val .= "courts/reserve";
				break;
				case 3:
				$val .= "coaches";
				break;
				case 4:
				$val .= "members";
				break;
				case 5:
				$val .= "league";
				break;
				case 6:
				$val .= "opponent";
				break;
				case 7:
				$val .= "events/add";
				break;
				case 8:
				$val .= "courts/list";
				break;
				default:
				echo "";
				}
	?>
	<a href="<?php echo $val;?>"><?php $get_name = $this->model_academy->get_menu_name($list);
	echo $get_name['Menu_Title']; ?></a>
	<?php
	if(count($menu_ids) != ++$m)
	{ echo ""; }

	}
	?>
	
<a href='<?php echo base_url(); ?>login'>Login</a>
</div>
</div>
<!-- Mobile menu end -->
</div>
</section>
<?php 
/*
header("cache-Control: no-store, no-cache, must-revalidate");
header("cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
*/
?>
<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>
<section class="drawer">