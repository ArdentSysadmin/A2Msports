<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>

<script type="text/javascript">
$(function () {
	$("input[name='chkPassPort']").click(function () {
		if ($("#chkYes").is(":checked")) {
			$("#dvPassport").show();
		} else {
			$("#dvPassport").hide();
		}
	});
});
</script>

<script type="text/javascript"> 

function listbox_move(listID, direction) {
 
			var listbox = document.getElementById(listID);
			var selIndex = listbox.selectedIndex;
		 
			//document.write(listbox);
			//document.write(selIndex);
			
			if(-1 == selIndex) {
				alert("Please select an player to move.");
				return;
			}
		 
			var increment = -1;
			if(direction == 'up')
				increment = -1;
			else
				increment = 1;
		 
			if((selIndex + increment) < 0 ||
				(selIndex + increment) > (listbox.options.length-1)) {
				return;
			}
		 
			var selValue = listbox.options[selIndex].value;
			var selText = listbox.options[selIndex].text;
			listbox.options[selIndex].value = listbox.options[selIndex + increment].value
			listbox.options[selIndex].text = listbox.options[selIndex + increment].text
		 
			listbox.options[selIndex + increment].value = selValue;
			listbox.options[selIndex + increment].text = selText;
		 
			listbox.selectedIndex = selIndex + increment;
}

	function listbox_selectall(listID, isSelect) {
        var listbox = document.getElementById(listID);
        for(var count=0; count < listbox.options.length; count++) {

			var selIndex = listbox.selectedIndex;
		 
			//document.write(listbox);
			//document.write(selIndex);

            listbox.options[count].selected = isSelect;
		}
	}

</script>

<script>
	/*$(document).ready(function(){
	var baseurl = "<?php echo base_url();?>";

	$('#Age_group, #match_type').on('change',function(){
		
      //  var Agegroup = $(this).val();
        var Agegroup = $('#Age_group').val();
		var Match_type = $('#match_type').val();
		
		var Tourn_id = $('#tourn_id').val();
		
        if(Agegroup!="" && Match_type!=""){
			var Sport_id = $('#sport').val();
            $.ajax({
                type:'POST',
                url:baseurl+'league/age_group_users/',
                data:{age_group:Agegroup, tourn_id:Tourn_id, match_type:Match_type, sport_id:Sport_id},    //{pt:'7',rngstrt:range1, rngfin:range2},
                success:function(html){
                    $('#age_group_users').html(html);
                }
            }); 
        }
     });
	 });*/
</script>


<script>
$(document).ready(function(){
    $('#myform').submit(function(){
	
		var count = $("#a :selected").length;

		var foo = [];
		$('#a :selected').each(function(i, selected){
		foo[i] = $(selected).val();
		});

		var j;
		var part_count = 0;
		for (j = 0; j < foo.length; ++j) {
		  var sp = foo[j].split('-');
		  if(sp[1] == ''){ part_count++; }
			
		}
		//alert(part_count);

       if (count <= 2 ) { 
           alert("Minimum 3 players should be select"); 
			return false;
        }
		else if (part_count > 0){ 
		    alert("Some of the selected players having no partners. please recheck!"); 
			return false;
		}
	    else { return true; }
    });
});
</script>

<script>
$(document).ready(function(){

$('.ajax_blur').click(FilterPlayers)
});

</script>

<script>
$(document).ready(function(){

$('.ajax_blur').change(FilterPlayers)
});

</script>


<script>
var FilterPlayers = function(){
   
	var baseurl = "<?php echo base_url();?>";

		var Match_type = $('#match_type').val();
		
		var Sport = $("#sport").val();

		var Age_group = [];
        $("input[name='age_group[]']:checked").each(function(i){
          Age_group[i] = $(this).val();
        });

		var Level = [];
        $("input[name='level[]']:checked").each(function(i){
          Level[i] = $(this).val() ;
        });

		var Gender = [];
        $("input[name='gender[]']:checked").each(function(i){
          Gender[i] = $(this).val();
        });

		var Tourn_id = $('#tourn_id').val();

        if(Match_type!=""){
		
            $.ajax({
                type:'POST',
                url:baseurl+'league/age_group_users/',
				data:{gender:Gender,age_group:Age_group,match_type:Match_type,tourn_id:Tourn_id,sport:Sport,level:Level},
                success:function(html){
                    $('#age_group_users').html(html);
                }
            }); 
        }
  }

</script>

   <section id="single_player" class="container secondary-page">

           <div class="top-score-title right-score col-md-9">
             <h3 style="text-align:left">Create Draws</h3>

				<?php 
				if(isset($exist)) { ?>
				<div class="name" align='left'>
				<label for="name_login" style="color:red"><?php echo $exist; ?></label>
				</div>
				<?php } ?>

			 <!-- start main body -->

			<?php
			if($tourn_det)
			{
			?>
			<form class="form-horizontal" id='myform' method='post' role="form"  
			action="<?php echo base_url().$this->short_code; ?>/league/bracket/<?php echo $tourn_det['tournament_ID']; ?>"> 

				<input type="hidden" id="tourn_id" name="tourn_id" value="<?php echo $tourn_det['tournament_ID']; ?>" /> 
           
				   <div class="col-md-12 league-form-bg" style="margin-top:30px;">
						<div class="fromtitle">Bracket / Draws</div>
						
					<div class='form-group'>
						<label class='control-label col-md-3' for='id_accomodation'>Tournament: </label>
						<div class='col-md-6 form-group internal'>
						<?php echo $tourn_det['tournament_title'] ;?>
						</div>
					</div>

					<div class='form-group'>
						<label class='control-label col-md-3' for='id_accomodation'>Game Type: </label>
						<div class='col-md-6 form-group internal'>
						<?php $sport_name = league::get_sport($tourn_det['SportsType']);
						  echo $sport_name['Sportname'];
						?>
						<input type='hidden' id='sport' name='sport' value='<?php echo $tourn_det['SportsType']; ?>' />
						</div>
					</div>
				
					<div class='form-group'>
						<label class='control-label col-md-3' for='id_accomodation'> Type of Bracket generation: </label>
						<div class='col-md-6 form-group internal'>
						
						<select class="form-control ajax_blur" name="types" id="match_type" style="width:35%" required>
							<?php
								$types= array();
								$types = json_decode($tourn_det['Singleordouble']);
							?>
							<?php 
							foreach($types as $type){ ?>
							<option value="<?php echo $type; ?>"><?php echo $type; ?></option>
							<?php } ?>
						</select>
						
						</div>
					</div>

					<div class='form-group'>
					<label class='control-label col-md-3' for='id_accomodation'> Levels: </label>
					<div class='col-md-6 form-group internal'>

					<?php 
					$level_array = array();
					if($tourn_det['Sport_levels']!="")
					{
					$level_array = json_decode($tourn_det['Sport_levels']);
					foreach($level_array as $row){ ?>

					<input type="checkbox"  name="level[]" class='ajax_blur' value="<?php echo $row; ?>" /> 
					<?php $get_level = league::get_level_name($tourn_det['SportsType'],$row);
					echo $get_level['SportsLevel']; ?> &nbsp;

					<?php 
					} 
					}
					?>
					</div>
			     </div>

					<div class='form-group'>
					<label class='control-label col-md-3' for='id_accomodation'> Age Group: </label>
					<div class='col-md-6 form-group internal'>

					<?php 
					$option_array = array();
					if($tourn_det['Age'] != ""){
					$option_array	= json_decode($tourn_det['Age']);
					$numItems		= count($option_array);
					$i = 0;
					if($numItems > 0){
					
					foreach($option_array as $group){
					switch ($group){
					case "U12":
					echo "<input type='checkbox' class='ajax_blur' id='Age_group' name='age_group[]' value=".$group."  /> Under 12 &nbsp";
					break;
					case "U14":
					echo "<input type='checkbox' class='ajax_blur' id='Age_group' name='age_group[]' value=".$group."  /> Under 14 &nbsp";
					break;
					case "U16":
					echo "<input type='checkbox' class='ajax_blur' id='Age_group' name='age_group[]' value=".$group."  /> Under 16 &nbsp";
					break;
					case "U18":
					echo "<input type='checkbox' class='ajax_blur' id='Age_group' name='age_group[]' value=".$group."  /> Under 18 &nbsp";
					break;
					case "Adults":
					echo "<input type='checkbox' class='ajax_blur' id='Age_group' name='age_group[]' value=".$group."  /> Adults &nbsp";
					break;
					case "Adults_30p":
					echo "<input type='checkbox' class='ajax_blur' id='Age_group' name='age_group[]' value=".$group."  /> 30s &nbsp";
					break;
					case "Adults_40p":
					echo "<input type='checkbox' class='ajax_blur' id='Age_group' name='age_group[]' value=".$group."  /> 40s &nbsp";
					break;
					case "Adults_50p":
					echo "<input type='checkbox' class='ajax_blur' id='Age_group' name='age_group[]' value=".$group."  /> 50s &nbsp";
					break;
					case "Adults_veteran":
					echo "<input type='checkbox' class='ajax_blur' id='Age_group' name='age_group[]' value=".$group."  /> Veteran &nbsp";
					break;
					default:
					echo "";
					}
				  }
	             } } ?>

					</div>
			     </div>

					<div class='form-group'>
						<label class='control-label col-md-3' for='id_accomodation'> Gender: </label>
						<div class='col-md-6 form-group internal'>
						<input type="checkbox" class='ajax_blur' name="gender[]" id="gend" value="1"> Male &nbsp;&nbsp;
						<input type="checkbox" class='ajax_blur' name="gender[]" id="gend" value="0"> Female 
						</div>
					</div>
					
					<div class='form-group'>
						<label class='control-label col-md-3' for='id_accomodation'> Bracket Type: </label>
						<div class='col-md-6 form-group internal'>
						<select class="form-control" name="ttype" id="ttype" style="width:35%" required>
							<option value="Single Elimination" 
							<?php if($tourn_det['Tournament_type'] == 'Single Elimination') { echo "selected"; } ?>>Single Elimination</option>
							<option value="Consolation" 
							<?php if($tourn_det['Tournament_type'] == 'Consolation') { echo "selected"; } ?>>Consolation</option>
							<option value="Round Robin" 
							<?php if($tourn_det['Tournament_type'] == 'Round Robin') { echo "selected"; } ?>>Round Robin</option>
						</select>

						<?php //echo $tourn_det['Tournament_type']; ?>
						<!-- <input type = 'hidden' name='ttype' value='<?php echo $tourn_det['Tournament_type']; ?>' /> -->
						</div>
					</div>


				<div class='form-group'>
				<label class='control-label col-md-3' for='id_accomodation'>Registered Players:</label> 
				<div class='col-md-7 form-group internal'>
				<div id="age_group_users">
					
				<!-- -------------------	for single players -------------------------------------------------------------- -->
	
					<select id='a' name='users[]' multiple style="width:100%;height:200pt;" required>
					<?php
					 if(isset($tourn_single_users)){ ?>
					<?php 
					if(count($tourn_single_users) != 0){
						foreach($tourn_single_users as $row)
						{
						$user_a2msocre = league::get_a2mscore($row->Users_ID, $tourn_det['SportsType']);
						$user_score = $user_a2msocre['A2MScore']; 
						?>
						<option value=<?php echo $row->Users_ID; ?>><?php echo $row->Firstname.' '.$row->Lastname.' ('.$user_score.')'; ?></option>
						<?php 							
						}
					}
					else{
					?>
					<option value="" disabled>No Registered Users. </option>	
				<?php } } ?>

			<!-- -------------------for double players	-------------------------------------------------------------- -->

			<?php if(isset($tourn_double_users)){ 

			if(count($tourn_double_users) != 0)
			{
				$partner_arr = array();

				foreach($tourn_double_users as $row) 
				{
					$user = league::get_username($row->Users_ID);
					$user_name = $user['Firstname'] . ' ' . $user['Lastname'];

					$user_a2msocre = league::get_a2mscore($row->Users_ID, $tourn_det['SportsType']);
					$user_score = $user_a2msocre['A2MScore'];

					$partner = league::get_username($row->Partner1);
					$partner_name = $partner['Firstname'] . ' ' . $partner['Lastname'];

					$partner_a2msocre = league::get_a2mscore($row->Partner1, $tourn_det['SportsType']);
					$partner_score = $partner_a2msocre['A2MScore'];

					
					$partner_arr[] = $row->Partner1;

					if(!in_array($row->Users_ID, $partner_arr)){
					//$box = "<input type='text' name='first' value='".$partner_name."'>";
					?>
				<option value="<?php echo $row->Users_ID."-".$row->Partner1 ?>" <?php if(!$row->Partner1) { echo "readonly='readonly'"; } ?>><?php echo $user_name. ' (' . $user_score . ')' . " - " .  $partner_name  . ' (' . $partner_score . ')'; ?></option>
				<?php
					}
			    }
					
			}
			else{
				?>
				 <option value="" disabled>No Registered Users. </option>	
			<?php
			 } } ?>

					</select>							

							<br><br>
							Move <a onclick="listbox_move('a', 'up')" style='cursor:pointer'>UP</a>,
							<a onclick="listbox_move('a', 'down')" style='cursor:pointer'>DOWN</a>

							&nbsp;&nbsp;&nbsp;

							Select
							<a  onclick="listbox_selectall('a', true)" style='cursor:pointer'>All</a>,
							<a  onclick="listbox_selectall('a', false)" style='cursor:pointer'>None</a>	
						</div>
					  </div>
					</div>
					  
					  <br />
					  <div class='form-group'>
						<label class='control-label col-md-3' for='id_accomodation'></label>
						<div class='col-md-7 form-group internal'>
						  <input type="submit" name='generate' value="Generate" class="league-form-submit"/>
						</div>
					  </div>
					</div>
           	 </form>

			 <?php 
			}
			else
			{ 
			?>
				<p style="line-height:20px; font-size:13px"><h5>Oops! Invalid Access. Please contact admin@a2msports.com</h5></p>
			<?php
			}
			?>

			 <!-- end main body -->
             
           </div><!--Close Top Match--> 