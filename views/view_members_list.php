<style type="text/css">
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


<script type="text/javascript">
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";
		
$('#loc_city, #ch_loc_city, #search_city').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url:baseurl+'search/autocomplete/city',
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
		$('#loc_city_id').val(names[1]);
	//	$('#phone_code_1').val(names[2]);
		//$('#country_code_1').val(names[3]);
	}		      	
});

//------------------------------------------------------------------------------------------

$('#loc_state, #ch_loc_state, #search_state').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url:baseurl+'search/autocomplete/state',
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
		$('#loc_state_id').val(names[1]);
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
<!-- Google AdSense -->
<div id='google' align='left'>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
style="display:block"
data-ad-client="ca-pub-9772177305981687"
data-ad-slot="1273487212"
data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<!-- Google AdSense -->
<!-- <?php if($this->session->userdata('user')=="") { ?>

<div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">
<div class="fromtitle">Search for Players, Matches and Tournaments</div>
				
<p style="line-height:5px; font-size:13px">Please <a href='<?php echo base_url()."login"; ?>'><b>Login</b> </a>to access this Feature.</p>
</div>

<?php } ?> -->


<div id='Members' class="col-md-12 league-form-bg" style="margin-top:20px; background:#fff; margin-bottom:20px">
<div class="fromtitle">Search Local Players (by Name)</div>

<form method="post" id="myform"  action="<?php echo base_url(); ?>search/search_user#Members"> 

<div class='col-md-3 form-group internal' style="padding-left:0px">
	<input class='form-control' id='name' name='name' type='text' placeholder="Player Name" value="<?php echo $search_fname; ?>"  size="25" minlength="3" oninvalid="this.setCustomValidity('Please enter minimum of 3 letters to search')" oninput="setCustomValidity('')" required />
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

<div class="tab-content table-responsive">
<table id="searchbyname" class="table tab-score">
<thead>
<tr class="top-scrore-table">
<td class="score-position">Profile Pic</td>
<td class="score-position">Name</td>
<td class="score-position">Sports Interests</td>
<td class="score-position">Location</td>
<td class="score-position">Age Group</td>
<td class="score-position">A2M Score</td>
</tr>
</thead>
<tbody>
<?php 
if(count($query) == 0)
{
	?>
<tr>
<td colspan='6'><h5>No Players Found.</h5></td>
</tr>
<?php
}
else
{
foreach($query as $row) { ?><!-- img-djoko -->
<tr>
<td>
<a target="_blank" href="<?php echo base_url();?>player/<?php echo $row->Users_ID;?>">
<img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="160px" height="100px" />
</a>
</td>
<td>
<a target="_blank" href="<?php echo base_url();?>player/<?php echo $row->Users_ID;?>">
<?php echo $row->Firstname.' '.$row->Lastname; ?>
</a>
</td>
<td>
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
</td>
<td>
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
</td>
<td>
<?php 
if($row->UserAgegroup != "")
{
echo $row->UserAgegroup; 
}
?>
</td>
<td width="250px">
<?php 
	$get_data = search::get_details($row->Users_ID);			
	 foreach($get_data as $r) { 
		$sport = $r->Sport_id;
		$get_sp_name = search::get_sport($sport);
		$user_id = $row->Users_ID;
		$user_a2mscore = $this->model_members->get_a2msocre($sport,$user_id);
		if($user_a2mscore != ""){
		echo  $get_sp_name['Sportname'] . " - " . $user_a2mscore['A2MScore'] . "" ."<br />";
		
		}
	 }

?></td>
</tr>
<?php } }?>
</tbody>
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

<!-- ---------------------Search Users by Location ------------------------------------- -->

<div id='MembersLoc' class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">
<div class="fromtitle">Search for Players (by Location)</div>

<form method="post" id="myform"  action="<?php echo base_url(); ?>search/search_user#MembersLoc"> 

<div class='col-md-3 form-group internal' style="padding-left:0px">
	<input class='form-control' id='name' name='name' type='text' placeholder="Player Name" value="<?php echo $search_uname; ?>"  size="25" minlength="3" oninvalid="this.setCustomValidity('Please enter minimum of 3 letters to search')" oninput="setCustomValidity('')" required />
</div>

<div class='col-md-3 form-group internal' style="padding-left:0px">
	<input class = 'form-control' id = 'loc_city'    name = 'loc_city' type = 'text' placeholder = "City" value = "<?php echo $loc_city; ?>" />
	<input class = 'form-control' id = 'loc_city_id' name = 'loc_city_id' type = 'hidden' value = "<?php echo $search_loc; ?>" size = "25" />
</div>

<div class='col-md-2 form-group internal' style="padding-left:0px">
	<input class = 'form-control' id = 'loc_state' name = 'loc_state' type = 'text' placeholder = "State" value = "<?php echo $loc_state; ?>" /> 
	<input class = 'form-control' id = 'loc_state_id' name = 'loc_state_id' type = 'hidden'	value = "<?php echo $search_loc; ?>" />
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

<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input type = "submit" name = "search_mem_loc" id = "search_mem_loc" value = " Search " />
</div>

</form>
<div class="clear"></div>

<!-- <p style="padding-top:10px"><a href="#"><u>Advanced Search</u></a></p> -->
<?php
if($this->input->post('search_mem_loc'))
{
?>

<div class="tab-content table-responsive">
<table id="searchlocation" class="table tab-score">
<thead>
<tr class="top-scrore-table">
<td class="score-position">Profile Pic</td>
<td class="score-position">Name</td>
<td class="score-position">Sports Interests</td>
<td class="score-position">Location</td>
<td class="score-position">Age Group</td>
<td class="score-position">A2M Rating</td>
</tr>
</thead>
<tbody>
<?php 
if(count($loc_query) == 0)
{
	?>
<tr>
<td colspan='6'><h5>No Players Found.</h5></td>
</tr>
<?php
}
else
{

foreach($loc_query as $row) { ?><!-- img-djoko -->
<tr>
<td>
<a target="_blank" href="<?php echo base_url();?>player/<?php echo $row->Users_ID;?>">
<img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="160px" height="100px" />
</a>
</td>
<td>
<a target="_blank" href="<?php echo base_url();?>player/<?php echo $row->Users_ID;?>">
<?php echo $row->Firstname.' '.$row->Lastname; ?>
</a><br />
</td>
<td>
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

</td>
<td >
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
</td>
<td >

<?php 
if($row->UserAgegroup != "")
{
echo $row->UserAgegroup; 
}
?>
</td>
<td width="250px">
<?php 
	$get_data = search::get_details($row->Users_ID);			
	 foreach($get_data as $r) { 
		$sport = $r->Sport_id;
		$get_sp_name = search::get_sport($sport);
		$user_id = $row->Users_ID;
		$user_a2mscore = $this->model_members->get_a2msocre($sport,$user_id);
		if($user_a2mscore != ""){
		echo  $get_sp_name['Sportname'] . " - " . $user_a2mscore['A2MScore'] . "" ."<br />";
		
		}
	 }

?>
	
</td>
</tr>

<?php } }?>
</tbody>
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


<!-- ---------------------Search for coaches ------------------------------------- -->

<div id='Coaches' class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">

<div class="fromtitle">Search for Coaches</div>

<form method="post" id="myform"  action="<?php echo base_url();?>search/search_coach#Coaches"> 


<div class='col-md-4 form-group internal' style="padding-left:0px">
	<input class='form-control' id='name' name='coach_name' type='text' placeholder="Coach Name" value="<?php echo $coach_name; ?>"  minlength="3" oninvalid="this.setCustomValidity('Please enter minimum of 3 letters to search')" oninput="setCustomValidity('')" required />
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
<div class="tab-content table-responsive">
<table id="searchcoaches" class="table tab-score">
<thead>
<tr class="top-scrore-table">
<td class="score-position"></td>
<td class="score-position">Name</td>
<td class="score-position">Location</td>
<!-- <td class="score-position">Profile Description</td> -->
<td class="score-position">Coach Website</td>
</tr>
</thead>
<tbody>
<?php 
if(count($coach_results) == 0)
{
?>
<tr>
<td colspan='4'><h5>No Coaches Found.</h5></td>
</tr>
<?php
}
else
{
foreach($coach_results as $row){ ?><!-- img-djoko -->
<tr>
<td width="35%">
<a target="_blank" href="<?php echo base_url();?>coach/<?php echo $row->Users_ID;?>">
<img class="scale_image" src="<?php echo base_url(); ?>profile_pictures/<?php if($row->Profilepic!=''){ echo $row->Profilepic; } else { echo "default-profile.png"; } ?>" alt="img" width="160px" height="100px" />
</a>
</td>
<td>
<a target="_blank" href="<?php echo base_url();?>coach/<?php echo $row->Users_ID;?>">
<?php echo $row->Firstname.' '.$row->Lastname; ?>
</a>
</td>
<td>
<?php 
if($row->City != "")
{
echo $row->City.", ".$row->State."<br>&nbsp;"; 
}
?>
</td>
<!--<td>?php 
if($row->coach_profile != "")
{
echo $row->coach_profile; 
}
?></td>-->

<td>
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
</td>
</tr>

<?php } }?>
</tbody>
</table>
</div>
<?php
} 
?>
</div>


<div class="clear"></div>
	

<!--//Search for matches section -->
<br />
<div id='Challenge' class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px">
<div class="fromtitle">Search for a Challenge</div>

<!--<p style="padding-bottom:10px">Friendly Matches in <b>A2M Sports</b></p> -->

<form method="post" id="myform_match" action="<?php echo base_url(); ?>search/search_matches#Challenge"> 
<!-- <label class='control-label col-md-1' for='id_accomodation' style="padding-left:0px; padding-top:5px">Search:</label> -->
<div class='col-md-3 form-group internal' style="padding-left:0px">
<input class = 'form-control' id = 'ch_loc_city'    name = 'ch_loc_city'  type = 'text' placeholder = "City" value = "<?php echo $ch_loc_city; ?>" />
<input class = 'form-control' id = 'ch_loc_city_id' name = 'ch_loc_city_id' type = 'hidden' value = "" size = "25" />
</div>

<div class='col-md-3 form-group internal' style="padding-left:0px">
<input class = 'form-control' id = 'ch_loc_state' name = 'ch_loc_state' type = 'text' placeholder = "State" value = "<?php echo $ch_loc_state; ?>" /> 
<input class = 'form-control' id = 'ch_loc_state_id' name = 'ch_loc_state_id' type = 'hidden' value = "" />
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
<div class="tab-content table-responsive">
<table id="searchchallenge" class="table tab-score">
<thead>
<tr class="top-scrore-table">
<td class="score-position">Match Title</td>
<?php if(count($matches)>0){?>
<td class="score-position">Challenge By</td>
<?php }
 if(count($matches1)>0){?>
<td class="score-position">Created By</td>
<?php }?>
<td class="score-position">Sport</td>
<td class="score-position">Match Date</td>
</tr>
</thead>
<tbody>
<?php 
if(count($matches1) == 0 && count($matches) == 0)
{
?>
<tr>
<td colspan='3'><h5>No Search Matches Found.</h5></td>
</tr>
<?php
}
else
{
foreach($matches as $row) {
?>
<tr>
<td width="35%" >
<a href="<?php echo base_url();?>play/match/<?php echo $row->GeneralMatch_id;?>"><?php echo $row->Match_Title; ?></a>
</td>
<td>
<?php $get_username = search::get_user($row->users_id); 
echo $get_username['Firstname']." ".$get_username['Lastname']; ?>
</td>
<td>
<?php 
$get_sp_name = search::get_sport($row->Sports);
echo $get_sp_name['Sportname'];
?>
</td>
<td>
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
</td>
</tr>
<?php
} 
}

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

<td width="35%">

<a href="<?php echo base_url();?>play/reg_match/<?php echo $row->Play_id;?>"><?php echo $row->Play_Title; ?></a>
</td>
<td>
<?php $get_username = search::get_user($row->Opponent); 
echo $get_username['Firstname']." ".$get_username['Lastname']; ?>
</td>
<td>
<?php 
$get = search::get_sport_name($row->GeneralMatch_ID);

$sport = $get['Sports'];
$get_sport = search::get_sport($sport);
echo $get_sport['Sportname'];
?>
</td>
<td>
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
</td>
</tr>
<?php 
	} 
} 
?>
</tbody>
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
<input class='form-control' id='search_city' name='search_city' type='text' placeholder="City" value="<?php echo $search_city; ?>" size="25" />
<input class='form-control' id='search_city_id' name='search_city_temp' type='hidden' value="" size="25" />
</div>

<div class='col-md-3 form-group internal' style="padding-left:0px">
<input class='form-control' id='search_state' name='search_state' type='text' placeholder="State" value="<?php echo $search_state; ?>" />
<input class='form-control' id='search_state_id' name='search_state_temp' type='hidden' value="" size="25" />
</div>

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



<div id="register-submit" class="col-md-2 form-group internal" style="padding-left:0px">
<input type="submit" name="search_tour" value=" Search " />
</div>
</form>
<div class="clear"></div>
<div class="tab-content table-responsive">
<?php
if($this->input->post('search_tour'))
{
?>
<table id="searchtable" class="table tab-score">
 <thead>
<tr class="top-scrore-table">
<td class="score-position">Tournament Title</td>
<td class="score-position">Location</td>
<td class="score-position">Sport</td>
<td class="score-position">Start Date</td>
</tr>
</thead>
<tbody>
<?php 
//print_r($tournaments->result());
foreach($tournaments as $row) { ?>
<tr>
<td width="35%" style="vertical-align:top;">
<a href="<?php echo base_url();?>league/<?php echo $row->tournament_ID;?>"><b><?php echo $row->tournament_title ; ?></b></a><br />
</td>
<td width="30%" style="vertical-align:top;"> 
<?php echo $row->TournamentCity . " , " . $row->TournamentState ; ?>
</td>
<td width="20%" style="vertical-align:top;">
<?php 
$get_sp_name = search::get_sport($row->SportsType);
echo $get_sp_name['Sportname'];
?>
</td>
<td width="15%" style="vertical-align:top;">
<?php 
if($row->StartDate != "" and $row->StartDate != NULL)
{
$originalDate = $row->StartDate;
$newDate = date('Y/m/d',strtotime($originalDate));
}
?>
<div style="display:none;">
<?php 
echo $newDate; ?> <!-- added for date sorting  -->
</div>
<?php if($originalDate){ echo date('m/d/Y',strtotime($originalDate)); }?>
</td>
</tr>
<?php } ?>
</tbody>
</table>

<?php
}
?>

</div>


<br /><br />


</div>
</div>

<!--Close col-md-9-->