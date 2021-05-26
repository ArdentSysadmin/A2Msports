<style>
table#club_members_tbl tr button { opacity:0; float:right }
table#club_members_tbl tr:hover button { opacity:1 }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.datetimepicker_new.css"/>

<script>
var path		= "<?php echo base_url(); ?>";
var scode	= "<?php echo $this->short_code; ?>";

$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";

$('.edit_membership').click(function(){
	var temp	 = $(this).attr('id');
	var temp1   = temp.split('_');
	 //alert(temp[1]);
	var id	 = temp1[1];

	$('#'+id).hide();
	$('#details_'+id).hide();
	$('#em_frm_'+id).show();
});

$('.mem_upd_cancel').click(function(){
	var temp	 = $(this).attr('id');
	var temp1   = temp.split('_');
	// alert(temp[1]);
	var id	 = temp1[1];

	$('#'+id).show();
	$('#details_'+id).show();
	$('#em_frm_'+id).hide();
});

$('.upd_mem_det').click(function(){
	var temp	 = $(this).attr('id');
	var temp1   = temp.split('_');
	//alert(temp1[2]);
	var id	 = temp1[2];
	var mem_id	 = $('#mem_id_'+id).val();
	var mem_type = $('#mem_type_'+id).val();

	var mem_freq   = $('#mem_freq_'+id).val();
	var mem_sport = $('#mem_sport_'+id).val();

	var sd  = $('#mem_start_date_'+id).val();
	var ed = $('#mem_end_date_'+id).val();

	if(id){
		$.ajax({
			type: 'POST',
			url:path+scode+'/upd_membership/',
			data: {id:id, mem_id:mem_id, mem_type:mem_type, mem_freq:mem_freq, mem_sport:mem_sport, sd:sd, ed:ed},
			success: function(res) {
				if(res)
					alert("Details are updated successfully!");
				else
					alert("Something went wrong!");
				//location.reload();
			}
		});
	}

});

$('#user_sport').on('change',function(){
// var SportID = $(this).val();
var SportID  = $( "#user_sport option:selected" ).val();

// if(SportID!=""){

$.ajax({
type:'POST',
url:baseurl+'academy/Sport_levels/',
data:'sport_id='+SportID,
success:function(html){
$('#sport_levels_div').html(html);
}
}); 
//}

});


$('.reg_player, .btn_register_cancel').click(function(){
	if($('#rpform').css('display')=='none')
		$('#rpform').show();
	else
		$('#rpform').hide();
});

$('.btn_register222').click(function(){

var baseurl       = "<?php echo base_url();?>";
var lname	      = $("#txtlname").val();
var email	      = $("#txtemail").val();
var zipcode       = $("#zipcode").val();

if(lname != "" && email != "" && zipcode != ""){

		$('#btn_register').prop("disabled", true);
		$('#btn_register').attr('value', 'Please wait...');

		var data2 = new FormData($('#register_form').form);

		$.ajax({
		type:'POST',
		url:baseurl+'register/instant_clubmember/',
		//data: $('#register_form').serialize(),
		data: data2,
			success: function(res) {
				$("#txtfname").val('');
				$("#txtlname").val('');
				$("#txtemail").val('');
				$("#txtphone").val('');
				$("#zipcode").val('');
				$('#rpform').hide();
				$('#btn_register').prop("disabled", false);
				$('#btn_register').attr('value', 'Register');

			}
		});
}
else {
  alert("Last Name, Email & Zipcode should not be empty!");
}

});

$('.txt_email').blur(function(){
	var baseurl = "<?php echo base_url();?>";
    var email_id = $(this).val();
	
		if(email_id!=""){
            $.ajax({
                type:'POST',
                url:baseurl+'register/email_check/',
                data:'email_id='+email_id,
                success:function(html){
					var stat = html;
					if(stat!=""){
                    $('#email_stat').html(stat);
					$('#txtemail').val("");
					}
					else{
					$('#email_stat').html('');	
                    $('#txtemail').html("");
					}
                }
            }); 
        }
    });

});
</script>
<?php
$sport = $org_details['Primary_Sport'];

switch($sport){
	case 1:
		$banner_img = 'tennis_bnr.jpg';
	break;

	case 2:
		$banner_img = 'tt_bnr.jpg';
	break;

	case 3:
		$banner_img = 'badminton_bnr.jpg';
	break;

	case 7:
		$banner_img = 'pcball_bnr.jpg';
	break;

	default:
		$banner_img = '';
	break;

}

?>
<!-- Breadcromb Wrapper Start -->
<div class="breadcromb-wrapper" style="background: rgba(0, 0, 0, 0) url(<?php echo base_url();?>assets/club_pages/images/<?=$banner_img; ?>) no-repeat bottom center / cover;">
  <div class="breadcromb-overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="breadcromb-left">
          <h3>Club Members</h3>
        </div>
      </div>
    </div>
    
  </div>
</div>
<!-- Breadcromb Wrapper End --> 
<section class="inner-page-wrapper">
<div class="container">
<div class="row">
<div class="col-md-9">

<!-- <h3></h3> -->

<!-- Coaches section start-->

<div class="fromtitle">Search for Members</div>
<form method="post" id="coach_form"  action="<?php echo base_url().$org_details['Aca_URL_ShortCode'];?>/search_members"> 

<div class='col-md-3 form-group internal' style="padding-left:0px">
<input class='form-control' id='name' name='name' type='text' placeholder="Player Name" value="<?php echo $search_fname; ?>"  size="25" />
</div>

<div class='col-md-2 form-group internal' style="padding-left:0px">
<?php
/*$get_sport = json_decode($org_details['Aca_sport']);
$sport = $get_sport[0];*/

if($this->input->post('user_sport')){
$sport = $this->input->post('user_sport');
}
?>
<select name="user_sport"  id="user_sport" class='form-control'>
<option value="">Sport</option>
<option value="1" <?php if($sport=="1"){ echo "selected=selected"; } ?>>Tennis</option>
<option value="2" <?php if($sport=="2"){ echo "selected=selected"; } ?>>Table Tennis</option>
<option value="3" <?php if($sport=="3"){ echo "selected=selected"; } ?>>Badminton</option>
<option value="4" <?php if($sport=="4"){ echo "selected=selected"; } ?>>Golf</option>
<option value="5" <?php if($sport=="5"){ echo "selected=selected"; } ?>>Racquetball</option>
<option value="6" <?php if($sport=="6"){ echo "selected=selected"; } ?>>Squash</option>
<option value="7" <?php if($sport=="7"){ echo "selected=selected"; } ?>>Pickleball</option>
</select>

</div>

<!-- <div id='sport_levels_div' class='col-md-3 form-group internal'>
<?php
$sp_level = "";
if($this->input->post('level'))	{
$sp_level = $this->input->post('level');
}
?>
<select name="level" id="level" class='form-control'>
<option value="">Level</option>
<?php foreach($sport_levels as $row){ ?>
<option value="<?php echo $row->SportsLevel_ID;?>" <?php if($sp_level == $row->SportsLevel_ID){ echo "selected=selected"; } ?>>
<?php  echo $row->SportsLevel; ?> 
</option>
<?php } ?>
</select>
</div> -->

<div id='ag_grp_div' class='col-md-3 form-group internal'>
<?php
$sel_ag = "";
if($this->input->post('ag_grp'))	{
$sel_ag = $this->input->post('ag_grp');
}
?>
<select name="ag_grp" id="ag_grp" class='form-control'>
<option value="">Age Group</option>
<?php foreach($ag_grp_list as $i => $row){ ?>
<option value="<?php echo $i;?>" <?php if($sel_ag == $i){ echo "selected=selected"; } ?>>
<?php  echo $row; ?> 
</option>
<?php } ?>
</select>
</div>

<!-- <div class='col-md-2 form-group internal' style="padding-left:0px">
<?php
/*$range = "";
if($this->input->post('range'))	{
$range = $this->input->post('range');
}*/
?>

<select name="range" id="range" class='form-control' style='display:none;'>
<option value="" <?php if($range==""){ echo "selected=selected"; } ?>>Distance</option>
<option value="10" <?php if($range=="10"){ echo "selected=selected"; } ?>>10 mi</option>
<option value="20" <?php if($range=="20"){ echo "selected=selected"; } ?>>20 mi</option>
<option value="30" <?php if($range=="30"){ echo "selected=selected"; } ?>>30 mi</option>
<option value="40" <?php if($range=="40"){ echo "selected=selected"; } ?>>40 mi</option>
<option value="50" <?php if($range=="50"){ echo "selected=selected"; } ?>>50 mi</option>
</select> 
</div> -->

<input class='form-control'  name='org_id' id='org_id' type='hidden' value="<?php echo $org_details['Aca_ID'];?>"  />
<input type="checkbox" id="academy_status"  name="academy_status" style='display:none;' checked  value="1" />


<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input type="submit"  class="league-form-submit1" name="search_mem" value=" Search " />
</div>

</form>
<?php
if($this->session->userdata('users_id') == 240 or $this->session->userdata('users_id') == $org_details['Aca_User_id']){
?>
<div class='col-md-2 form-group internal' style="padding-left:0px">
<input type="button" class="league-form-submit1" name="capture" id="capture" value=" Print " style="float:right;" 
onclick="myWin()" />
</div>

<div class='col-md-12 form-group internal' style="padding-left:0px;">

	Click <b><input type="button" id="rp" value="Register Player" class="reg_player league-form-submit1"></b> 
	If you want to add a new player to your club.

	<div class='form-group' id="rpform" style="display:none">	
	<!-- <form name='register_form' id='register_form'> -->			
	<form name='register_form' id='register_form' method='POST' 
	action='<?=base_url();?>register/instant_clubmember/' enctype='multipart/form-data'>			
		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>First Name </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtfname" name="txt_fname" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Last Name </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtlname" name="txt_lname" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Gender </label>
			<div class='col-md-5 form-group internal'>
			<input type="radio" name="gender" value="1" checked/>&nbsp;Male
			<input type="radio" name="gender" value="0" />&nbsp;Female
			</div>
		</div>


		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Profile Picture </label>
			<div class='col-md-5 form-group internal'>
			<input id="Profilepic" name="Profilepic" style="margin-bottom:28px" type="file"/>
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Email </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtemail" name="txt_email" class='form-control txt_email' />
			<span id='email_stat' style='color:red'></span>
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Phone </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtphone" name="txt_phone" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Zip/Postal Code </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="zipcode" name="Zipcode" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'><b>Membership Details</b></label>
			<div class='col-md-5 form-group internal'>&nbsp;
			</div>
		</div>

		<div class='form-group'>
		<div class='col-md-6 form-group internal'>
		<input type="text" id="membership_id" name="membership_id" class='form-control' placeholder='ID ' style='width:60%' />
		</div>
		<div class='col-md-6 form-group internal'>
		<input type="text" id="membership_type" name="membership_type" class='form-control' placeholder='Type' style='width:60%' />
		</div>
		</div>

		<div class='form-group'>
		<div class='col-md-6 form-group internal'>
		<select id="membership_freq" name="membership_freq" class='form-control' style='width:60%'>
			<option value=''>Frequency</option>
			<option value='daily'>Daily</option>
			<option value='weekly'>Weekly</option>
			<option value='monthly'>Monthly</option>
			<option value='quarterly'>Quarterly</option>
			<option value='anual'>Anual</option>
			<option value='lifetime'>Life-time</option>
		</select>
		</div>
		<div class='col-md-6 form-group internal'>
		<?php
		//$aca_sport = $org_details['Aca_sport'];
		?>
		<!-- <select id='membership_sport' name='membership_sport' class='form-control'  style='width:60%'> -->
		<?php
		/*$sport_html = "<option value=''>Sport</option>";

		foreach($sports_list as $row){ 
			$sport_html .= "<option value='{$row->SportsType_ID}'>{$row->Sportname}</option>";
		}
		echo $sport_html;*/
		?>
		<!-- </select> -->

		<select id='membership_sport' name='membership_sport' class='form-control'  style='width:60%'>
		<option value="">Sport</option>
		<option value="1">Tennis</option>
		<option value="2">Table Tennis</option>
		<option value="3">Badminton</option>
		<option value="4">Golf</option>
		<option value="5">Racquetball</option>
		<option value="6">Squash</option>
		<option value="7">Pickleball</option>
		</select>
		</div>
		</div>

		<div class='form-group'>
		<div class='col-md-6 form-group internal'>
		<input type="text" id="membership_sd" name="membership_sd" class='form-control' placeholder='Start Date' style='width:60%' />
		</div>
		<div class='col-md-6 form-group internal'>
		<input type="text" id="membership_ed" name="membership_ed" class='form-control' placeholder='End Date' style='width:60%' />
		</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'></label>
			<div class='col-md-8 form-group internal'>
			<input type="hidden" value="<?=$org_details['Aca_ID'];?>" name="Aca_ID" id="Aca_ID" />
			<input type="hidden" value="<?=$sport;?>" name="Aca_Sport" id="Aca_Sport" />
			<input type="hidden" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" 
			name="Ret_URL" id="Ret_URL" />
			<input type="submit" id="btn_register" name="btn_register" value=" Register " class="btn_register league-form-submit1" />
			<input type="button" id="cancel" name="btn_register_cancel" value=" Cancel " class="league-form-submit1 btn_register_cancel" />
			</div>
		</div>
		</form>
	</div>

</div>

<?php
}
?>
<script>
function myWin()
{
//var path	= "<?php echo base_url(); ?>";
//var scode	= "<?php echo $this->short_code; ?>";

if($('#name').val()){ var name	= $('#name').val(); } else{ var name = 0; }
if($('#user_sport').val()){ var sport	= $('#user_sport').val(); } else{ var sport = 0; }
if($('#ag_grp').val()){ var ag_grp= $('#ag_grp').val(); } else{ var ag_grp = 0; }
if($('#range').val()){ var range = $('#range').val(); } else{ var range = 0; }
if($('#org_id').val()){ var org_id = $('#org_id').val(); } else{ var org_id = 0; }
var qry_str = '';

window.open(path+scode+'/show_res/'+name+'/'+sport+'/'+ag_grp+'/'+range+'/'+org_id+'/1', null, "height=500, width=800, status=yes, toolbar=no, menubar=no, location=no");
}
</script>

</form>
<!-- <form id="your_form" action="<?php //echo base_url(); ?>league/pdf/<?php //echo $tourn_id; ?>" method="post">
<input type='hidden' name='users[]' value="<?php //print_r($this->input->post('users'));?>">
<input type="submit" class="league-form-submit1" name="capture" id="restore" value="Print" />
</form> -->
<div style='clear:both;'></div>

<!-- -------search -----results --------------- -->

<div class="tab-content">
<table class="tab-score" id="club_members_tbl">
<?php 
//exit;
if(count($query) == 0)
{
?>
<tr>
<td><h5>No Members Found.</h5></td>
</tr>
<?php
}
else
{

foreach($query as $row){ 

if($this->session->userdata('users_id') != $org_details['Aca_User_id'] or !$this->session->userdata('users_id')){
	if($row->Member_Status == 0){
		continue; 
	}
}
?>
<tr>
<td valign='top'>
<a href="#"><img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="150" height="150" style='margin-right:20px;' /></a>
</td>
<td width="90%" valign='top'>
<div class="col-md-8">
<b><h4><a href="<?php echo base_url();?>player/<?php echo $row->Users_ID;?>"><?php echo ucfirst($row->Firstname).' '.ucfirst($row->Lastname); ?></a></h4></b>
</div>

<div class="col-md-4">
<?php
if($this->session->userdata('users_id') == 240 or $this->session->userdata('users_id') == $org_details['Aca_User_id']){
?>
<button class='edit_membership' id='em_<?=$row->Users_ID;?>'> Edit Membership </button>
<?php
}
?>
</div>

<div class="col-md-12" id='details_<?=$row->Users_ID;?>'>
<b>Sports Interests:</b>
<?php
$get_data = academy::get_details($row->Users_ID);
//print_r($get_data);
$numItems = count($get_data);
$i = 0;
if($numItems > 0)
{
foreach($get_data as $r){

$sport = $r->Sport_id;

switch ($sport){
case 1:
echo "Tennis";
break;
case 2:
echo "Table Tennis";
break;
case 3:
echo "Badminton";
break;
case 4:
echo "Golf";
break;
case 5:
echo "RacquetBall";
break;
case 6:
echo "Squash";
break;
case 7:
echo "Pickleball";
break;
case 8:
echo "Chess";
break;
case 9:
echo "Carroms";
break;
case 10:
echo "Volleyball";
break;
case 11:
echo "Fencing";
break;
case 12:
echo "Bowling";
break;
case 13:
echo "Soccer";
break;
case 14:
echo "Lacrosse";
break;
default:
echo "";
}

if(++$i != $numItems) {
echo ", ";
} }	}
?>
<br>

<b>Location: </b>
<?php 
if($row->City != "") {
echo $row->City.", ".$row->State.", "; 
}
if($row->Country != "") {
echo $row->Country; 
}
?>
<br><b>Age Group: </b>
<?php 
if($row->UserAgegroup != "")
{
echo $row->UserAgegroup; 
}
?>
<br>
<b>A2M Score: </b>
<?php 
$get_data = academy::get_details($row->Users_ID);			
foreach($get_data as $r){
if($r->Sport_id == $this->input->post('user_sport') or $this->input->post('user_sport') == ''){
	$sport				= $r->Sport_id;
	$get_sp_name	= academy::get_sport($sport);
	$user_id				= $row->Users_ID;
	$user_a2mscore  = $this->model_academy->get_a2msocre($sport, $user_id);

	if(!empty($user_a2mscore['A2MScore'])){
		echo $get_sp_name['Sportname'] . " - " . $user_a2mscore['A2MScore'] . "" ."; ";
	}
}
}
$get_membership = academy::get_user_membership($org_details['Aca_ID'], $row->Users_ID);			
//echo "<pre>";
//print_r($get_membership);
?>
</div>

<div class='col-md-12' id='em_frm_<?=$row->Users_ID;?>' style='display:none;'>

<div class='col-md-6'>
<input type='text' style='width:75%;' class='form-control' name='mem_id' id='mem_id_<?=$row->Users_ID;?>' 
value='<?php echo $get_membership['Membership_ID'];  ?>' placeholder='ID' />
</div>
<div class='col-md-6'>
<input type='text' style='width:75%;' class='form-control' name='mem_type' id='mem_type_<?=$row->Users_ID;?>' 
value='<?php echo $get_membership['Member_type'];  ?>' placeholder='Type' />
</div>

<div class='col-md-6'>
	<select id="mem_freq_<?=$row->Users_ID;?>" name="mem_freq" class='form-control'  style='width:75%'>
		<option value=''>Frequency</option>
		<option value='daily' <?php if($get_membership['Member_freq'] == 'daily') echo 'selected';  ?>>Daily</option>
		<option value='weekly' <?php if($get_membership['Member_freq'] == 'weekly') echo 'selected';  ?>>Weekly</option>
		<option value='monthly' <?php if($get_membership['Member_freq'] == 'monthly') echo 'selected';  ?>>Monthly</option>
		<option value='quarterly' <?php if($get_membership['Member_freq'] == 'quarterly') echo 'selected';  ?>>Quarterly</option>
		<option value='anual' <?php if($get_membership['Member_freq'] == 'anual') echo 'selected';  ?>>Anual</option>
		<option value='lifetime' <?php if($get_membership['Member_freq'] == 'lifetime') echo 'selected';  ?>>Life-time</option>
	</select>
</div>
<div class='col-md-6'>
	<select id="mem_sport_<?=$row->Users_ID;?>" name="mem_sport" class='form-control'  style='width:75%'>
		<option value=''>Sport</option>
		<option value="1" <?php if($get_membership['Related_sport']=="1"){ echo "selected=selected"; } ?>>Tennis</option>
		<option value="2" <?php if($get_membership['Related_sport']=="2"){ echo "selected=selected"; } ?>>Table Tennis</option>
		<option value="3" <?php if($get_membership['Related_sport']=="3"){ echo "selected=selected"; } ?>>Badminton</option>
		<option value="4" <?php if($get_membership['Related_sport']=="4"){ echo "selected=selected"; } ?>>Golf</option>
		<option value="5" <?php if($get_membership['Related_sport']=="5"){ echo "selected=selected"; } ?>>Racquetball</option>
		<option value="6" <?php if($get_membership['Related_sport']=="6"){ echo "selected=selected"; } ?>>Squash</option>
		<option value="7" <?php if($get_membership['Related_sport']=="7"){ echo "selected=selected"; } ?>>Pickleball</option>
	</select>
</div>

<div class='col-md-6'>
<input type='text' style='width:75%;' class='date-field form-control' name='mem_start_date' id='mem_start_date_<?=$row->Users_ID;?>' 
value='<?php if($get_membership['StartDate']){ echo date('m/d/Y', strtotime($get_membership['StartDate'])); } ?>' 
placeholder='Start Date' />
</div>
<div class='col-md-6'>
<input type='text' style='width:75%;' class='date-field form-control' name='mem_end_date' id='mem_end_date_<?=$row->Users_ID;?>' 
value='<?php if($get_membership['EndDate']){ echo date('m/d/Y', strtotime($get_membership['EndDate'])); } ?>' 
placeholder='End Date' />
</div>

<input type='button' class='btn submit-btn upd_mem_det' name='mem_upd' id='mem_upd_<?=$row->Users_ID;?>' value=' Update ' />
&nbsp;&nbsp;
<input type='button' class='mem_upd_cancel' id='cancel_<?=$row->Users_ID;?>' value=' Cancel ' />
</div>

</td>
</tr>
<tr><td colspan='2'><hr /></td></tr>

<?php } }?>
</table>
</div>
</div>
<!-- </div>
</div> -->
<!-- <table id='test' border='1'>
<tr>
<th>sno</th>
<th>name</th>
</tr>
<tr>
<td>1</td><td>2</td>
</tr>
<tr>
<td>3</td><td>4</td>
</tr>
</table> -->
<script>
    $(document).ready(function () {
        //$('#club_members_tbl').DataTable();
		$('.date-field').datetimepicker({ format: 'm/d/Y', pickTime: false });
		$('#membership_sd').datetimepicker({ format: 'm/d/Y', pickTime: false });
		$('#membership_ed').datetimepicker({ format: 'm/d/Y', pickTime: false });
    });
</script>