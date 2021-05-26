<style type="text/css">

.tab-score{
width:100% !important;
}
.pagination {
margin: 2px 0;
}
.pagepad {
padding-left: 0px;
padding-right: 0px;
padding-top: 8px;
}
.tab-score td:last-child {
font-weight: 400;
}
.tab-content {
padding: 0;
border-radius: 1px;
background: #fff!important; 
}

.tab-content .tab-score thead .sorting_asc {
background-image: url("<?php echo base_url(); ?>js/DataTables-1.10.16/images/sort_asc.png");
}
.tab-content .tab-score thead .sorting {
background-image: url("<?php echo base_url(); ?>js/DataTables-1.10.16/images/sort_both.png");
}
.tab-content .tab-score thead .sorting_desc {
background-image: url("<?php echo base_url(); ?>js/DataTables-1.10.16/images/sort_desc.png");
}
.tab-content .tab-score thead .sorting, .tab-content .tab-score thead .sorting_asc, .tab-content .tab-score thead .sorting_desc, .tab-content .tab-score thead .sorting_asc_disabled, .tab-content .tab-score thead .sorting_desc_disabled {
cursor: pointer;
background-repeat: no-repeat;
background-position: center right;
}

</style>

<script>
$(document).ready(function(){
	 
var baseurl = "<?php echo base_url();?>";
$('.upd_team_name').click(function (e) {

var tm_id = $(this).attr('id');

	  $.ajax({
		type: 'POST',
		url: baseurl+'teams/update_team_name',
		data: $('#frm_team_'+tm_id).serialize(),
		success: function () {
			location.reload();
		}
	  });
	  e.preventDefault();

	});
});
</script>

<script>
$(document).ready(function(){

$(".edit_teamname, .cancel_team_name").click(function(){

var tid = $(this).attr('name');

if($('#edit_team_div'+tid).css('display') == 'none'){
	$('#edit_team_div'+tid).css('display','block');
	$('#dis_tm_'+tid).css('display','none');
}
else{
	$('#edit_team_div'+tid).css('display','none');
	$('#dis_tm_'+tid).css('display','block');
}
//'edit_tm_".$uc->Team_ID."' - visible

});


$(".mteam").click(function(){
	var tid = $(this).attr('id');
	if($('#team_'+tid).css('display') == 'none'){
		$('#team_'+tid).show();
	}
	else{	
		$('#team_'+tid).hide(); 
	}
//$('#team_'+tid).show();

});

/* ------------------------- Collapse and Expand in Participants ---------------------- */
$(".header").click(function() {
    $header = $(this);
    //getting the next element
    $content = $header.next();
    //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
    $content.slideToggle(500, function () {
        //execute this after slideToggle is done
        //change text of header based on visibility of content div
        $header.text(function () {
            //change text based on condition
            //return $content.is(":visible") ? 'Text1' : 'Text2';
        });
    });
});
/* ------------------------- Collapse and Expand in Participants ---------------------- */


var baseurl = "<?php echo base_url();?>";

	$('.upd_players').click(function (e) {
	var tid		  = $(this).attr('id');
	//alert(tid);
	var team_name = $('#frm_manage_team_'+tid).find('input[name="team_name"]').val();
	var formData = new FormData($("#frm_manage_team_"+tid)[0]);
	//var form_data = new FormData($('#frm_manage_team_'+tid)[0]);
	//alert(form_data);
	if(team_name){
		$.ajax({
		type: 'POST',
		url: baseurl+'teams/update',
		data: formData,
        async: false,
	//	data: form_data,
		success: function (res) {
			//alert(res);die();
		   location.reload();
		},
		cache: false,
        contentType: false,
        processData: false
		});
	}
	else{
		alert("Team Name should not empty!");
	}
	e.preventDefault();
	});


	$('.wteam').click(function (e) {
	var tid = $(this).attr('id');
		$.ajax({
		type: 'POST',
		url: baseurl+'teams/withdraw',
		data: {tid:tid},
		success: function(res){
			if(res==1)
			{
				alert('Withdrawn completed!');
			    location.reload();

				/*$('#wr_status').fadeOut();
				$('#wr_status').html('Withdrawn completed!');
				$('#wr_status').fadeIn();*/
			}
		}
		});
	e.preventDefault();
	});

	$('.jteam').click(function (e) {
	var tid = $(this).attr('id');
		$.ajax({
		type: 'POST',
		url: baseurl+'teams/join_req',
		data: {tid:tid},
		success: function(res){
			if(res==1)
			{
				$('#jt_status').fadeOut();
				$('#jt_status').html('A Join notification has been sent to the Captain. Please wait for the response.');
				$('#jt_status').fadeIn();
			}
		}
		});
	e.preventDefault();
	});



$('.btn_register').click(function(){

$tm_id = $(this).attr('id');

var baseurl     = "<?php echo base_url();?>";
var lname	    = $("#txtlname_"+$tm_id).val();
var email	    = $("#txtemail_"+$tm_id).val();
var gender      = $("input[name='gender_"+$tm_id+"']:checked").val();
var zipcode     = $("#zipcode_"+$tm_id).val();
var sportstype	= $("#sportstype_"+$tm_id).val();

if(lname != "" && email != ""){

var fname	= $("#txtfname_"+$tm_id).val();
var phone	= $("#txtphone_"+$tm_id).val();
var mob		= '';

$.ajax({
		type:'POST',
		url:baseurl+'register/instant_register/',
		data:{fname:fname, lname:lname, email:email, phone:phone, gender:gender, Zipcode:zipcode, sportstype:sportstype},
		success:function(res){

			if(res != '0' && res != "User with this email id already exists!"){
			var names = res.split("|");
			
			if(names[2]){
			  mob = names[2].replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
			}
			var op = "<tr><td style='padding-left:20px;'><input type='checkbox' name='sel_team_player[]' class='checkbox1' value='"+names[1]+"' checked='checked' /></td><td style='padding-left:10px'><b><a href='"+baseurl+"player/"+names[1]+"' target='_blank'>"+names[0]+"</a></b></td><td style='padding-left:10px'><b>"+mob+"</b></td></tr>";

			$('#team_table_'+$tm_id).append(op);
			$('#rpform_'+$tm_id).hide();
			$('.reg_players').show();
			}
			else if(res == "User with this email id already exists!"){
				alert('User with this email id already exists!');
			}
			else{
				alert('Something went wrong! Please try again.');
			}
		}
});
}
else {
alert("Last Name & Email should not be empty!");
}

});

	$('.txt_email').blur(function(){
	var baseurl = "<?php echo base_url();?>";
    var email_id = $(this).val();
		$id = $(this).attr('id');
		$id = $id.split('_');
		$tm_id = $id[1];

		if(email_id!=""){
            $.ajax({
                type:'POST',
                url:baseurl+'register/email_check/',
                data:'email_id='+email_id,
                success:function(html){
					var stat = html;
					if(stat!=""){
                    $('#email_stat_'+$tm_id).html(stat);
					$('#txtemail_'+$tm_id).val("");
					}
					else{
					 $('#email_stat_'+$tm_id).html('');	
                    $('#txtemail_'+$tm_id).html("");
					}
                }
            }); 
        }
    });

	$('.reg_player, .btn_register_cancel').click(function(){
		$id = $(this).attr('id');
		$id = $id.split('_');
		$tm_id = $id[1];
		//alert($tm_id);

		if($('#rpform_'+$tm_id).css('display')=='none'){
			$('#rpform_'+$tm_id).show();
			//$('.reg_players').hide();
		}
		else{
			$('#rpform_'+$tm_id).hide();
			//$('.reg_players').show();
		}
	});



});
</script>
<style>
.container2 .header {
    #background-color:#d3d3d3;
    padding: 2px;
    cursor: pointer;
    #font-weight: bold;
}
.container2 .content {
    display: none;
    padding : 5px;
}
</style>

 <section id="single_player" class="container secondary-page">

   <div class="top-score-title right-score col-md-9">
   <div class="col-md-12 league-form-bg" style="margin-top:40px;">
		<div class="fromtitle">Create a Team</div>
		<p style="line-height:20px; font-size:13px">If you want to form a new team, go ahead and 
		<?php if($this->session->userdata('user')=="") { ?>
		
		Please <b style="font-size:14px;"><a href='<?php echo base_url()."login"; ?>'>Login</a></b> to create a team.
		<?php } else { ?>
		<b style="font-size:14px;"><a href="<?php echo base_url()."teams/addnew"; ?>">Create a Team</a></b>
		<?php } ?>
		</p><br /> 
	</div>
	<?php 
	if($this->logged_user)
	{ ?>
   <div class="col-md-12 league-form-bg" style="margin-top:40px;">
		<div class="fromtitle">My Teams</div>
		<span id='wr_status' style='display:none;color:red;font-weight:bold;'></span>
		<div class="tab-content table-responsive container2">
		<table class="tab-score">
		<?php
		foreach($user_created as $uc){?>
		<tr>
			<!-- <a href='#'><b><?php //echo $uc->Team_name; ?></b></a> -->
			<td style="padding-left:3px;">
			<?php
			if($uc->Team_Logo){
				$img_team_logo = "<img style='width:45px;height:40px' src='".base_url()."team_logos/cropped/$uc->Team_Logo' alt=''>";
			}
			else{ 
				$img_team_logo = "<img style='width:45px;height:40px' src='".base_url()."team_logos/default_team_logo.png' alt=''>";
			}

			$get_sport = teams::get_sport($uc->Sport);

			echo "<div class='header' id='dis_tm_".$uc->Team_ID."'>$img_team_logo&nbsp;
			<span style='color:#03508c;font-size:13px;font-weight:400;'>"
			.$uc->Team_name."&nbsp;&nbsp;&nbsp;(".$get_sport['Sportname'].")
			</span>
			</div>

			<div class='content'><ul>";

			$team_players = json_decode($uc->Players);

			$data['team_id']	  = $uc->Team_ID;
			$data['team_name']	  = $uc->Team_name;
			$data['team_captain'] = $uc->Captain;
			$data['team_players'] = $team_players;
			$data['team_logo']	  = $uc->Team_Logo;
			$data['Sport']		  = $uc->Sport;

			foreach($team_players as $tp){
				$player		 = teams::get_username($tp);
				if($player['Gender'] == 1){
					$gender = "(M)";
				}
				else if($player['Gender'] == 0){
					$gender = "(F)";
				}

				$captain_ico = '';
				if($uc->Captain == $tp){
					$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";
				}

				echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'>
				<a href='".base_url()."player/".$player['Users_ID']."' target='_blank'>".ucfirst($player['Firstname'])." ".ucfirst($player['Lastname'])."</a> ".$gender."&nbsp;{$captain_ico}</li>";
			}

			echo "</ul></div>";
			/*echo "<div style='position: absolute; left: 298px; top: 56px;'><img src='".base_url()."images/ico-images/Edit.png' id='img-winner' class='edit_teamname' 
			 name='".$uc->Team_ID."' width='30px' height='30px' style='cursor:pointer' />
			</div>";*/
			?>
			<form id='frm_team_<?=$uc->Team_ID;?>' name='frm_team_<?=$uc->Team_ID;?>' method="post">

				<div id="edit_team_div<?=$uc->Team_ID;?>" style="display:none">
				<input type='text' class='form-control' style='width:70%' name='team_name_<?=$uc->Team_ID;?>' value='<?=$uc->Team_name;?>' />
				<input type="hidden" class='form-control' name="team_id" id="team_id_<?=$uc->Team_ID;?>" value="<?=$uc->Team_ID;?>"  />
				<input type="submit" id='<?=$uc->Team_ID;?>' name='upd_tm_name' value=" Update " style="margin-top:10px" class="upd_team_name league-form-submit1" />
				<input type="button" value="Cancel" name="<?=$uc->Team_ID;?>" style="margin-top:10px" class="cancel_team_name league-form-submit1" />
				</div>
			</form>
			</td>

			<!-- <td>
				<div>
				<?php /*$get_captain = teams::get_username($uc->Captain); 
				$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";
				echo "<a href='".base_url()."player/".$get_captain['Users_ID']."' target='_blank'>".ucfirst($get_captain['Firstname'])." ".ucfirst($get_captain['Lastname'])."</a>&nbsp;{$captain_ico}"; */
				?>
				</div>
			</td> -->

			<td style="padding-left:20px;">
				<div>
				<?php
				if($uc->Home_loc_id){
				$team_home_loc = teams::get_home_location($uc->Home_loc_id);

				$map_url = "https://www.google.co.in/maps/place/".$team_home_loc['hcl_address']."+".$team_home_loc['hcl_city']."+".$team_home_loc['hcl_state']."+".
						$team_home_loc['hcl_country'];

				echo "<a href='".$map_url."' title='".$team_home_loc['hcl_address'].", ".$team_home_loc['hcl_city'].", ".$team_home_loc['hcl_state'].", ".$team_home_loc['hcl_country']."' target='_blank'>".$team_home_loc['hcl_title']."</a>";
				}else{
				echo "< None >";
				}
				?>
				</div>
			</td>

			<td><div>&nbsp;<a style="cursor:pointer;" class='mteam' id='<?=$uc->Team_ID;?>'>Manage Team</a></div></td>

		</tr>
		<tr id='team_<?=$uc->Team_ID;?>' style='display:none;'>
		<td colspan='4'>
			<?php echo $this->load->view("teams/view_manage_team", $data); ?>
		</td>
		</tr>
		<?php } ?>  <!-- Close of user created Teams -->

		<?php foreach($user_part as $up){?>
		<tr>
			<td style="padding-left:3px;">
			<?php
			if($up->Team_Logo){
				$img_team_logo = "<img style='width:45px;height:40px' src='".base_url()."team_logos/cropped/$up->Team_Logo' alt=''>";
			}
			else{ 
				$img_team_logo = "<img style='width:45px;height:40px' src='".base_url()."team_logos/default_team_logo.png' alt=''>";
			}
			
			$get_sport = teams::get_sport($up->Sport);

			echo "<div class='header'>$img_team_logo&nbsp;<span style='color:#03508c;font-size:13px;font-weight:400;'>".$up->Team_name."&nbsp;&nbsp;&nbsp;(".$get_sport['Sportname'].")</span></div><div class='content'><ul>";

			$team_players = json_decode($up->Players);

			$data['team_id']	  = $up->Team_ID;
			$data['team_captain'] = $up->Captain;
			$data['team_players'] = $team_players;
			$data['Sport']        = $up->Sport;

			foreach($team_players as $tp){
				$player		 = teams::get_username($tp);
				if($player['Gender'] == 1){
					$gender = "(M)";
				}
				else if($player['Gender'] == 0){
					$gender = "(F)";
				}

				$captain_ico = '';
				if($up->Captain == $tp){
					$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";
				}
				
				echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'>
				<a href='".base_url()."player/".$player['Users_ID']."' target='_blank'>".ucfirst($player['Firstname'])." ".ucfirst($player['Lastname'])."</a> ".$gender."&nbsp;{$captain_ico}</li>";
			}

			echo "</ul></div>";
			?>
			</td>

			<!-- <td>
				<div>
				<?php
				/*$get_captain = teams::get_username($up->Captain);
				$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";

				echo "<a href='".base_url()."player/".$get_captain['Users_ID']."' target='_blank'>".ucfirst($get_captain['Firstname'])." ".ucfirst($get_captain['Lastname'])."</a>&nbsp;{$captain_ico}"; */
				?>
				</div>
			</td> -->

			<td style="padding-left:20px;">
				<div>
				<?php
				if($up->Home_loc_id){
				$team_home_loc = teams::get_home_location($up->Home_loc_id);

				$map_url = "https://www.google.co.in/maps/place/".$team_home_loc['hcl_address']."+".$team_home_loc['hcl_city']."+".$team_home_loc['hcl_state']."+".
						$team_home_loc['hcl_country'];

				echo "<a href='".$map_url."' title='".$team_home_loc['hcl_address'].", ".$team_home_loc['hcl_city'].", ".$team_home_loc['hcl_state'].", ".$team_home_loc['hcl_country']."' target='_blank'>".$team_home_loc['hcl_title']."</a>";
				}else{
				echo "< None >";
				}
				?>
				</div>
			</td>

			<td><div>&nbsp;<a style="cursor:pointer;" class='wteam' id='<?=$up->Team_ID;?>'>Withdraw</a></div></td>

		</tr>
		<tr id='team_<?=$up->Team_ID;?>' style='display:none;'>
		<td colspan='4'>
			<?php echo $this->load->view("teams/view_manage_team", $data); ?>
		</td>
		</tr>
		<?php } ?>	<!-- Close of User Part in Teams -->

		</table>
		</div>
   </div>
<?php } ?>
   <!-- <div class="col-md-12 league-form-bg" style="margin-top:40px;">
		<div class="fromtitle">Create a Team</div>
		<?php //$this->load->view('teams/view_new_team'); ?>
   </div> --> 

	<?php 
	if($this->logged_user)
	{ ?>

   <div class="col-md-12 league-form-bg" style="margin-top:40px;">
		<div class="fromtitle">Nearby Teams</div>
		<span id='jt_status' style='display:none;color:red;font-weight:bold;'></span>
		<div class="tab-content table-responsive container2">
		<table class="tab-score" id="nearby_teams">
		<thead>
			<tr class="top-scrore-table">
				<td class="col-md-5 score-position">Team</td>
				<td class="score-position">Sport</td>
				<td class="score-position">City</td>
				<td class="score-position">State</td>
				<td class="score-position"></td>
  			</tr>
		</thead>
		<?php
		foreach($user_non_part as $unp){?>
			<tr>
			<td style="padding-left:3px;">
			<?php
			if($unp->Team_Logo){
				$img_team_logo = "<img style='width:45px;height:40px' src='".base_url()."team_logos/cropped/$unp->Team_Logo' alt=''>";
			}
			else{ 
				$img_team_logo = "<img style='width:45px;height:40px' src='".base_url()."team_logos/default_team_logo.png' alt=''>";
			} 

			$get_sport = teams::get_sport($unp->Sport);

			echo "<div class='header'>$img_team_logo&nbsp;<span style='color:#03508c;font-size:13px;font-weight:400;'>".$unp->Team_name."&nbsp;</span></div><div class='content'><ul>";

			$team_players = json_decode($unp->Players);

			$data['team_id']	  = $unp->Team_ID;
			$data['team_captain'] = $unp->Captain;
			$data['team_players'] = $team_players;
			$data['Sport']        = $unp->Sport;

			foreach($team_players as $tp){
				$player		 = teams::get_username($tp);
				if($player['Gender'] == 1){
					$gender = "(M)";
				}
				else if($player['Gender'] == 0){
					$gender = "(F)";
				}

				$captain_ico = '';
				if($unp->Captain == $tp){
					$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";
				}

				echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'>
				<a href='".base_url()."player/".$player['Users_ID']."' target='_blank'>".ucfirst($player['Firstname'])." ".ucfirst($player['Lastname'])."</a> ".$gender."&nbsp;{$captain_ico}</li>";
			}

			echo "</ul></div>";
			?>
			</td>
			<td>
				<div><?=$get_sport['Sportname'];?></div>
			</td>
			<td>
				<div>
				<?php
				if($unp->Home_loc_id){
				$team_home_loc = teams::get_home_location($unp->Home_loc_id);
					echo "&nbsp;".$team_home_loc['hcl_city'];
				}
				else{
					echo "< None >";
				}
				?>
				</div>
			</td>

			<td> 
				<div>
				<?php
				if($unp->Home_loc_id){
				$team_home_loc = teams::get_home_location($unp->Home_loc_id);
					echo "&nbsp;".$team_home_loc['hcl_state'];
				}
				else{
					echo "< None >";
				}
				?>
				</div>
			</td>
			<td style="text-align:center">
				<div><a class='jteam' id='<?=$unp->Team_ID;?>' style="cursor:pointer">JOIN</a></div> 
			</td>
			</tr>
		<?php }
		 ?>
		</table>
   </div>
   </div>
<?php } ?>
<div style='clear:both'></div>
</div><!--Close Top Match-->