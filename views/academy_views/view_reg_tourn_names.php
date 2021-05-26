<script>
	$(document).ready(function(){ 
		$("#sel_all").change(function(){
		  $(".checkbox1").prop('checked', $(this).prop("checked"));
		  });
	});
	</script>

<script>
$(document).ready(function(){
		$('#show_box').click(function() {
		$('#show_msg').show();
		 $('#show_box').hide();
    });

	$('#cancel_msg').click(function() {
		$('#show_msg').hide();
		$('#show_box').show();
		 $("#uncheck").prop("checked", false);
    });
	
 });
</script>





	<table class="tab-score">
	<tr>
	<th width="10%" class="score-position"><input type='checkbox' name="sel_all" id="sel_all" /></th>
	<th width="32%">Name</th>
	<th width="30%">Match Format</th>
	<th width="15%">Age Group</th>
	<th width="15%">Level</th>
	</tr>

	
	<?php
	if(count(array_filter($tourn_reg_names)) > 0) {

		foreach($tourn_reg_names as $name)
		{
		?>
		<tr>

		<td><input class="checkbox1" type="checkbox" name="sel_player[]" value="<?php echo $name->Users_ID;?>" style="margin-left:10px" /></td>
		<td><?php 
			$player = league::get_username($name->Users_ID);
			echo "<b>" . $player['Firstname'] . " " . $player['Lastname'] . "</b>";
			?>
		</td>

		<td>  <?php 
				$match_array = array();
				if($name->Match_Type != "")
				{
				$match_array = json_decode($name->Match_Type);
				$numItems = count($match_array);

				if($numItems > 0)
				{
					foreach($match_array as $i => $group)
					{
						echo $group;
						if(++$i!=count($match_array)){
							echo ", ";
						}
					}
				}
				}
				?> 
		</td>
		<td> <?php switch ($name->Reg_Age_Group){
				case "U12":
				echo "Under 12";
				break;
				case "U14":
				echo "Under 14";
				break;
				case "U16":
				echo "Under 16";
				break;
				case "U18":
				echo "Under 18";
				break;
				case "Adults":
				echo "Adults ";
				break;
				case "Adults_30p":
				echo "30s";
				break;
				case "Adults_40p":
				echo "40s";
				break;
				case "Adults_50p":
				echo "50s";
				break;
				case "Adults_veteran":
				echo "Veteran";
				break;
				default:
				echo "";
				} ?> </td>
			<td>
			<?php
			$get_sport = league::getonerow($name->Tournament_ID);
			$get_level = league::get_level_name($get_sport->SportsType,$name->Reg_Sport_Level);
			echo $get_level['SportsLevel']; ?>
			</td>
		
		</tr>
		<?php
		}
	?>
	<tr>
	
	</tr>
	<?php
	}
	else {
	?>
	<tr><td colspan='6'><b>No Players Found. </b></td></tr>
	<?php
	}
	?>
	</table>
	
	<div style="clear:both"></div>
	<div class="col-md-8">
	<?php 	if(count($tourn_reg_names) > 0) { ?>
		<div class='col-md-8' id="show_box"><br /><br /><input type="checkbox" class="show_des" id="uncheck" name="show_des"  value="" />Send Email Message to the Players.
		<br /><br />
		</div> 
		<?php } ?>
	