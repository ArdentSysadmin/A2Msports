<?php
$club_menu = academy :: get_club_menu($org_details['Aca_ID']);
?>
<script>
var club_baseurl = "<?php echo $this->config->item('club_form_url'); ?>";

$(document).ready(function(){
	 $("#bnr_submit").click(function(){
               var fileUpload = $("#file_bnr");
               var prevFile		 = $('input[name="pre_brn_imgs[]"]:checked').length;
			  // alert(prevFile);
			   var s = parseInt(fileUpload.get(0).files.length) + prevFile;
               if (s > 5){
                  alert("Total of 5 images are allowed!");
				  return false;
               }
     });

	$('#change_club_img').click(function () {
		$('#show-banner-section').hide();
		$('#edit-banner-section').show();
	});

	$('#bnr_cancel').click(function () {
		$('#edit-banner-section').hide();
		$('#show-banner-section').show();
	});

	$('#change_pom').click(function () {
		$('#pom-div').hide();
		$('#edit-pom-section').show();
	});

	$('#cancel-pom').click(function () {
		$('#pom-div').show();
		$('#edit-pom-section').hide();		
	});

	$('#change_home_video').click(function () {
		$('#edit-home-video').show();
		$('#home-video').hide();		
	});
	$('#cancel_hv').click(function () {
		$('#edit-home-video').hide();
		$('#home-video').show();		
	});

// ---------------------------------
	$('#change_ps').click(function () {
		$('.ps_select_chck_imgs').toggle();
	});
	$('#del-ps-cancel').click(function () {
		$('.ps_select_chck_imgs').toggle();
	});
	$('#add_ps').click(function () {
		$('#add-ps-team').show();
		$('#ps-team').hide();
	});
	$('#ps_cancel').click(function () {
		$('#add-ps-team').hide();
		$('#ps-team').show();
	});


	$('#del-ps-imgs').click(function() {
		var academy_id  = "<?php echo $org_details['Aca_ID']; ?>";
		var short_code    = "<?php echo $org_details['Aca_URL_ShortCode']; ?>";
		var count			   = $('.ps_select_chck_imgs'). filter(':checked'). length;
		var sel_ps_imgs  = new Array();

        $( "input[name='sel_ps_imgs[]']:checked" ).each( function() {
                sel_ps_imgs.push( $( this ).val() );
        });

		var all_ps = $('#pre_ps_team').val();

		if(count){
			if(confirm('Are you sure to delete?')){
				$.ajax({
				//url: baseurl+'/'+short_code+'/facility/delete_glry',
				url: club_baseurl+'/facility/delete_ps',
				type: "post",
				data:{sel_ps:sel_ps_imgs, all_ps:all_ps},
				success: function(res) {
					//$('#response').html(data);
					alert('Selected Sponsors are deleted!');
					location.reload();
				}
				});
			}
		}
		else{
			alert('No Image is selected!');
		}
	});

// ----------------------------------
});
</script>
 <script>
	$(document).ready(function(){

	var baseurl = "<?php echo base_url();?>";

	var academy_id = "<?php echo $org_details['Aca_ID']; ?>";
		
$('#txt_ac_pom').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'search/academy_users',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,
			   academy: academy_id,
			   type: 'users',
			   row_num : 1
			},
			 success: function( data ) {
				 response( $.map( data, function( item ) {
				 	var code = item.split("|");
					return {
						label: code[0],
						value: code[0],
						data : item
					}
				}));
			}
  		});
  	},
  	autoFocus: true,	      	
  	minLength: 1,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");						
		$('#txt_ac_pom_id').val(names[1]);
	}		      	
});


	});
</script>
<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$('#pom_add').click(function (e) {

var user = $('#txt_ac_pom_id').val();

	  $.ajax({
		type: 'POST',
		url: baseurl+'academy/update_pom',
		data: $('#frm_academy_pom').serialize(),
		success: function () {
			location.reload();
		}
	  });
	  e.preventDefault();

	});
});
</script>

  <!-- Banner Wrapper Start -->
<?php if($org_details['Home_Layout'] == 'video'){ ?>
    <!-- video template -->
  <div class="container-fluid">
  <div id='edit-home-video' style='display:none;'>
	<form name='frm_hv' id='frm_hv' 
	action="<?=$this->config->item('club_form_url');?>/facility/add_hv" method='POST' enctype='multipart/form-data'>
	<label>Select Home Page Video</label>
	<input type='file'		name='home-page-video' id='home-page-video' accept="video/*" />
	<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
	<input type='submit'  name='upload_hv'			id='upload_hv' value='Upload' />
	<input type='button'  name='cancel_hv'			id='cancel_hv' value='Cancel' />
	</form>
  </div>
  <div class="" id='home-video'>
  	<!-- edit icon -->
	<?php if($this->is_club_admin){ ?>
		<div class="facility-edit-icon" style="right:25px;top:85px">
             <a style="color:#000; cursor:pointer;" id='change_home_video'><i class="fa fa-pencil" aria-hidden="true"></i></a>
        </div>
	<?php } ?>
	<!-- edit icon end -->
	<div>
	<?php
$home_video = base_url()."assets/club_facility/".$org_details['Aca_ID']."/home_video/".$facility_details['Home_Video'];
	?>
		<video width="100%" frameborder="0" allowfullscreen autoplay muted loop>
		  <source src="<?=$home_video;?>" type="video/mp4">
		  Your browser does not support the video tag.
		</video>
	</div>
  </div>
</div>
  <!-- video template -->
<?php
}
else{
?>
  <div class="container-fluid">
  <div class="team-row" style="margin-right: 0px;">
  <div class="col-md-9">
	<div class="row" id='show-banner-section'>
  <div class="banner-wrapper">
    <div id="first-slider" class="">
      <div id="carousel-example-generic" class="carousel slide carousel-fade"> 
        <!-- Indicators 
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        </ol> -->
        <!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
		<!-- edit icon -->
	<?php if($this->is_club_admin){ ?>
		<div class="facility-edit-icon">
             <a style="color:#000; cursor:pointer;" id='change_club_img'><i class="fa fa-pencil" aria-hidden="true"></i></a>
        </div>
	<?php } ?>
<!-- edit icon end -->
		<?php 
		if($facility_details['Banner_Images'] == '' or $facility_details['Banner_Images'] == NULL or $facility_details['Banner_Images'] == 'null') {
			if($org_details['Aca_sport']) {
			$sp = json_decode($org_details['Aca_sport'], true);
			foreach($sp as $sport) {
				switch($sport){
		case 1:
			$sp_img = "tennis_bnr_2.jpg";
			break;
		case 2:
			$sp_img =  "tt_bnr_2.jpg";
			break;
		case 3:
			$sp_img =  "badminton_bnr_2.jpg";
			break;
		case 4:
			$sp_img =  "default_golf.jpg";
			break;
		case 5:
			$sp_img =  "default_racquet_ball.jpg";
			break;
		case 6:
			$sp_img =  "default_squash.jpg";
			break;
		case 7:
			$sp_img =  "pcball_bnr_2.jpg";
			break;
		case 8:
			$sp_img =  "default_chess.jpg";
			break;
		case 9:
			$sp_img =  "default_carroms.jpg";
			break;
		case 10:
			$sp_img =  "default_volleyball.jpg";
			break;
		case 11:
			$sp_img =  "default_fencing.jpg";
			break;
		case 12:
			$sp_img =  "default_bowling.jpg";
			break;
		case 15:
			$sp_img =  "default_throwball.jpg";
			break;
		case 16:
			$sp_img =  "default_cricket.jpg";
			break;
		case 18:
			$sp_img =  "default_basketball1.jpg";
			break;
		default:
			$sp_img =  "No Image";
	}
				$active = '';
			if($org_details['Primary_Sport'] == $sport)
				$active = 'active';
			?>
			  <!-- Item 1 -->
			   <!-- <div class="item slide1 <?php echo $active; ?>" style="background-image: url(<?php echo base_url()."assets/club_pages/images/".$sp_img; ?>);"> -->
			  <div class="item slide1 <?php echo $active; ?>"><img src="<?php echo base_url()."assets/club_pages/images/".$sp_img; ?>" alt="" /></div>
		<?php
			}
		}
			else if($org_details['Primary_Sport']){
$sport = $org_details['Primary_Sport'];

switch($sport){
	case 1:
		$banner_img = 'tennis_bnr_2.jpg';
	break;

	case 2:
		$banner_img = 'tt_bnr_2.jpg';
	break;

	case 3:
		$banner_img = 'badminton_bnr_2.jpg';
	break;

	case 7:
		$banner_img = 'pcball_bnr_2.jpg';
	break;

	default:
		$banner_img = '';
	break;

}
			?>
			 <div class="item slide1 active"><img src="<?php echo base_url()."assets/club_pages/images/".$banner_img; ?>" alt="" /></div>
			<?php
			}
			}
			else{
					$bnr_images = json_decode($facility_details['Banner_Images'], true);
				foreach($bnr_images as $i => $bnrImage){
					$act = ''; 
					if($i == 0) 
						$act = 'active';
				?>
			<div class="item slide1 <?=$act;?>"><img src="<?php echo base_url()."assets/club_facility/".$org_details['Aca_ID']."/banner/".$bnrImage; ?>" alt="" /></div>
				<?php
				$i++;
				}
			}
			?>
        </div>
		
        <!-- End Wrapper for slides--> 
		<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"> 
			<i class="fa fa-angle-left"></i><span class="sr-only">Previous</span></a> 
		<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"> 
		<i class="fa fa-angle-right"></i><span class="sr-only">Next</span></a> 
		</div>
    </div>
  </div>
  <!-- Banner Wrapper End -->
  </div>
  <div class="row text-center" id='edit-banner-section' style='display:none;'>
<div class="single-blog">
<h3>Add Banner Images</h3>

<form name='add_banner_images' method='POST' 
action="<?=$this->config->item('club_form_url');?>/facility/add_banner" enctype='multipart/form-data'>

			<?php //echo "test".$facility_details['Banner_Images']; 
			if($facility_details['Banner_Images']){
			echo "<div><ul>";
					$bnr_images = json_decode($facility_details['Banner_Images'], true);
				foreach($bnr_images as $i => $bnrImage){
					//$split_name = explode('_', $bnrImage);
				?>
			<li><input type='checkbox' name='pre_brn_imgs[]' value='<?=$bnrImage;?>' checked />&nbsp;<?=$bnrImage;?></li>
				<?php
				}
			echo "</ul></div>";
			}
			?>
			<div style="margin:20px" align='center'><input type='file' id='file_bnr' name='bnr_imgs[]' multiple /></div>
			<div><b>Note:</b> To fit the image correctly, please use '1024 x 465' image</div>
			<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
			<!-- <input type='hidden' name='pre_brn_imgs' id='pre_brn_imgs' value='<?php echo $facility_details['Banner_Images']; ?>' /> -->
			<input type='submit' name='bnr_submit' id='bnr_submit' value='  Add  ' style='margin-right:15px;' />
			<input type='button' name='bnr_cancel'  id='bnr_cancel'  value='  Cancel  ' />
		</form>
		</div>
  </div>
 </div><!-- col-md-9 -->

 <div class="col-md-3 player-month">
	<div class="pmonth-text">Player of the Month</div>
<!-- edit icon -->
	<?php if($this->is_club_admin){ ?>
		<div class="pom-edit-icon">
             <a style="color:#000; cursor:pointer;" id='change_pom'><i class="fa fa-pencil" aria-hidden="true"></i></a>
        </div>
	<?php } ?>
<!-- edit icon end -->
	
	<div id='pom-div'>
	<?php if($pom_user){ ?>
	<div><a href="<?=$this->config->item('club_form_url').'/player/'.$pom_user['Users_ID'];?>">
	<?php if($pom_user['Profilepic']){ ?>
	<img src="<?php echo base_url(); ?>profile_pictures/<?php echo $pom_user['Profilepic'];?>"  style="width:175px; height:245px;" alt="">
	<?php } else { ?>
	<img src="<?php echo base_url(); ?>assets/club_pages/images/pm.png" alt="">
	<?php } ?>
	</a></div>
	<div class="pmonth-des">
		<a href="<?=$this->config->item('club_form_url').'/player/'.$pom_user['Users_ID'];?>"><span><?php echo ucfirst($pom_user['Firstname'])." ".ucfirst($pom_user['Lastname']);?></span></a><br>
		<?php if(trim($pom_user['City']) != '' or trim($pom_user['State']) != '') { ?>
		<b>Location:</b> <?php echo trim($pom_user['City']) . ", " . $pom_user['State']; ?><br>
		<?php } ?>
		<b>Member Since:</b> <?php echo date('M, Y',strtotime($pom_user['RegistrationDtTm'])); ?>
	</div>
	<?php } 
	else{ echo "<div>N/A</div>"; }
	?>
	</div>
	<div id='edit-pom-section' style='display:none;'>
	<form id='frm_academy_pom' name='frm_academy_pom' method="post"  role='form'>
			<input type="text"  class='form-control' name="txt_ac_pom" id="txt_ac_pom" style="width: 95%;" value=""  />
			<input type="hidden" class='form-control' name="txt_ac_pom_id" id="txt_ac_pom_id" value=""  />
			<input type="hidden" class='form-control' name="txt_org" id="txt_org" value="<?php echo $org_details['Aca_ID']; ?>"  />
			<input type="button" id='pom_add' value=" Add " style="margin:10px" class="league-form-submit1" />
			<input type="button" id="cancel-pom" value="Cancel" style="margin-top:10px" class="league-form-submit1" />
	</form>
	</div>
	
 </div><!-- col-md-3 -->


  </div>
</div>
<?php
}
  ?>
</header>
<!-- Header End --> 
<?php
$cur_class	 = $this->router->class; 
$aca_pages = $cur_class :: get_onerow('Academy_Pages', 'Aca_ID', $org_details['Aca_ID']);

if(trim($aca_pages['Alert_Message']) != ''){
?>
<div>
<div class="col-md-12" style="padding:20px;"><marquee behavior="scroll" direction="left" scrollamount="10" onMouseOver="this.stop()" onMouseOut="this.start()"><?=$aca_pages['Alert_Message'];?></marquee>
</div>
</div>
<?php
}
?>

<!-- Our Tournaments Wrapper Start -->
<section class="inner-page-wrapper course-list-wrapper tournaments-bg1">
  <div id='events' class="container">
    <div class="title">
      <h2>Tournaments/Events</h2>
      <div><span></span></div>
    </div>
    <div class="row">
		<div class="caltext"><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/events"><!-- <i class="fa fa-calendar" aria-hidden="true"></i> --> More Events</a></div>
 
 <?php 
if(count($club_leagues) == 0)
{
?>
    <div class="col-md-12 col-sm-12">
		 No Events are listed yet!
	</div><!-- col-md-4 -->
<?php
}
else
{
foreach($club_leagues as $row) { 
?>
	<div class="col-md-3 col-sm-6">
	<!-- <div class="text-center col-md-3 col-md-offset-3"> -->
		 <div class="course-item">
			<div class="course-img">
			<a href="<?php echo base_url().$org_details['Aca_URL_ShortCode'].'/league/'.$row->tournament_ID; ?>">
			<img src="<?php echo base_url(); ?>tour_pictures/<?php if($row->TournamentImage!=""){echo $row->TournamentImage; }
			else {
			switch($row->SportsType) {
			case 1:
			echo "default_tennis.jpg";
			break;
			case 2:
			echo "default_table_tennis.jpg";
			break;
			case 3:
			echo "default_badminton.jpg";
			break;
			case 4:
			echo "default_golf.jpg";
			break;
			case 5:
			echo "default_racquet_ball.jpg";
			break;
			case 6:
			echo "default_squash.jpg";
			break;
			case 7:
			echo "default_pickleball.jpg";
			break;
			case 8:
			echo "default_chess.jpg";
			break;
			case 9:
			echo "default_carroms.jpg";
			break;
			case 10:
			echo "default_volleyball.jpg";
			break;
			case 11:
			echo "default_fencing.jpg";
			break;
			case 12:
			echo "default_bowling.jpg";
			break;
			case 18:
			echo "default_basketball1.jpg";
			break;
			default:
			echo "";
			}
			}
			?>" alt="" style="width:261px; height:157px;" />
			</a>
			</div>
			<div class="course-body">
				<div class="course-desc">
					<h4 class="course-title" style='font-size:15px;'><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode'].'/league/'.$row->tournament_ID; ?>"><?php echo $row->tournament_title;?></a></h4>
					  <p><b>Sport:</b> <?php 
						$get_sport = academy::get_sport($row->SportsType);
						echo $get_sport['Sportname'];
						?><br>
						<!-- <b>Registration closed on:</b> <?php //echo date('m/d/Y',strtotime(substr($row->Registrationsclosedon,0,10))); ?><br> -->
						<b>Starts on:</b> <?php echo date('m/d/Y',strtotime(substr($row->StartDate,0,10))); ?><br>
						<b>Location:</b> <?php echo $row->TournamentCity. ',' . $row->TournamentState; ?></p>
				</div>
			</div>
		</div><!-- Tournaments-item -->
	</div><!-- col-md-4 -->

<?php
}
}
?>
 
      
    </div><!-- row -->
  </div>
</section>
<!-- Our Tournaments End -->
<div class="clearfix"></div>

<section class="blog-wrapper" style="background:url(../images/ps-background.png)">

  <div class="container">
    <div class="title">
      <h2>Partners and Sponsors</h2>
      <div><span></span></div>
			<!-- edit icon -->
			<?php if($this->session->userdata('users_id') == $org_details['Aca_User_id']){ ?>
			<div class="ps-edit-icon">
			<a style="color:#000; cursor:pointer;" id='change_ps'>
			<i class="fa fa-pencil" aria-hidden="true"></i></a>
		&nbsp;&nbsp;&nbsp;
		<a style="color:#000; cursor:pointer; font-size:20px;" id='add_ps'>
		<i class="fa fa-plus-circle" aria-hidden="true"></i></a>
			</div>
		<div class="col-md-12 col-sm-12 ps_select_chck_imgs" style='display:none;'>
		<input type='button' name='del-ps-imgs' id='del-ps-imgs' value=' Delete ' />
		<input type='button' name='del-ps-cancel' id='del-ps-cancel' value=' Cancel ' />
		</div>
			<?php } ?>
			<!-- edit icon end -->
    </div>
    <div class="team-row justify-content-center our-gallery-wrapper" id='ps-team' style="background:transparent; padding:0px;">
	<div id="home-gallery" class="owl-carousel">
		<?php
			if($facility_details['Facility_Partner_Sponsors']){
				$ps_team = json_decode($facility_details['Facility_Partner_Sponsors'], true); 
				//echo "<pre>"; print_r($ps_team);  exit;
				foreach($ps_team as $i => $team){
					$ps_img = base_url()."assets/club_pages/images/bod1.jpg";

					if($team['img'])
						$ps_img = base_url()."assets/club_facility/".$org_details['Aca_ID']."/ps_team/".$team['img'];

					$ps_name  = $team['name'];
					$ps_role    = $team['role'];
					$ps_desc  = false;
					if($team['desc'])
					$ps_desc  = $team['desc'];

					if($team['img']){
		?>
			<div class="item text-center">
			<div class="single-blog" style="border:0px;">
			
			<input type='checkbox' class='ps_select_chck_imgs' style="display:none;" name='sel_ps_imgs[]' value='<?=$i;?>' />
			<div style="margin-top:10px;" align='center'>
			<img src="<?=$ps_img; ?>" alt="" style="width:50%; height:auto; border: 1px;">
			</div>
			<div class="blog-content" style="margin-top:10px">	
			<?php if($ps_name) ?>
				<h3 style="font-size:17px; margin-bottom: 2px;"><?=$ps_name;?></h3>
			<?php if($ps_role) ?>
				<b><?=$ps_role; ?></b>
			</div>
			<?php if($ps_desc) ?>
			<p><?=$ps_desc; ?></p>
			</div>
			</div>
		<?php
					}
				}
			}
			else{
		?>
		<div class="col-md-12 col-sm-6 text-center">No Partners and Sponsors are added yet!</div>
		<?php
				}
		?>
		</div>
		</div>

<div class='row justify-content-center' id='add-ps-team' style='display:none;'>
<form name='ps_edit_frm' method='POST' action="<?=$this->config->item('club_form_url');?>/facility/update_ps_team" enctype='multipart/form-data'>

<div class="col-md-3 col-sm-6 text-center">
<div class="single-blog">
<div style="margin-top:10px"><input type='file' name='ps_imgs' /></div>
<div class="blog-content" style="margin-top:10px">
<h3 style="font-size: 17px; margin-bottom: 2px;">
<input type='text' name='ps_name' class="form-control" placeholder="Name (Optional)" value='' /></h3>
<b><input type='text' name='ps_role' class="form-control" placeholder="Role (Optional)" value='' /></b>
</div>
<!-- <p><textarea name='ps_desc[]' cols='25' rows='3' placeholder='Summary'></textarea></p> -->
</div>
</div>

	<div class='col-md-12' style='margin-top:10px;' align='center'>
	<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
	<input type='hidden' name='pre_ps_team' id='pre_ps_team' value='<?php echo $facility_details['Facility_Partner_Sponsors']; ?>' />
	<input type='submit' name='ps_submit' id='ps_submit' value='  Add  ' style='margin-right:15px;'/>
	<input type='button' name='ps_cancel' id='ps_cancel' value='  Cancel  '   />
	</div>
	</form>
</div>


    </div>
  </div>
</section>

<div class="clearfix"></div>


<!-- Our Club Members Start -->
<?php
$sport = $org_details['Primary_Sport'];

switch($sport){
	case 1:
		$banner_img = 'tennis_bnr_2.jpg';
	break;

	case 2:
		$banner_img = 'tt_bnr_2.jpg';
	break;

	case 3:
		$banner_img = 'badminton_bnr_3.jpg';
	break;

	case 7:
		$banner_img = 'pcball_bnr.jpg';
	break;

	default:
		$banner_img = '';
	break;

}

?>

<!-- <div class="content-section-area-about" 
style="background: url(<?php echo base_url();?>assets/club_pages/images/<?=$banner_img; ?>) no-repeat 0 0;">
<div class="about-left-hanf" style='padding: 10px 0px;'>
  <div id='members' class="container">
    <div class="title">
      <h2 style="color:#ffffff;">Club Members</h2>
      <div><span></span></div>
    </div>
    <div class="row">
	<?php
	//foreach($club_members as $member){
	?>
		 <div class="col-md-3 col-sm-6">
			 <div class="course-item">
				<div class="club-img">
				<a href="<?//=$this->config->item('club_form_url').'/player/'.$member['Users_ID'];?>" target='_blank'>
				<?php //if($member['Profilepic']){ ?>
				<img src="<?php //echo base_url(); ?>profile_pictures/<?php //echo $member['Profilepic'];?>" alt="" style='width:182px; height:182px;' class="club-rounded-circle">
				<?php //} else { ?>
				<img src="<?php //echo base_url(); ?>assets/club_pages/images/pm.png" alt="" class="club-rounded-circle">
				<?php //} ?>
				</a>
				</div>
				<div class="course-body" align="center">
					<div class="course-desc" style='min-height:0px;'>
						<h4 class="course-title">
						
							<a href="<?//=$this->config->item('club_form_url').'/player/'.$member['Users_ID'];?>" target='_blank'>
							<?php //echo ucfirst($member['Firstname'])." ".ucfirst($member['Lastname']);?>
							</a>
						</h4>
					</div>
				</div>
			</div>
		</div>
	<?php //} ?>
	  </div>
    </div>
  </div>
</div> -->
<!-- Our Club Members End -->
 
<?php
//if($org_details['Aca_ID'] == 1123 and count($club_testimonials) > 0){
if(count($club_testimonials) > 0){
	//echo "<pre>"; print_r($club_testimonials);
?>
<!-- Testimonials Wrapper Start -->
<!-- <h2 style="color:#000; text-align:center">Testimonials</h2> -->
<div class="testimonials-wrapper">
  <div class="container">
    <div class="title">
      <h2 style="color:#000">Testimonials</h2>
      <div><span></span></div>
    </div>
    <div id="testimonials" class="owl-carousel">
	<?php
	foreach($club_testimonials as $testim) {
	$img_path = base_url()."assets/club_pages/images/pm.png";
	if($testim->user_img){
		$img_path = base_url()."assets/club_facility/".$testim->club_id."/testimonial_users/".$testim->user_img;
	}
	?>
<!-- Testimonial item start -->
      <div class="item">
        <div class="single-testi">
          <div class="testi-img"> <img src="<?=$img_path;?>" alt=""></div>
          <div class="testi-text">
            <p><?=$testim->testimonial;?></p>
			<p style="text-align:right;"><em><?=$testim->user_name;?></em></p>
          </div>
        </div>
      </div>
	  <?php
		}
	  ?>
<!-- Testimonial item end -->
     </div>
  </div>
</div>
<!-- Our Testimonials Wrapper End --> 			
<?php
}
?>

<section class="blog-wrapper">
  <div id='news' class="container">
    <div class="title">
      <h2>Latest News</h2>
      <div><span></span></div>
    </div>
  <div class="row">

<?php if(!empty($results)){
	foreach($results as $row){ 
	$news_date  = date('d', strtotime($row->Modified_on));
	$news_month = date('M', strtotime($row->Modified_on));
	?>    
	  <div class="col-sm-6 col-md-4">
        <div class="single-blog">
          <div class="blog-content">
			<div class="blog-title"> <span><?php echo $news_date; ?> <br><?php echo $news_month; ?></span>
			<h3> <a href="<?=$this->config->item('club_form_url');?>/news/view/<?=$row->News_id;?>"><?php echo $row->News_title; ?></a> </h3>
			</div>
				<p>
				<?php 
				$abc 	= strip_tags($row->News_content);
				$result = substr($abc, 0, strpos($abc, '.'));

				echo $result . "...";
				?>
				</p>
			<a class="read-more" href="<?=$this->config->item('club_form_url');?>/news/view/<?=$row->News_id;?>">Read more <i class="fa fa-long-arrow-right"></i> </a> </div>
        </div>
      </div>
<?php
	}
}
else{
	echo "<div style='text-align:center;'><b>No news content available!</b></div>";
}
?>
  </div>
</section>

<section class="home-about-bg" id='about'>
  <div class="container">
    <div class="title">
      <h2>More Info</h2>
      <div><span></span></div>
    </div>
    <div class="row about-row">
	  <div class="col-md-3">&nbsp;</div>

      <div class="col-md-6">
	  <div class="row">
	  <?php
	  //exit;
	  if(!in_array('3', $club_menu)){ 
	  ?>
			  <div class="col-md-4" style="margin-bottom:20px;">
					<div class="home-about-border">
						<div class="home-about-ico"><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/pricing">
						<img src="<?php echo base_url(); ?>assets/club_pages/images/ico1.png" alt="" /></a></div>
						<h3><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/pricing">Pricing</a> </h3>
					</div>
				</div>
	<?php
	}
	  if(!in_array('8', $club_menu)){ 
	?>
      <div class="col-md-4" style="margin-bottom:20px;">
			<div class="home-about-border">
			<div class="home-about-ico">
			<a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/facility">
			<img src="<?php echo base_url(); ?>assets/club_pages/images/ico2.png" alt=""></a>
			</div>
			<h3><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/facility">About Us</a></h3>
		</div>
      </div>
	<?php
	}
	  if(!in_array('11', $club_menu)){ 
	?>
      <div class="col-md-4" style="margin-bottom:20px;">
        <div class="home-about-border">
			<div class="home-about-ico"><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/proshop">
			<img src="<?php echo base_url(); ?>assets/club_pages/images/ico3.png" alt="" /></a></div>
			<h3><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/proshop">Pro Shop</a> </h3>
		</div>
      </div>
	<?php
	}
	  if(!in_array('9', $club_menu)){ 
	?>

      <div class="col-md-4" style="margin-bottom:20px;">
		<div class="home-about-border">
			<div class="home-about-ico">
			<a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/members">
			<img src="<?php echo base_url(); ?>assets/club_pages/icons/members.png" alt=""></a>
			</div>
			<h3><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/members">Members</a></h3>
		</div>
      </div>
	<?php
	}
	 // if(!in_array('8', $club_menu)){ 
	?>

<div class="col-md-4" style="margin-bottom:20px;">
			<div class="home-about-border">
			<div class="home-about-ico"><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/forms">
			<img src="<?php echo base_url(); ?>assets/club_pages/images/ico6.png" alt=""></a></div>
			<h3><a href="<?php echo base_url().$org_details['Aca_URL_ShortCode']; ?>/forms">Forms</a> </h3>
		</div>
      </div>
	<?php
	//}
	?>


		</div> <!--row  -->
      </div> <!--col-md-6  -->
	<?php
	//}
	 // if(!in_array('8', $club_menu)){ 
	?>
      <!--col-md-2  -->
	<?php
	//}
	//  if(!in_array('11', $club_menu)){ 
	?>
<!--col-md-2  -->
		<div class="col-md-3">&nbsp;</div>
    </div><!-- row -->
	<?php
	//}
	?>

	 <?php
	//  if(!in_array('9', $club_menu)){ 
	?>
 <!--col-md-2  -->
	<?php
	//}
	?>
       <!--col-md-2  -->

      <!-- <div class="col-md-2">
        <div class="home-about-border">
			<div class="home-about-ico"><a href=""><img src="<?php echo base_url(); ?>assets/club_pages/images/ico7.png" alt=""></a></div>
			<h3><a href="#">Blog</a> </h3>
		</div>
      </div> --><!--col-md-2  -->
		<!-- <div class="col-md-3">&nbsp;</div>
    </div> --><!-- row -->


</section>

<link href="<?php echo base_url();?>assets/club_pages/css/about.css" rel="stylesheet" type="text/css"/>
<!-- <script src="<?php echo base_url();?>assets/club_pages/js/custom_ini.js"></script> -->