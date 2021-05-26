<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/jquery.accordion.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function (){
$(function (){
"use strict";
$('.accordion').accordion({ defaultOpen: 'section1' }); //some_id section1 in demo
});

$('#form-op-users').on('submit', function (e) {
if ($("input[type=checkbox]:checked").length === 0) {
e.preventDefault();
alert('Select atleast one player to send invite');
return false;
}
});

$('#add_new_venue').on('click', function(){
	$('#new_venue_addr').toggle();
	$('#venue').attr('style','disabled:disabled');

});

});
</script>

<script>
$(document).ready(function(){
    $('#venue_country').on('change', function() {
      if ( this.value == 'United States of America')
      {
        $("#state_drop").show();
		$("#state_box").hide();
      }
      else
      {
        $("#state_drop").hide();
		$("#state_box").show();
      }
    });

/*		----------------------------------------------------	*/

	var baseurl = "<?php echo base_url();?>";
	
	$('#Sport').on('change',function(){
	
        var SportID = $(this).val();
        if(SportID!=""){
		//	alert("hello");
            $.ajax({
                type:'POST',
                url:baseurl+'Opponent/Sport_levels/',
                data:'sport_id='+SportID,
                success:function(html){
                    $('#sport_levels_div').html(html);
					$('#age').focus();
                }
            }); 
        }
		
    }); 


});
</script>

<script>
$(document).ready(function(){

var baseurl = "<?php echo base_url();?>";

$("#academy").autocomplete({
 
	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'Opponent/autocomplete',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,
			   type: 'Academy',
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
  	select: function( event, ui ){
		  var names = ui.item.data.split("|");						
		  $('#org_id').val(names[1]);
		  $('#match_title').focus();
	}		      	
  });

});
</script>

<script>
$(document).ready(function(){
    $("#academy").blur(function(){
		var Aca = $(this).val();

		if(Aca == ""){
			$('#org_id').val("");
		}else
		{
			//--------
		}
  });

});
</script>

<script>
$(document).ready(function(){

$('.ajax_click').click(FilterPlayers)
$('.ajax_blur').blur(FilterPlayers)
$('.ajax_change').change(Change_FilterPlayers)
$('.ajax_mile_change').change(FilterPlayers)

/* Auto complete */
var baseurl = "<?php echo base_url();?>";
$('#p1_partner').autocomplete({
	source: function( request, response ) {
  		$.ajax({
  			url:baseurl+'addscore/autocomplete/',
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
  	autoFocus: false,	      	
  	minLength: 1,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");						
		$('#player1_partner').val(names[1]);
	}		      	
});

/* Auto complete */
});
</script>
<script>

var FilterPlayers = function(){
   
   //alert("hello");
	var baseurl = "<?php echo base_url();?>";

		var SportID = $("#Sport").val();
		
		var Age_group = [];
        $("input[name='age_group[]']:checked").each(function(i){
          Age_group[i] = $(this).val();
        });

		var Level = [];
        $("input[name='level[]']:checked").each(function(i){
          Level[i] = $(this).val() ;
        });
		
		var Gender = $('input[type=radio][name=gend]:checked').val();
		var Miles = $("#range").val();
		
		var Org_ID = $("#org_id").val();

		if(Org_ID == ""){
			$('#org_id').val("");
		}

        if(SportID!=""){
		
            $.ajax({
                type:'POST',
                url:baseurl+'Opponent/LoadUsers/',
				data:{sport_id:SportID,level:Level,age_group:Age_group,gender:Gender,range:Miles,org_id:Org_ID},
                success:function(html){
                    $('#load-users').html(html);
                }
            }); 
        }
  }

var Change_FilterPlayers = function(){
   
   //alert("hello");
	var baseurl = "<?php echo base_url();?>";

		var SportID = $("#Sport").val();
		
		var Age_group = [];
        $("input[name='age_group[]']:checked").each(function(i){
          Age_group[i] = $(this).val();
        });

		var Level = [];
		
		var Gender = $('input[type=radio][name=gend]:checked').val();
		var Miles = $("#range").val();
		
		var Org_ID = $("#org_id").val();

		if(Org_ID == ""){
			$('#org_id').val("");
		}

        if(SportID!=""){
		
            $.ajax({
                type:'POST',
                url:baseurl+'Opponent/LoadUsers/',
				data:{sport_id:SportID,level:Level,age_group:Age_group,gender:Gender,range:Miles,org_id:Org_ID},
                success:function(html){
                    $('#load-users').html(html);
                }
            }); 
        }
  }
</script>

<script>
$(document).ready(function(){

	$('body').on('focus',".datepicker", function(){
    $(this).datepicker();
});

});

</script>

<script type="text/javascript">
    $(document).ready(function(){
		var count = 0;
        $("#add_datetime").click(function(){
			count =count +1;
			
			if(count < 3){

			var hours = "", mins = "",mr = "";

			for(i=1; i<13; i++){
				hh = (i<10) ? '0'+i : i;
				hours += "<option value="+hh+">"+hh+"</option>";
			}

			for(k=0; k<60; (k += 5)){
				mn = (k<10) ? '0'+k : k;
				mins += "<option value="+mn+">"+mn+"</option>";
			}

			mr += "<option value='AM'>AM</option>";
			mr += "<option value='PM'>PM</option>";

          
			$("#club").append("<label class='control-label col-md-4' for='id_title'></label><div class='col-md-3 form-group internal'><input  type='text' class='form-control datepicker' id='sdate"+count+"' name='match_date"+count+"' placeholder='MM/DD/YYYY' /> </div> <div class='col-md-2 form-group internal'><select name='match_time_hr"+count+"' class='form-control'><option value=''>HH</option>"+hours+"</select></div> <div class='col-md-2 form-group internal'><select name='match_time_mm"+count+"' class='form-control'><option value=''>MM</option>"+mins+"</select></div><div class='col-md-2 form-group internal'><select name='match_time_am"+count+"' class='form-control'>"+mr+"</select></div>");
			}
			else
			{
			 alert("Can't add more!");
			 return false;
			}
			
        });
       
    });
</script>

<script>
$(document).ready(function(){   //Doubles

	$('#match_type').on('change',function(){
	
	var MT = $('#match_type').val();
	if(MT == "Doubles")
	{
		$("#partner_show").show();
	}else
	{
		$("#partner_show").hide();
	}
});
});
</script>

<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">

<!-- start main body -->
<div class="col-md-12 league-form-bg" style="margin-top:40px;">
<div class="fromtitle">Challenge</div>
<p style="line-height:20px; font-size:13px">Can't wait till the next tournament? You can "Challenge" other players to play with you. We will reward you everytime you challenge someone with more points towards your A2M Score'. 
<?php if($this->session->userdata('user')=="") { ?>
<br>
Please <a href='<?php echo base_url()."login"; ?>'><b>Login</b> </a>to find players.</p>
<?php } ?>
</div>

<?php if($this->session->userdata('user')!="") { ?>	
<!-- Search Accordian --> 
<!-- <form class='form-horizontal' name='form2' method="post" action='<?php //echo base_url();?>Opponent/search_players'> -->
<!-- Search Accordian -->
	<?php  
	if(isset($users))
	{
	?>

	<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:30px">
	<div class="fromtitle">Create a Challenge</div>

	<form class='form-horizontal' name='form-op-users' id='form-op-users' method="post" action='<?php echo base_url().$this->short_code;?>/opponent/create'>

	<div class='form-group'>
		<label class='control-label col-md-4' for='id_title'>Sport Type</label>
		<div class='col-md-5 form-group internal'>
		<select name="Sport" id="Sport" class='form-control ajax_change' required>
		
		<?php foreach($sport_intrests as $row) { ?>

		<option value="<?php echo $row->Sport_id;?>">
		<?php $sport_name = opponent::get_sport($row->Sport_id);

		echo $sport_name['Sportname'];
		?> 
		</option>
		<?php } ?>
		</select>
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label col-md-4' for='id_accomodation'>Age Group</label>
		<?php
		$age_grp = array();
		if($this->input->post('age_group'))	{
		$age_grp = $this->input->post('age_group');
		}
		?>
		<div class='col-md-6 form-group internal'>
		<input type="checkbox" class="ajax_click" id="age" name="age_group[]" <?php if(in_array("U10", $age_grp)){echo "checked = checked"; } ?> value="U10"> U10 &nbsp;
		<input type="checkbox" class="ajax_click" id="age" name="age_group[]" <?php if(in_array("U12", $age_grp)){echo "checked = checked"; } ?> value="U12"> U12 &nbsp;
		<input type="checkbox" class="ajax_click" id="age" name="age_group[]" <?php if(in_array("U14", $age_grp)){echo "checked = checked"; } ?> value="U14"> U14 &nbsp;
		<input type="checkbox" class="ajax_click" id="age" name="age_group[]" <?php if(in_array("U16", $age_grp)){echo "checked = checked"; } ?> value="U16"> U16 &nbsp;
		<input type="checkbox" class="ajax_click" id="age" name="age_group[]" <?php if(in_array("U18", $age_grp)){echo "checked = checked"; } ?> value="U18"> U18 &nbsp;
		<input type="checkbox" class="ajax_click" id="age" name="age_group[]" <?php if(in_array("Adults", $age_grp)){echo "checked = checked"; } ?> value="Adults"> Adults
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label col-md-4' for='id_accomodation'>Level </label>
		<?php
		$sp_level = array();
		if($this->input->post('level'))	{
		$sp_level = $this->input->post('level');
		}
		?>
		<div id='sport_levels_div' class='col-md-6 form-group internal'>
		<?php foreach($sport_levels as $row){ ?>

		<input type="checkbox" class="ajax_click" name="level[]" <?php if(in_array($row->SportsLevel_ID, $sp_level)){echo "checked = checked"; } ?> value="<?php echo $row->SportsLevel_ID;?>"> <?php echo $row->SportsLevel;?> &nbsp;
	
		<?php } ?>
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label col-md-4' for='id_accomodation'>Gender</label>
		<?php
		$gend = "";
		if($this->input->post('gend'))	{
		$gend = $this->input->post('gend');
		}
		?>
		<div class='col-md-6 form-group internal'>
		<input type="radio" class="ajax_click" name="gend" id="gend" value="M"> Male Only&nbsp;&nbsp;
		<input type="radio" class="ajax_click" name="gend" id="gend" value="F" > Female Only
		<input type="radio" class="ajax_click" name="gend" id="gend" value="all"> Open to All
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label col-md-4' for='id_accomodation'>Near By</label>
		<?php
		$range = "";
		if($this->input->post('range'))	{
		$range = $this->input->post('range');
		}
		?>
		<div class='col-md-2 form-group internal'>
		<select name="range" class="form-control ajax_mile_change" id="range">
		<option value="" <?php if($range==""){ echo "selected=selected"; } ?>>Miles</option>
		<option value="10" <?php if($range=="10"){ echo "selected=selected"; } ?>>10</option>
		<option value="20" <?php if($range=="20"){ echo "selected=selected"; } ?>>20</option>
		<option value="30" <?php if($range=="30"){ echo "selected=selected"; } ?>>30</option>
		<option value="40" <?php if($range=="40"){ echo "selected=selected"; } ?>>40</option>
		<option value="50" <?php if($range=="50"){ echo "selected=selected"; } ?>>50</option>
		</select>
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label col-md-4' for='id_accomodation'>Academy / Club </label>
		<div class='col-md-5 form-group internal'>
		<!-- <input type="text" id="academy_name" name="academy_name" class='form-control ajax_blur'/> -->
		<input id='academy' name="club_name" class='ui-autocomplete-input col-md-3 form-control ajax_blur' type="text" placeholder="Your Club Name" />
		<input class='form-control' id='org_id' name='org_id' type='hidden' placeholder="Org_id" value=""  />
		</div>
	</div>
	

	<div class='form-group'>
		<label class='control-label col-md-4' for='id_accomodation'>Name the match you are creating </label>
		<div class='col-md-5 form-group internal'>
		<input type="text" id="match_title" name="match_title" class='form-control' required />
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label col-md-4' for='id_title'>Match Type </label>
		<div class='col-md-3 form-group internal'>
		<select name="match_type" id="match_type" class='form-control'>
		<option value="Singles">Singles</option>
		<option value="Doubles">Doubles</option>
		</select>
		</div>
	</div> 

	<div class='form-group' id="partner_show" style="display:none">
		<label class='control-label col-md-4' for='id_accomodation'>Partner</label>
		<div class='col-md-5 form-group internal'>
		<input id='p1_partner' name="p1_partner" class='ui-autocomplete-input col-md-3 form-control' type="text" placeholder="Select Partner" />
		<input class='form-control' id='player1_partner' name='player1_partner' type='hidden' value=""  />
		</div>
	</div>
	
	<div class='form-group' id="club">
		<label class='control-label col-md-4' for='id_title'>When do you want to play? </label>
		<div class='col-md-3 form-group internal'>
		<input  type="text" class='form-control datepicker' id=""  name="match_date" placeholder="MM/DD/YYYY"  required/>
		</div>


		<div class='col-md-2 form-group internal'>
		<select name='match_time_hr'  class='form-control'>
			<option value="">HH</option>
			<?php for($j=1; $j<13; $j++){
			$hh = ($j<10) ? "0".$j : $j;
			echo "<option value='$hh'>$hh</option>";
			}?>
		</select>
		</div>
		<div class='col-md-2 form-group internal'>
		<select name='match_time_mm' class='form-control'>
			<option value="">MM</option>
			<?php for($k=0; $k<60; ($k += 5)){
			$mm = ($k<10) ? "0".$k : $k;
			echo "<option value='$mm'>$mm</option>";
			}?>	
		</select>
		</div>
		<div class='col-md-2 form-group internal'>
		<select name='match_time_am'  class='form-control'>
			<option value='AM'>AM</option>
			<option value='PM'>PM</option>
		</select>
		</div>
	</div>

	<!-- <div class="col-md-6" style="text-align:right;margin-left:290px;cursor:pointer;">
		<b><a id="add_datetime">Add More</a></b><br />
	</div> -->
	<div class='form-group'>
		<label class='control-label col-md-4' for='id_title'></label>
		<div class='col-md-5 form-group internal' style="text-align:right;cursor:pointer;">
		<b><a id="add_datetime">Add More</a></b>
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label col-md-4' for='id_title'>Message To Players (Optional)</label>
		<div class='col-md-5 form-group internal'>
		<textarea name="message" class="form-control txt-area" id="message" cols="20" rows="2"></textarea>
		</div>
	</div>

	<script>
	$(document).ready(function(){ 
		$("#sel_all").change(function(){
		  $(".checkbox1").prop('checked', $(this).prop("checked"));
		  });
	});
	</script>
 <div id="load-users">
	<div style="overflow-y:scroll;<?php if($users->num_rows() > 15) { echo "height:350px"; } else if($users->num_rows() == 0){ echo "height:100px"; } ?>">
    
	<table class="tab-score-m">
	<tr>
	<th width="10%" class="score-position"><input type='checkbox' name="sel_all" id="sel_all" />Select</th>
	<th width="22%">Name</th>
	<th width="6%">Gender</th>
	<th width="30%">Location</th>
	<th width="15%">Level</th>
	<th width="11%">A2M Score</th>
	</tr>

	<?php
	if(count(array_filter($users->result())) > 0) {
		foreach($users->result() as $array)
		{
		?>
		<tr>
		<td><input class="checkbox1" type="checkbox" name="sel_player[]" value="<?php echo $array->Users_ID;?>" /></td>
		<td><a href="<?php echo base_url();?>player/<?php echo $array->Users_ID;?>"><?php echo $array->Firstname." ".$array->Lastname;?></a></td>
		<td><?php if($array->Gender == 1) { echo "Male"; } else { echo "Female"; } ?></td>
		<td><?php echo $array->City;?>, <?php echo $array->State; ?></td>
		<td>
		<?php    
		$user_id = $array->Users_ID;
		$sport = 1;
		$get_level = $this->opponent->get_user_sport_level($sport,$user_id);	
		$level = $get_level['Level'];
		$level_name = $this->opponent->get_sport_level_title($level,$sport);
		echo $level_name['SportsLevel'];
		?>
		</td>

		<td align='right'>
		<?php
		$user_a2mscore ="";
		$user_a2mscore = $this->opponent->get_a2msocre($sport,$user_id);
		if(isset($user_a2mscore)){echo $user_a2mscore['A2MScore'];}else{echo "none";}
		?>
		</td>
		</tr>
		<?php
		}
	?>
	<!-- <tr>
	<td colspan="7" align="center"><input type="submit" id="btn_create_match" name="btn_create_match"  value="Create Match" class="league-form-submit" style="margin-bottom:0px"/><!--&nbsp;&nbsp;&nbsp;
	<input type="button" value="Invite Friends" class="league-form-submit" style="margin-bottom:0px"/> 
	</td>
	</tr> -->
	<?php
	}
	else {
	?>
	<tr><td colspan='6'><b>No Players Found. </b></td></tr>
	<?php
	}
	?>
	</table>
	
	</div>
</div>
	<br />
	<div class='form-group'>
		
		<!-- <div class='col-md-8 form-group internal'> -->
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="" name="visible_status"  value="1"> Do you want match to be accessible to only selected players?
		<!-- </div> -->
	</div>
	<br />
	<div class='form-group' align="center">
	<input type="submit" id="btn_create_match" name="btn_create_match"  value="Challenge Player(s)" class="league-form-submit" style="margin-bottom:0px;"/>
	</div>
	</form>
	</div>
	<?php
	}

?>

<?php } ?>
</div>
<!-- end main body -->

</div><!--Close Top Match-->