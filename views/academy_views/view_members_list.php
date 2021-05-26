 <script>
	$(document).ready(function(){

	var baseurl = "<?php echo base_url();?>";
		
$('#created_by').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url:baseurl+'search/autocomplete',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,
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
		$('#created_users_id').val(names[1]);
	//	$('#phone_code_1').val(names[2]);
		//$('#country_code_1').val(names[3]);
	}		      	
});

//------------------------------------------------------------------------------------------


	});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";
	
	$('#user_sport').on('change',function(){
	
         // var SportID = $(this).val();
		  var SportID  = $( "#user_sport option:selected" ).val();
		
       // if(SportID!=""){
		
            $.ajax({
                type:'POST',
                url:baseurl+'search/Sport_levels/',
                data:'sport_id='+SportID,
                success:function(html){
                    $('#sport_levels_div').html(html);
                }
            }); 
        //}
		
    }); 
});
</script>



<?php //print_r($query); exit; ?>
<section id="single_player" class="container secondary-page"> 

<div class="top-score-title right-score col-md-9">

<?php if($this->session->userdata('user')=="") { ?>

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">

<div class="fromtitle">Search for Members,Matches and Tournaments</div>

				
<p style="line-height:5px; font-size:13px">Please <a href='<?php echo base_url()."login"; ?>'><b>Login</b> </a>to access this Feature.</p>

</div>

<?php } ?>


<?php if($this->session->userdata('user')!="") { ?>	
<div id='Members' class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">

<div class="fromtitle">Search for Members</div>

<form method="post" id="myform"  action="<?php echo base_url(); ?>search/search_user#Members"> 


<div class='col-md-3 form-group internal' style="padding-left:0px">
	<input class='form-control' id='name' name='name' type='text' placeholder="Player Name" value="<?php echo $search_fname; ?>"  size="25" />
</div>

<div class='col-md-2 form-group internal' style="padding-left:0px">
	<?php
	$sport = "";
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

<div id='sport_levels_div' class='col-md-3 form-group internal'>

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

</div>

<div class='col-md-2 form-group internal' style="padding-left:0px">
	<?php
	$range = "";
	if($this->input->post('range'))	{
	$range = $this->input->post('range');
	}
	?>

	<select name="range"  id="range" class='form-control'>
	<option value="" <?php if($range==""){ echo "selected=selected"; } ?>>Distance</option>
	<option value="10" <?php if($range=="10"){ echo "selected=selected"; } ?>>10miles</option>
	<option value="20" <?php if($range=="20"){ echo "selected=selected"; } ?>>20miles</option>
	<option value="30" <?php if($range=="30"){ echo "selected=selected"; } ?>>30miles</option>
	<option value="40" <?php if($range=="40"){ echo "selected=selected"; } ?>>40miles</option>
	<option value="50" <?php if($range=="50"){ echo "selected=selected"; } ?>>50miles</option>
	</select>

</div>


<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input type="submit" name="search_mem" value=" Search " />
</div>

</form>
<div class="clear"></div>

<!-- <p style="padding-top:10px"><a href="#"><u>Advanced Search</u></a></p> -->
<?php
if($this->input->post('search_mem'))
{
?>

<div class="tab-content">
<table class="tab-score">
<?php 
if(count($query) == 0)
{
	?>
<tr>
<td><h5>No Search Members Found.</h5></td>
</tr>
<?php
}
else
{

foreach($query as $row) { ?><!-- img-djoko -->
<tr>
<td>
<a href="#"><img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="150px" height="250px" /></a>
</td>
<td width="90%" style="vertical-align:top;">
&nbsp;&nbsp;<a href="<?php echo base_url();?>player/<?php echo $row->Users_ID;?>"><?php echo $row->Firstname.' '.$row->Lastname; ?></a><br />
&nbsp;


Interested Sports: 

<?php 
$get_data = search::get_details($row->Users_ID);
//print_r($get_data);
$numItems = count($get_data);

$i = 0;

if($numItems > 0)
{
foreach($get_data as $r){

$sport = $r->Sport_id;

switch ($sport) {
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
default:
echo "";
}

if(++$i != $numItems) {
echo ", ";
}

}
}
?>


<br>&nbsp;

Location: 

<?php 
if($row->City != "")
{
echo $row->City.", ".$row->State."<br>&nbsp;"; 
}
if($row->Country != "")
{
$row->Country; 
}
?>


Age Group: 
<?php 
if($row->UserAgegroup != "")
{
echo $row->UserAgegroup; 
}
?>

<br> &nbsp;

A2M Score: 
<?php 
	$get_data = search::get_details($row->Users_ID);			
	 foreach($get_data as $r) { 
		$sport = $r->Sport_id;
		$get_sp_name = search::get_sport($sport);
		$user_id = $row->Users_ID;
		$user_a2mscore = $this->model_members->get_a2msocre($sport,$user_id);
		if($user_a2mscore != ""){
		echo  $get_sp_name['Sportname'] . " - " . $user_a2mscore['A2MScore'] . "" ."<br />";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	 }

?></td>
</tr>

<?php } }?>
</table>
</div>

<?php
} 
?>

</div>

<div>
<br /><br /><br />
</div>
<div class="clear"></div>


<div id='Coaches' class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">

<div class="fromtitle">Search for Coaches</div>

<form method="post" id="myform"  action="<?php echo base_url();?>search/search_coach#Coaches"> 


<div class='col-md-3 form-group internal' style="padding-left:0px">
	<input class='form-control' id='name' name='coach_name' type='text' placeholder="Coach Name" value="<?php echo $coach_name; ?>"  />
</div>

<div class='col-md-3 form-group internal' style="padding-left:0px">
	<?php
	$sport = "";
	if($this->input->post('coach_sport')){
	$sport = $this->input->post('coach_sport');
	}
	?>
	<select name="coach_sport"  id="coach_sport" class='form-control'>
	<option value="">Coach Sport</option>
	<option value="1" <?php if($sport=="1"){ echo "selected=selected"; } ?>>Tennis</option>
	<option value="2" <?php if($sport=="2"){ echo "selected=selected"; } ?>>Table Tennis</option>
	<option value="3" <?php if($sport=="3"){ echo "selected=selected"; } ?>>Badminton</option>
	<option value="4" <?php if($sport=="4"){ echo "selected=selected"; } ?>>Golf</option>
	<option value="5" <?php if($sport=="5"){ echo "selected=selected"; } ?>>Racquetball</option>
	<option value="6" <?php if($sport=="6"){ echo "selected=selected"; } ?>>Squash</option>
	<option value="7" <?php if($sport=="7"){ echo "selected=selected"; } ?>>Pickleball</option>
	</select>
</div>


<div class='col-md-3 form-group internal' style="padding-left:0px">
	<?php
	$range = "";
	if($this->input->post('coach_range')){
	$range = $this->input->post('coach_range');
	}
	?>

	<select name="coach_range"  id="coach_range" class='form-control'>
	<option value="" <?php if($range==""){ echo "selected=selected"; } ?>>Distance</option>
	<option value="10" <?php if($range=="10"){ echo "selected=selected"; } ?>>10Miles</option>
	<option value="20" <?php if($range=="20"){ echo "selected=selected"; } ?>>20Miles</option>
	<option value="30" <?php if($range=="30"){ echo "selected=selected"; } ?>>30Miles</option>
	<option value="40" <?php if($range=="40"){ echo "selected=selected"; } ?>>40Miles</option>
	<option value="50" <?php if($range=="50"){ echo "selected=selected"; } ?>>50Miles</option>
	</select>

</div>


<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input type="submit" name="coach_mem" value=" Search " />
</div>

</form>
<div class="clear"></div>

<!-- <p style="padding-top:10px"><a href="#"><u>Advanced Search</u></a></p> -->
<?php
if($this->input->post('coach_mem'))
{
?>

<div class="tab-content">
<table class="tab-score">
<?php 
if(count($coach_results) == 0)
{
	?>
<tr>
<td><h5>No Coach Members Found.</h5></td>
</tr>
<?php
}
else
{

foreach($coach_results as $row){ ?><!-- img-djoko -->
<tr>
<td>
<a href="#"><img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="150px" height="250px" /></a>
</td>
<td width="90%" style="vertical-align:top;">
&nbsp;&nbsp;<a href="<?php echo base_url();?>player/<?php echo $row->Users_ID;?>"><?php echo $row->Firstname.' '.$row->Lastname; ?></a><br />
&nbsp;

<br>&nbsp;

Location: 

<?php 
if($row->City != "")
{
echo $row->City.", ".$row->State."<br>&nbsp;"; 
}
?>

Profile Description: 

<?php 
if($row->coach_profile != "")
{
echo $row->coach_profile; 
}
?>
<br> &nbsp;

Coach Website: 

<?php
if($row->Coach_Website != ""){
 $check = "http";
$pos = strpos($row->Coach_Website,$check);
if($pos){ ?>
 
 <a target="_blank" href="<?php echo $row->Coach_Website;?>"><?php echo $row->Coach_Website;?></a> 
 
<?php } else { ?>
 <a target="_blank" href="<?php echo "http://".$row->Coach_Website;?>"><?php echo $row->Coach_Website;?></a>  

<?php } 
} ?>

<br> &nbsp;

</td>
</tr>

<?php } }?>
</table>
</div>

<?php
} 
?>
</div>

<?php } ?>

<div class="clear"></div>


<?php if($this->session->userdata('user')!="") { ?>		

<!--//Search for matches section -->
<br />
<div id='Challenge' class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">
<div class="fromtitle">Search for a Challenge</div>

<!--<p style="padding-bottom:10px">Friendly Matches in <b>A2M Sports</b></p> -->

<form method="post" id="myform_match" action="<?php echo base_url(); ?>search/search_matches#Challenge"> 
<!-- <label class='control-label col-md-1' for='id_accomodation' style="padding-left:0px; padding-top:5px">Search:</label> -->
<div class='col-md-3 form-group internal' style="padding-left:0px">
<input class='form-control' id='search_title' name='search_title' type='text' placeholder="Match Title" value="<?php echo $search_title; ?>" size="25" />
</div>
<div class='col-md-3 form-group internal' style="padding-left:0px">
<input class='ui-autocomplete-input form-control' id='created_by' name='created_by' type='text' placeholder="Created By" value="<?php echo $created_by; ?>" size="25" />
<input class='ui-autocomplete-input form-control' id='created_users_id' name='created_users_id' type='hidden' placeholder="user id" value="" size="25" />
</div>


<div class='col-md-2 form-group internal' style="padding-left:0px">
<?php
$sport = "";
if($this->input->post('Sport'))	{
$sport = $this->input->post('Sport');
}
?>
<select name="Sport" class='form-control'>
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

<?php if($this->session->userdata('user')!="") { ?>
<div class='col-md-2 form-group internal' style="padding-left:0px">
<?php
$range = "";
if($this->input->post('range'))	{
$range = $this->input->post('range');
}
?>

<select name="range" class='form-control'>
<option value="" <?php if($range==""){ echo "selected=selected"; } ?>>Distance</option>
<option value="10" <?php if($range=="10"){ echo "selected=selected"; } ?>>10Miles</option>
<option value="20" <?php if($range=="20"){ echo "selected=selected"; } ?>>20Miles</option>
<option value="30" <?php if($range=="30"){ echo "selected=selected"; } ?>>30Miles</option>
<option value="40" <?php if($range=="40"){ echo "selected=selected"; } ?>>40Miles</option>
<option value="50" <?php if($range=="50"){ echo "selected=selected"; } ?>>50Miles</option>
</select>

</div>

<?php } else {

//
}
?>


<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input type="submit" name="search" value=" Search " />
</div>
</form>
<div class="clear"></div>
<!-- <p style="padding-top:10px"><a href="#"><u>Advanced Search</u></a></p> -->
<?php
if($this->input->post('search'))
{
?>
<div class="tab-content">
<table class="tab-score">

<?php 
if(count($matches1) == 0 && count($matches) == 0)
{
	?>
<tr>
<td><h5>No Search Matches Found.</h5></td>
</tr>
<?php
}
else
{
foreach($matches as $row) { ?>
<tr>

<td width="90%" style="vertical-align:top;">
&nbsp;
Match Title:
<a href="<?php echo base_url();?>play/match/<?php echo $row->GeneralMatch_id;?>"><?php echo $row->Match_Title; ?></a><br />
&nbsp;


Created By: 

<?php $get_username = search::get_user($row->users_id); 
echo $get_username['Firstname']." ".$get_username['Lastname']; ?>

<br>&nbsp;

Sport: 

<?php 
$get_sp_name = search::get_sport($row->Sports);
echo $get_sp_name['Sportname'];
?>

<br>&nbsp;

Match Date: 
<?php 
if($row->Match_Date != "")
{

$originalDate = $row->Match_Date;
$newDate = date("M d, Y", strtotime($originalDate));
echo $newDate;

}else
{
  echo "Not At Decided";
}
?>

<br><br> 

</td>
</tr>


<?php } }?>


<?php 
if(count($matches1) == 0 && count($matches) == 0)
{
	?>
<tr>

</tr>
<?php
}
else
{
foreach($matches1 as $row) { ?>
<tr>

<td width="90%" style="vertical-align:top;">
&nbsp;
Match Title:
<a href="<?php echo base_url();?>play/reg_match/<?php echo $row->Play_id;?>"><?php echo $row->Play_Title; ?></a><br />
&nbsp;


Created By: 

<?php $get_username = search::get_user($row->Opponent); 
echo $get_username['Firstname']." ".$get_username['Lastname']; ?>

<br>&nbsp;

Sport: 

<?php 
$get = search::get_sport_name($row->GeneralMatch_ID);

$sport = $get['Sports'];
$get_sport = search::get_sport($sport);
echo $get_sport['Sportname'];
?>


<br>&nbsp;

Match Date: 
<?php 
if($row->Play_Date != "")
{

$originalDate = $row->Play_Date;
$newDate = date("M d, Y", strtotime($originalDate));
echo $newDate;

}else
{
  echo "";
}
?>

<br><br> 

</td>
</tr>

<?php 
	} 
} 
?>

</table>
</div>
<?php
}
?>

</div>
<!--//Search for tournaments section -->

<br /><br /><br />
<div id='Tournaments' class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">
<div class="fromtitle">Search for Tournaments</div>  

  <!-- <p style="padding-bottom:10px"> Tournaments in  <b>A2M sports</b></p> -->
		
<form method="post" id="myform_match" action="<?php echo base_url(); ?>search/search_tournaments#Tournaments"> 
<!-- <label class='control-label col-md-1' for='id_accomodation' style="padding-left:0px; padding-top:5px">Search:</label> -->

<div class='col-md-2 form-group internal' style="padding-left:0px">
<?php
$sport = "";
if($this->input->post('Sport'))	{
$sport = $this->input->post('Sport');
}
?>
<select name="Sport" class='form-control'>
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

<div class='col-md-3 form-group internal' style="padding-left:0px">
<input class='form-control' id='search_title1' name='search_city' type='text' placeholder="City" value="<?php echo $search_city; ?>" size="25" />
</div>

<div class='col-md-3 form-group internal' style="padding-left:0px">
<input class='form-control' id='search_title1' name='search_state' type='text' placeholder="State" value="<?php echo $search_state; ?>" 
size="25" />
</div>

<?php if($this->session->userdata('user')!="") { ?>
<div class='col-md-2 form-group internal' style="padding-left:0px">
<?php
$range = "";
if($this->input->post('range'))	{
$range = $this->input->post('range');
}
?>

<select name="range" class='form-control'>
<option value="" <?php if($range==""){ echo "selected=selected"; } ?>>Distance</option>
<option value="10" <?php if($range=="10"){ echo "selected=selected"; } ?>>10Miles</option>
<option value="20" <?php if($range=="20"){ echo "selected=selected"; } ?>>20Miles</option>
<option value="30" <?php if($range=="30"){ echo "selected=selected"; } ?>>30Miles</option>
<option value="40" <?php if($range=="40"){ echo "selected=selected"; } ?>>40Miles</option>
<option value="50" <?php if($range=="50"){ echo "selected=selected"; } ?>>50Miles</option>
</select>
</div>

<?php } 
else 
{

}
?>


<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input type="submit" name="search_tour" value=" Search " />
</div>
</form>
<div class="clear"></div>
<?php
if($this->input->post('search_tour'))
{
?>

<div class="tab-content">
<table class="tab-score">

<?php 
//print_r($tournaments->result());

foreach($tournaments as $row) { ?>
<tr>

<td width="90%" style="vertical-align:top;">
&nbsp;
Tournament Title:
<a href="<?php echo base_url();?>league/view/<?php echo $row->tournament_ID;?>"><b><?php echo $row->tournament_title ; ?></b></a><br />
&nbsp;


Location: 

<?php echo $row->TournamentCity . " , " . $row->TournamentState ; ?>

<br>&nbsp;

Sport: 

<?php 
$get_sp_name = search::get_sport($row->SportsType);
echo $get_sp_name['Sportname'];
?>


<br>&nbsp;

Start Date: 
<?php 
if($row->StartDate != "")
{

$originalDate = $row->StartDate;
$newDate = date("M d, Y", strtotime($originalDate));
echo $newDate;


}else
{
  echo "";
}
?>

<br><br> 

</td>
</tr>


<?php } ?>


</table>

</div>
<?php
}
?>

</div>

<br /><br />

<?php } ?>
</div>

<!--Close col-md-9-->